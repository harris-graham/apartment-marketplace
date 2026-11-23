# Contributing

Thank you for considering contributing to the Apartment Marketplace!

## Getting started

1. Fork the repository and create your branch from `main`.
2. Install dependencies: `composer install`.
3. Copy `.env` to `.env` (or adjust) and configure a PostgreSQL database.
4. Run migrations: `php spark migrate`.
5. Run seeders: `php spark db:seed`.
6. Run the test suite: `vendor/bin/phpunit`.

## Database

This project uses PostgreSQL. Schema is managed via migrations in `app/Database/Migrations`.
Demo data is loaded via seeders in `app/Database/Seeds`.

## Submitting changes

- Push to your fork and open a pull request against `main`.
- Ensure CI (PHPUnit + CodeQL) passes.
- Follow the existing code style.
