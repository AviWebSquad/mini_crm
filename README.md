# Mini ERP

Basic ERP System with focus on Inventory and Sales functionality.

#Core Features
1. Authentication &amp; Roles
 - Basic login system (Laravel Breeze preferred).
 - Create 2 users manually: Admin and Salesperson.
 - Role-based access: Admin manages all, Salesperson can create/view sales orders.
2. Inventory Management
 - Product listing page with CRUD (name, SKU, price, quantity).
 - Reduce stock when a sales order is confirmed.
3. Sales Orders
 - Create sales orders with multiple products.
 - Calculate total and reduce inventory on confirmation.
 - PDF export of sales order using dompdf.
4. Dashboard Summary
 - Show total sales (amount), total orders, and low stock alerts.

## 🛠️ Tech Stack

- PHP 8.2
- Laravel 12
- MySQL
- Composer
- Vite

## 🧰 Prerequisites

Make sure you have the following installed:

- PHP >= 8.2
- Composer
- Node.js and NPM
- MySQL or any DB you plan to use
- Git

## 📦 Installation

Clone the repository and go to the project directory:

```bash
git clone git@github.com:AviWebSquad/mini_crm.git
cd mini_crm
```

Install dependencies:

```bash
composer install
npm install
```

Copy `.env` and configure:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Setup your `.env`:

- Set your database credentials
- Set app URL and mail settings if required

Run migrations (and optionally seeders):

```bash
php artisan migrate
php artisan db:seed
```

## 🏃 Running the Project

Start the local server:

```bash
composer run dev
```

Visit `http://127.0.0.1:8000`
