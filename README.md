🌐 Live Demo
You can view the live deployed version of the project here:
https://16.171.148.2/

🛠️ Project Setup Instructions – Multi-Language Tourist Guide
🔧 Prerequisites
Ensure the following are installed on your system:

XAMPP (PHP & MySQL)

Composer

Python (>= 3.7)

Git (if composer tries to download packages from source)

📦 Laravel Setup Instructions
Navigate to the project directory

bash
Copy
Edit
cd Multi-Language-Tourist-Guide
Install PHP dependencies using Composer

bash
Copy
Edit
composer install
If you see errors related to missing zip, ensure:

PHP zip extension is enabled in php.ini

Git is added to your system’s PATH

Copy .env file

bash
Copy
Edit
cp .env.example .env
Generate application key

bash
Copy
Edit
php artisan key:generate
Set up the database

Create a new MySQL database (e.g., tourist_guide)

Update the .env file with your DB credentials:

env
Copy
Edit
DB_DATABASE=tourist_guide
DB_USERNAME=root
DB_PASSWORD=
Run database migrations (if needed)

bash
Copy
Edit
php artisan migrate
Start the Laravel server (local only)

bash
Copy
Edit
php artisan serve
🧠 Machine Learning Setup (Python)
Navigate to the ML directory

bash
Copy
Edit
cd ml
Install required Python packages
Run the following commands in the terminal:

bash
Copy
Edit
pip install pandas
pip install matplotlib
pip install scikit-learn
pip install statsmodels
pip install xgboost
Run the ML script

bash
Copy
Edit
python ml_model.py
🌍 Deployment Notes (for AWS or Remote Access)
If you plan to access this Laravel app from the internet (e.g., via AWS EC2):

Ensure ports (e.g., 80, 443, 8000) are open in your EC2 Security Group

Point your Laravel app to use Apache or Nginx (not php artisan serve) for production

(Optional) Set up a domain and SSL using Let's Encrypt or another provider