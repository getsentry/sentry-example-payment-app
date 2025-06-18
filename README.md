# Payment App

A Laravel-based payment application that allows users to send, receive, and convert payments between different currencies.

## Installation

1. Clone the repository:

```bash
git clone [repository-url]
cd payment-app
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
npm install
```

4. Create, configure your environment file and then run the migrations:

```bash
cp .env.example .env
php artisan migrate
php artisan key:generate
```

5. Start the development server:

```bash
php artisan serve
```

## API Endpoints

### Payments

The API provides a complete set of endpoints for managing payments:

- `GET /api/v1/payments` - List all payments
- `POST /api/v1/payments` - Create a new payment
- `GET /api/v1/payments/{id}` - Get a specific payment

#### Payment Types

- `send` - Send money to another user
- `receive` - Receive money from another user
- `convert` - Convert money between currencies

#### Payment Status

- `pending` - Payment is being processed
- `completed` - Payment has been completed
- `failed` - Payment has failed

### Dummy Data

For testing purposes, we provide endpoints to generate and clean up dummy data:

#### Generate Dummy Data

```bash
curl -X POST http://localhost:8000/api/v1/generate-dummy-data \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

This will create:

- 10 dummy users
- 20 dummy payments with random amounts, currencies, and statuses

#### Clean Up Dummy Data

```bash
curl -X POST http://localhost:8000/api/v1/cleanup-dummy-data \
  -H "Content-Type: application/json" \
  -H "Accept: application/json"
```

This will remove all dummy users and their associated payments.

## Development

The application is built with:

- Laravel 12.13.x
- PHP 8.4.7
- SQLite (can be changed to MySQL/PostgreSQL)
- Vite for asset compilation
- Laravel Telescope for debugging and monitoring
- Performance monitoring middleware

## Testing

Run the test suite:

```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request
