import pandas as pd
import os

# Base path where Laravel lives
BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# Full path to the CSVs
tourists_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "tourists.csv")
spending_csv = os.path.join(BASE_DIR, "storage", "app", "python-input", "business_records.csv")

# Load CSVs
tourists = pd.read_csv(tourists_csv)
spendings = pd.read_csv(spending_csv)

# Example: Total spending per country
merged = pd.merge(spendings, tourists, on="passport_number", how="left")
result = merged.groupby("country")["spending_amount"].sum().sort_values(ascending=False)

# Save graph
plt.figure(figsize=(10, 5))
result.plot(kind='bar', color='skyblue')
plt.title("Total Spending by Country")
plt.xlabel("Country")
plt.ylabel("Spending Amount (LKR)")
plt.tight_layout()
plt.savefig("public/ml_graphs/spending_by_country.png")
