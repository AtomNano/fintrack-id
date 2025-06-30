# FinTrack ID - Personal Finance Manager

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>
<p align="center">
  <strong>A personal finance management application built with the Laravel Framework.</strong>
</p>

---

## About FinTrack ID

FinTrack ID is a web-based application designed to help users track their income and expenses, manage their financial accounts, and set monthly budgets to stay on top of their financial goals. The application features a clean, intuitive interface for both regular users and administrators.

This project was built from scratch using Laravel 10 without any starter kits like Breeze or Jetstream, focusing on a manual implementation of core features.

## Key Features

### For Users
- **Secure Authentication:** Manual login, registration, and logout system.
- **Dashboard:** Summary of monthly income, expenses, and total balance. Includes a 30-day expense chart (Chart.js) and financial insights.
- **Account Management:** CRUD for various financial accounts (Bank, E-Wallet, Cash, etc).
- **Transaction Tracking:** Full CRUD for income and expense transactions, with automatic account balance updates. Filter by month, year, and category.
- **Budgeting:** Set monthly spending limits for each expense category and track progress.
- **Category Management:** Users can define their own personal spending/income categories.

### For Admins
- **Admin Panel:** Separate section for site administration.
- **User Management:** Full CRUD for all registered users.
- **Global Category Management:** Admins can create and manage default categories available to all users.

## Technology Stack

- **Backend:** Laravel 10, PHP
- **Frontend:** Blade, Tailwind CSS, Vite.js, Chart.js
- **Database:** MySQL (or any Laravel-supported SQL database)

## Getting Started

Follow these steps to set up the project locally.

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- Database server (MySQL, MariaDB, etc.)

### Installation Steps

1. **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/fintrack-id.git
    cd fintrack-id
    ```

2. **Install PHP dependencies:**
    ```bash
    composer install
    ```

3. **Install NPM dependencies:**
    ```bash
    npm install
    ```

4. **Set up your environment file:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure your database:**
    Edit `.env` and set your database connection (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6. **Run migrations and seeders:**
    This will create tables and populate them with default global categories and two sample users (admin and regular user).
    ```bash
    php artisan migrate --seed
    ```

7. **Build frontend assets:**
    ```bash
    npm run dev
    ```

8. **Serve the application:**
    ```bash
    php artisan serve
    ```
    The app will be available at [http://127.0.0.1:8000](http://127.0.0.1:8000).

### Default Login Credentials

Seeder creates two users for testing:

- **Admin User**
    - Email: `admin@fintrack.id`
    - Password: `password`
- **Regular User**
    - Email: `user@fintrack.id`
    - Password: `password`