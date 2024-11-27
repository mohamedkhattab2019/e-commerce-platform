# Laravel Project Setup Guide

Follow these steps to set up and run the Laravel project on your local machine:

---

## **Clone the Repository**
1. Clone the repository from GitHub:
   ```bash
   git clone https://github.com/mohamedkhattab2019/e-commerce-platform.git
   ```
2. Navigate to the project directory:
```bash
cd e-commerce-platform
```
## **Install Dependencies**
1. Install PHP dependencies using Composer:
```bash
composer install
```
## **Environment Configuration**
1. Create the .env file by copying .env.example:
```bash
cp .env.example .env
```
2. Open the .env file in a text editor and update the following as needed:

    * Database Settings:
        ```env
        DB_DATABASE=your_database_name
        DB_USERNAME=your_database_user
        DB_PASSWORD=your_database_password
        ```
    * Application URL:
        ```env
        APP_URL=http://127.0.0.1:8000
        ```
    * Payment Gateway Secret Key (STRIPE_SECRET):
        ```env
        STRIPE_SECRET=
        ```

## **Run Database Migrations**
1. Run the migrations to set up the database schema:
2. (Optional) Seed the database with sample data:

```bash
php artisan migrate
php artisan db:seed
```

## **Create Storage Link**
Create a symbolic link for the storage directory to serve uploaded files:
```bash 
php artisan storage:link
```

Start the Laravel development server:
```bash
php artisan serve
```