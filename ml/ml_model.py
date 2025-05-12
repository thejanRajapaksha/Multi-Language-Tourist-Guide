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

# Define BASE_DIR manually for compatibility
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
tourists_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "tourists.csv")
spending_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "business_records.csv")
output_dir = os.path.join(BASE_DIR, "public", "ml_graphs")
os.makedirs(output_dir, exist_ok=True)

# Load datasets
tourists_df = pd.read_csv(tourists_csv)
spending_df = pd.read_csv(spending_csv)
spending_df["date_time"] = pd.to_datetime(spending_df["date_time"])
merged_df = pd.merge(spending_df, tourists_df, on="passport_number", how="left")
merged_df["stay_duration_days"] = pd.to_numeric(merged_df["stay_duration_days"], errors="coerce")

# Save processed data
merged_df.to_csv(os.path.join(output_dir, "processed_data.csv"), index=False)

# REGRESSION
X = merged_df[["stay_duration_days", "income_amount"]].dropna()
y = merged_df.loc[X.index, "spending_amount"]
r2 = None

if not X.empty and not y.empty:
    model = LinearRegression()
    model.fit(X, y)
    predictions = model.predict(X)

    plt.figure(figsize=(6, 4))
    plt.scatter(y, predictions, alpha=0.6)
    plt.xlabel("Actual Spending")
    plt.ylabel("Predicted Spending")
    plt.title("Regression: Actual vs Predicted Spending")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "regression_spending_prediction.png"))

    r2 = r2_score(y, predictions)
else:
    print("Skipping regression: no valid data")

# TIME SERIES (ARIMA)
try:
    ts_df = spending_df.set_index("date_time")
    monthly_series = ts_df["spending_amount"].resample("M").sum()
    arima_model = ARIMA(monthly_series, order=(5, 1, 0)).fit()
    forecast = arima_model.forecast(steps=6)

    plt.figure(figsize=(10, 4))
    monthly_series.plot(label="Actual", color="blue")
    forecast.plot(label="Forecast", linestyle="--", color="red")
    plt.legend()
    plt.title("6-Month Spending Forecast (ARIMA)")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "arima_spending_forecast.png"))
    forecast_total = float(forecast.sum())
except Exception as e:
    print("Skipping ARIMA forecast:", e)
    forecast_total = 0.0

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
except Exception as e:
    print("Skipping income vs spending regression:", e)

# TAX COMPARISON
try:
    tax_summary = merged_df.groupby("tax_included")["spending_amount"].sum().reset_index()
    plt.figure(figsize=(6, 4))
    sns.barplot(x="tax_included", y="spending_amount", data=tax_summary, palette=["red", "green"])
    plt.xlabel("Was Tax Included?")
    plt.ylabel("Total Spending (LKR)")
    plt.title("Spending: Tax Included vs Excluded")
    plt.tight_layout()
    plt.savefig(os.path.join(output_dir, "tax_included_comparison.png"))

    tax_data = tax_summary.set_index("tax_included")["spending_amount"].to_dict()
except Exception as e:
    print("Skipping tax comparison:", e)
    tax_data = {0: 0, 1: 0}

# COUNTRY-WISE SPENDING
top_country = "N/A"
if "country" in merged_total.columns:
    try:
        country_spending = merged_total.groupby("country")["total_spent"].sum().reset_index()
        if not country_spending.empty:
            top_country = country_spending.sort_values("total_spent", ascending=False).iloc[0]["country"]
        plt.figure(figsize=(8, 5))
        sns.barplot(x="country", y="total_spent", data=country_spending, palette="Blues")
        plt.xlabel("Country")
        plt.ylabel("Total Spending")
        plt.title("Spending by Country")
        plt.xticks(rotation=45)
        plt.tight_layout()
        plt.savefig(os.path.join(output_dir, "countrywise_spending.png"))
    except Exception as e:
        print("Skipping country-wise spending:", e)

# ANALYSIS SUMMARY JSON
analysis_summary = {
    "regression_r2": round(r2, 2) if r2 is not None else "N/A",
    "arima_forecast_total": round(forecast_total, 2),
    "tax_included": round(tax_data.get(1, 0), 2),
    "tax_excluded": round(tax_data.get(0, 0), 2),
    "top_country": top_country,
    "cluster_count": cluster_count
}

with open(os.path.join(output_dir, "analysis_summary.json"), "w") as f:
    json.dump(analysis_summary, f)

plt.close("all")
