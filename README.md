# 🏥📦 Hospital-Inventory Information System API

This API, built with Laravel 12 and MySQL, enables smooth, real-time interaction between hospitals and warehouses to manage and distribute medical inventory. Hospitals can place orders for healthcare items, warehouses handle inventory and fulfillment, and order statuses are tracked accurately. Every endpoint is secured using Bearer token authentication powered by Laravel Sanctum.

## 📚 Table of Contents

- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Getting Started](#getting-started)
- [Middleware Setup for Sanctum](#middleware-setup-for-sanctum)
- [API Documentation](#api-documentation)
- [Configuration](#configuration)
- [Run the Laravel Development Server](#run-the-laravel-development-server)
- [Contribution](#contribution)
- [License](#license)


## 🧰 Tech Stack

- **Framework:** Laravel 12 (PHP 8.3+)
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Documentation:** L5-Swagger



## 📦 Prerequisites

Before starting, make sure you have installed:

- **PHP 8.1** or higher (compatible with Laravel 12)
- **Composer** (for dependency management)
- **MySQL 8.0** or higher (or compatible MySQL/MariaDB database)

You can check versions using:

```bash
php -v
composer -V
mysql --version
```



## 🚀 Getting Started

### 1. Clone project (ganti URL sesuai repo kamu)
```
git clone https://github.com/your-username/your-project.git
cd your-project
```

### 2. Install Laravel dependencies
```
composer install
```

### 3. Setup environment file
```
cp .env.example .env
php artisan key:generate
```

### 4. Run migrations
```
php artisan migrate
```

### 5. Install Sanctum
```
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```



## 🛡️ Middleware Setup for Sanctum
Add this to your app/Http/Kernel.php inside the api middleware group:
```
'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
```



## 📄 API Documentation

### 1. Install L5-Swagger package via Composer
```
composer require "darkaonline/l5-swagger"
```

### 2. Publish config & assets
```
php artisan vendor:publish --provider="L5Swagger\L5SwaggerServiceProvider"
```

### 3. Generate dokumentasi Swagger
```
php artisan l5-swagger:generate
```

### 4. Run the Laravel server (php artisan serve), access the API documentation in your browser at:
```
http://localhost:8000/api/documentation
```



## ⚙️ Configuration

Create a `.env` file in the project root with the following variables:

```env
# App
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:YOUR_GENERATED_APP_KEY_HERE
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory_rs
DB_USERNAME=root
DB_PASSWORD=

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost
SESSION_DOMAIN=localhost
```



## 🏃🏻‍♀️‍➡️ Run the Laravel Development Server
```
php artisan serve
```

#### Base URL
All API endpoints are prefixed with `/api`.



## 🤝 Contribution

Contributions are welcome! To contribute:

1. **Fork** the repository  
2. **Create** a new feature branch  
   ```
   git checkout -b feature-name
   ```
3. **Commit** your changes
    ```
    git commit -m "Add new feature"
    ```

4. **Push** to your branch
    ```
    git push origin feature-name
    ```

5. **Create** a pull request


## 📃 License

This project is licensed under the MIT License.  
You are free to use, modify, and distribute this software with proper attribution.

See the [LICENSE](LICENSE) file for more details.