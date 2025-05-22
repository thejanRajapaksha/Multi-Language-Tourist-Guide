import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import seaborn as sns
import os
import json
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression
from sklearn.cluster import KMeans
from sklearn.metrics import r2_score
from statsmodels.tsa.arima.model import ARIMA
import statsmodels.api as sm
import xgboost as xgb
from sklearn.metrics import root_mean_squared_error, mean_absolute_error

# Define BASE_DIR manually for compatibility
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
tourists_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "tourists.csv")
spending_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "business_records.csv")
output_dir = os.path.join(BASE_DIR, "public", "ml_graphs")
os.makedirs(output_dir, exist_ok=True)

# Load datasets
tourists_df = pd.read_csv(tourists_csv)
spending_df = pd.read_csv(spending_csv)
spending_df["date_time"] = pd.to_datetime(spending_df["date_time"], errors="coerce")
merged_df = pd.merge(spending_df, tourists_df, on="passport_number", how="left")
merged_df["stay_duration_days"] = pd.to_numeric(merged_df["stay_duration_days"], errors="coerce")

# Save processed data
merged_df.to_csv(os.path.join(output_dir, "processed_data.csv"), index=False)

# Select relevant X and Y variable, dropping any rows with missing values
X = merged_df[["stay_duration_days", "income_amount"]].dropna()
Y = merged_df.loc[X.index, "spending_amount"]

r2 = None  # Initialize R² score

if not X.empty and not Y.empty:
    # Initialize and train the linear regression model
    model = xgb.XGBRegressor(objective='reg:squarederror', random_state=42)
    model.fit(X, Y)

    # Make predictions
    predictions = model.predict(X)

    # Sort values by index for line plot continuity
    sorted_indices = np.argsort(Y.index)
    sorted_actual = Y.iloc[sorted_indices].values
    sorted_predicted = predictions[sorted_indices]

    # Line plot of actual and predicted spending
    plt.figure(figsize=(8, 5))
    plt.plot(sorted_actual, label="Actual Spending", linewidth=2)
    plt.plot(sorted_predicted, label="Predicted Spending", linewidth=2, linestyle='--')
    plt.xlabel("Record Index (sorted)")
    plt.ylabel("Spending Amount")
    plt.title("Regression: Actual vs Predicted Spending (Line Plot)")
    plt.legend()
    plt.tight_layout()

    # Save the plot
    plot_path = os.path.join(output_dir, "regression_spending_prediction_lineplot.png")
    plt.savefig(plot_path)
    plt.close()

    # Calculate and print R² score
    r2 = r2_score(Y, predictions)
    print(f"Regression completed. R² Score: {r2:.4f}")
else:
    print("Skipping regression: insufficient valid data.")

# TIME SERIES (ARIMA)
try:
    ts_df = spending_df.set_index("date_time")
    monthly_series = ts_df["spending_amount"].resample("M").sum()

    # Train-test split (last 6 months for testing)
    train = monthly_series[:-6]
    test = monthly_series[-6:]

    # Fit ARIMA model on training data
    arima_model = ARIMA(train, order=(0, 0, 1)).fit()
    forecast_test = arima_model.forecast(steps=6)
    forecast_test.index = test.index

    # Compute MAE, RMSE, MAPE
    mae = mean_absolute_error(test, forecast_test)
    rmse = root_mean_squared_error(test, forecast_test)

    if (test == 0).any():
        nonzero_mask = test != 0
        mape = np.mean(np.abs((test[nonzero_mask] - forecast_test[nonzero_mask]) / test[nonzero_mask])) * 100 \
            if nonzero_mask.sum() > 0 else "N/A"
    else:
        mape = np.mean(np.abs((test - forecast_test) / test)) * 100

    # Re-train on full data for next 6-month forecast
    final_model = ARIMA(monthly_series, order=(0, 0, 1)).fit()
    forecast_next6 = final_model.forecast(steps=6)

    # Create combined plot
    plt.figure(figsize=(10, 5))
    monthly_series.plot(label="Actual", color="blue")
    forecast_test.plot(label="Predicted Last 6 Months", color="orange", linestyle="--")
    forecast_next6.index = pd.date_range(start=monthly_series.index[-1] + pd.offsets.MonthBegin(1), periods=6, freq="M")
    forecast_next6.plot(label="Forecast Next 6 Months", color="green", linestyle="--")
    plt.legend()
    plt.title("Spending Forecast: Past vs Future (ARIMA)")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "arima_spending_forecast.png"))
    plt.close()

    forecast_total = float(forecast_next6.sum())  # Only future forecast total
