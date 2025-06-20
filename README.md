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

### For Users:
- **Secure Authentication**: Manual login, registration, and logout system.
- **Dashboard**: An at-a-glance summary of monthly income, expenses, and total balance. Includes a 30-day expense chart powered by Chart.js and financial insights like the top spending category.
- **Account Management**: CRUD functionality to manage various financial accounts (e.g., Bank, E-Wallet, Cash).
- **Transaction Tracking**: Full CRUD for logging income and expense transactions, which automatically update account balances. Includes filtering by month, year, and category.
- **Budgeting**: Set monthly spending limits for different expense categories and track progress.
- **Category Management**: Users can define their own personal spending/income categories.

### For Admins:
- **Admin Panel**: A separate section for site administration.
- **User Management**: Full CRUD capabilities to manage all registered users.
- **Global Category Management**: Admins can create and manage a set of default categories available to all users.

## Technology Stack

- **Backend**: Laravel 10, PHP
- **Frontend**: Blade, Tailwind CSS, Vite.js, Chart.js
- **Database**: MySQL (or any Laravel-supported SQL database)

## Getting Started

Follow these instructions to get the project up and running on your local machine.

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- A database server (e.g., MySQL, MariaDB)

### Installation Steps

1.  **Clone the repository:**
    ```bash
    git clone https://github.com/your-username/fintrack-id.git
    cd fintrack-id
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install NPM dependencies:**
    ```bash
    npm install
    ```

4.  **Set up your environment file:**
    Copy the example `.env` file and generate an application key.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Configure your database:**
    Open the `.env` file and set your database connection details (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

6.  **Run the database migrations and seeders:**
    This will create the necessary tables and populate them with default global categories and two sample users (an admin and a regular user).
    ```bash
    php artisan migrate --seed
    ```

7.  **Build frontend assets:**
    ```bash
    npm run dev
    ```

8.  **Serve the application:**
    ```bash
    php artisan serve
    ```
    The application will be available at `http://127.0.0.1:8000`.

### Default Login Credentials

The database seeder creates two users for you to test with:

-   **Admin User**
    -   **Email**: `admin@fintrack.id`
    -   **Password**: `password`

-   **Regular User**
    -   **Email**: `user@fintrack.id`
    -   **Password**: `password`
