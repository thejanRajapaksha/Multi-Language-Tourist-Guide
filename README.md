# 🌍 Multi-Language Tourist Guide with Predictive Analysis of Tourist Spending and Tax Contributions in Sri Lanka

A full-stack Laravel + Python-based system that helps tourists navigate Sri Lanka using multilingual support while capturing their spending behavior and predicting tax contributions using machine learning.

---

## 🌐 Live Preview
👉 [**View the Hosted Project**](https://16.171.148.2/)

---

## 🧰 Technologies Used

- **Laravel** (PHP Framework)
- **MySQL** (Database)
- **Python 3** with:
  - `pandas`
  - `scikit-learn`
  - `matplotlib`
  - `seaborn`
- **Google Translate API**
- **OpenStreetMap + Leaflet.js**
- **Bootstrap 5** (UI)

---

## 🚀 Features

- Multi-language interface for tourists  
- Tourist and business user registration  
- Business users can report tourist spendings + tax status  
- Government dashboard with real-time graphs  
- Predictive machine learning for spending and tax  
- Auto-triggered ML script on data entry  

---

## ⚙️ Local Setup Instructions

### 1. 📥 Clone the Repository
    git clone https://github.com/your-username/multi-language-tourist-guide.git
    cd multi-language-tourist-guide

### 2. 🧱 Laravel Installation
    composer install
    cp .env.example .env
    php artisan key:generate

### 3. Python libraries Installation
    pip install pandas scikit-learn matplotlib seaborn numpy
    pip install statsmodels

### 4. Update .env with your local DB:
    DB_DATABASE=your_database
    DB_USERNAME=your_user
    DB_PASSWORD=your_password

### 5. Run:
    php artisan migrate
    php artisan serve