except Exception as e:
    print("Skipping ARIMA forecast:", e)
    forecast_total = 0.0
    mape = "N/A"


# CLUSTERING: Tourists by Spending
X_cluster = merged_df[["stay_duration_days", "income_amount", "spending_amount"]].dropna()
cluster_count = 0
if not X_cluster.empty:
    kmeans = KMeans(n_clusters=3, random_state=42)
    merged_df["spending_cluster"] = kmeans.fit_predict(X_cluster)
    cluster_count = 3

    plt.figure(figsize=(8, 5))
    sns.scatterplot(data=merged_df, x="income_amount", y="spending_amount", hue="spending_cluster", palette="viridis")
    plt.title("Clustering Tourists by Spending")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "spending_clusters.png"))

# CLUSTERING: Per Tourist
total_spent = merged_df.groupby("passport_number")["spending_amount"].sum().reset_index()
total_spent.columns = ["passport_number", "total_spent"]

if not total_spent.empty:
    kmeans = KMeans(n_clusters=3, random_state=42)
    total_spent["cluster"] = kmeans.fit_predict(total_spent[["total_spent"]])

    plt.figure(figsize=(8, 5))
    sns.scatterplot(data=total_spent, x="passport_number", y="total_spent", hue="cluster", palette="viridis")
    plt.xlabel("Tourists")
    plt.ylabel("Total Spending")
    plt.title("Clustering Tourists by Total Spending")
    plt.xticks([])
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "tourist_clusters_total_spending.png"))

# INCOME vs SPENDING REGRESSION
merged_total = pd.merge(tourists_df, total_spent, on="passport_number", how="left").fillna(0)
try:
    X_income = sm.add_constant(merged_total["income_amount"])
    y_spent = merged_total["total_spent"]
    ols_model = sm.OLS(y_spent, X_income).fit()
    predictions = ols_model.predict(X_income)

    plt.figure(figsize=(8, 5))
    plt.scatter(merged_total["income_amount"], y_spent, alpha=0.5)
    plt.plot(merged_total["income_amount"], predictions, color="red")
    plt.xlabel("Income Amount")
    plt.ylabel("Total Spending")
    plt.title("Impact of Tourist Income on Spending")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "income_vs_spending.png"))

    # Calculate and print R² score
    # r2 = r2_score(y_spent, predictions)
    # print(f"Regression completed. R² Score: {r2:.4f}")

except Exception as e:
    print("Skipping income vs spending regression:", e)

# TAX COMPARISON (LAST 6 MONTHS)
try:
    # Get the most recent date in your dataset
    latest_date = merged_df['date_time'].max()
    
    # Calculate the date 6 months prior to the latest date
    six_months_ago = latest_date - pd.DateOffset(months=6)
    
    # Filter data for the last 6 months
    last_six_months = merged_df[merged_df['date_time'] >= six_months_ago]
    
    # Convert "Yes"/"No" to 1/0 for consistent grouping
    last_six_months['tax_numeric'] = last_six_months['tax_included'].map({'Yes': 1, 'No': 0})
    
    tax_summary = last_six_months.groupby("tax_numeric")["spending_amount"].sum().reset_index()
    
    # Create mapping for visualization labels
    tax_labels = {1: "Yes", 0: "No"}
    tax_summary['tax_label'] = tax_summary['tax_numeric'].map(tax_labels)
    
    plt.figure(figsize=(6, 4))
    sns.barplot(x="tax_label", y="spending_amount", data=tax_summary,
                hue="tax_label", palette={"No": "red", "Yes": "green"})
    plt.xlabel("Was Tax Included?")
    plt.ylabel("Total Spending (LKR)")
    plt.title("Spending: Tax Included vs Excluded (Last 6 Months)")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "tax_included_comparison_last6months.png"))
    
    # Create dictionary with numeric keys for the summary
    tax_data = tax_summary.set_index("tax_numeric")["spending_amount"].to_dict()
    tax_period_str = f"{six_months_ago.date()} to {latest_date.date()}"
    
    # Print debug info
    print(f"Tax data for last 6 months ({six_months_ago.date()} to {latest_date.date()}):")
    print(tax_summary)
