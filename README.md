# PHP Application Framework

A modern PHP application framework built with a clean architecture approach, using Slim, Doctrine ORM, and other best-in-class libraries.

## Project Structure

### Root Directory

- **`/bin/`** - Command-line executable scripts
  - `cmd` - CLI command runner for executing application commands

- **`/config/`** - Configuration files
  - `application.php` - Core application configuration and static helper methods
  - `dependencies.php` - Dependency injection container configuration
  - `initialize.php` - Application bootstrapping and environment setup

- **`/public/`** - Web server document root
  - `index.php` - Application entry point for HTTP requests
  - `swagger.html` - Swagger UI for API documentation
  - `.htaccess` - Apache web server configuration

- **`/logs/`** - Application log files

- **`/src/`** - Application source code (follows Clean Architecture)
  - **`/Application/`** - Application business logic and use cases
    - `/Commands/` - CLI commands
    - `/Enumerations/` - Enumeration classes (e.g., HTTP status codes)
    - `/Exceptions/` - Application-specific exceptions
    - `/Interfaces/` - Interfaces for dependency inversion
    - `/Repositories/` - Repository interfaces
    - `/Traits/` - Shared trait functionality
    - `/UseCases/` - Application use cases and business rules
  - **`/Domain/`** - Core domain models and business logic
  - **`/Infrastructure/`** - External systems and frameworks implementations
    - Contains implementations of interfaces defined in Application layer
    - Database adapters, external API clients, framework integrations
  - **`/Interface/`** - User interface layer (controllers, views, etc.)

- **`.docker/`** - Docker configuration files

- **`.env.example`** - Example environment variables configuration

- **`composer.json`** - PHP dependencies and project configuration

- **`cli-config.php`** - Doctrine CLI configuration

- **`docker-compose.yml`** - Docker Compose configuration

- **`migrations.yml`** - Database migration configuration

## Architecture

This project follows Clean Architecture principles, separating concerns into distinct layers:

1. **Domain Layer** - Core business logic and entities
2. **Application Layer** - Application use cases and business rules
3. **Infrastructure Layer** - External frameworks and tools implementations
4. **Interface Layer** - User interface components (web, API, CLI)

## Key Features

- **Slim Framework** - Fast, lightweight PHP micro-framework
- **Doctrine ORM** - Object-relational mapping for database operations
- **PHP-DI** - Dependency injection container
- **Monolog** - Logging framework
- **OpenAPI/Swagger** - API documentation
- **CLI Commands** - Command-line interface using splitbrain/php-cli
- **PSR Standards** - Follows PSR-4, PSR-7, and other PHP standards

## Getting Started

### Prerequisites

- PHP 8.4+
- Composer
- Docker and Docker Compose (optional)

### Installation

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your environment variables
3. Install dependencies:

```bash
composer install
```

4. Run the application:

```bash
# Using PHP's built-in server
php -S localhost:8080 -t public

# Or using Docker
docker-compose up -d
```

### Database Migrations

Run database migrations using Doctrine Migrations:

```bash
composer migrations -- migrate
```

### Running Commands

Execute CLI commands using the command runner:

```bash
php bin/cmd minimal [options]
```

## Testing

Run tests with PHPUnit:

```bash
composer test
```

Run with coverage report:

```bash
composer test:coverage
```

## API Documentation

API documentation is available via Swagger UI at `/api/docs` when the application is running.

## License

This project is licensed under the MIT License - see the LICENSE file for details.