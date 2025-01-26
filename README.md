# SARS (Student Achievement Recording System)

A web-based system for managing and tracking student achievements using PHP Slim Framework.

## Prerequisites

- PHP 8.0 or higher
- Composer
- SQL Server
- Laragon
- Web server Apache

## Installation

1. Clone the repository
```bash
git clone https://github.com/yourusername/SistemPrestasi.git
cd SistemPrestasi
```
2. Install dependencies
```bash
composer install
```

3. Create environment file
```bash
cp .env
```

4. Configure your .env file
```
DB_HOST=your_sql_server_host
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
```

## Project Structure

```
├── 📂 app
│   ├── 📂 Controller
│   ├── 📂 Middleware
│   ├── 📂 Models
│   ├── 📂 Services
├── 📂 config
├── 📂 database
├── 📂 public
│   ├── 📂 assets
│   │   ├── 📂 css
│   │   ├── 📂 icons
│   │   ├── 📂 images
│   │   └── 📂 js
├── 📂 resources
│   └── 📂 views
│       ├── 📂 components
│       └── 📂 pages
├── 📂 routes
├── 📄 composer.json
└── 📄 composer.lock
```