except Exception as e:
    print("Skipping tax comparison for last 6 months:", e)
    tax_data = {0: 0, 1: 0}

# COUNTRY-WISE SPENDING
top_country = "N/A"

if "country" in merged_total.columns:
    try:
        # Remove 'Sri Lanka' rows
        filtered_df = merged_total[merged_total["country"].str.strip().str.lower() != "sri lankan"]

        country_spending = filtered_df.groupby("country")["total_spent"].sum().reset_index()
        if not country_spending.empty:
            top_country = country_spending.sort_values("total_spent", ascending=False).iloc[0]["country"]

        plt.figure(figsize=(8, 5))
        sns.barplot(x="country", y="total_spent", data=country_spending, palette="Blues")
        plt.xlabel("Country")
        plt.ylabel("Total Spending")
        plt.title("Spending by Country (Excluding Sri Lanka)")
        plt.xticks(rotation=45)
        plt.tight_layout()
        plt.savefig(os.path.join(output_dir, "countrywise_spending.png"))

    except Exception as e:
        print("Skipping country-wise spending:", e)

# Monthly Spending Trends
merged_df["date_time"] = pd.to_datetime(merged_df["date_time"])
monthly_spending = merged_df.resample("M", on="date_time")["spending_amount"].sum()

plt.figure(figsize=(10, 5))
monthly_spending.plot(marker='o', linestyle='-', color='purple')
plt.xlabel("Month")
plt.ylabel("Total Spending (LKR)")
plt.title("Monthly Spending Trends")
plt.grid(True)
plt.tight_layout()
plt.savefig(os.path.join(output_dir, "line_monthly_spending.png"))
plt.close()

# Spending Distribution by Business Category
category_spending = merged_df.groupby("business_category")["spending_amount"].sum()
plt.figure(figsize=(8, 6))
category_spending.plot.pie(autopct='%1.1f%%', startangle=140, shadow=True)
plt.ylabel('')
plt.title("Spending Distribution by Business Category")
plt.tight_layout()
plt.savefig(os.path.join(output_dir, "pie_spending_category.png"))
plt.close()

# Compare Spending Across Categories
plt.figure(figsize=(10, 6))
sns.barplot(x=category_spending.index, y=category_spending.values, palette="Set2")
plt.xlabel("Business Category")
plt.ylabel("Total Spending (LKR)")
plt.title("Total Spending by Business Category")
plt.xticks(rotation=45)
plt.tight_layout()
plt.savefig(os.path.join(output_dir, "bar_spending_category.png"))
plt.close()

# ANALYSIS SUMMARY JSON
analysis_summary = {
    "regression_r2": round(r2, 2) if r2 is not None else "N/A",
    "arima_forecast_total": round(forecast_total, 2),
    "arima_accuracy": round(mape, 2),
    "tax_included": round(tax_data.get(1, 0), 2),
    "tax_excluded": round(tax_data.get(0, 0), 2),
    "tax_period": tax_period_str,
    "top_country": top_country,
    "cluster_count": cluster_count
}

with open(os.path.join(output_dir, "analysis_summary.json"), "w") as f:
    json.dump(analysis_summary, f)

plt.close("all")
