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

5. Configure your database in the `.env` file:

```
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

7. Start the development server:

```bash
php artisan serve
```

8. In a separate terminal, start the Vite development server:

```bash
npm run dev
```

## Development Tools

### Laravel Telescope

The application includes Laravel Telescope for debugging and monitoring. Telescope provides insight into the requests coming into your application, exceptions, log entries, database queries, queued jobs, mail, notifications, cache operations, scheduled tasks, variable dumps, and more.

To access Telescope, visit:

```
http://localhost:8000/telescope
```

By default, Telescope is only enabled in the local environment. To enable it in other environments, update the `TelescopeServiceProvider.php` file.

### Laravel Debugbar

The application includes Laravel Debugbar for real-time debugging and profiling. Debugbar provides a developer toolbar that shows:

- Request/Response information
- Database queries with timing and bindings
- Route information
- Session data
- Cache operations
- Authentication status
- Views with their data
- Mail messages
- Events fired
- Configuration values
- And more...

Debugbar is automatically enabled when:

- `APP_DEBUG` is set to `true` in your `.env` file
- You're in a local environment
- You're not accessing Telescope or Horizon routes

Key features:

- Real-time performance metrics
- SQL query debugging with parameter binding
- Route and middleware information
- Session and request data inspection
- Cache operations monitoring
- Authentication status and user information
- View rendering details
- Mail message preview
- Event listener debugging

To customize Debugbar settings, edit the `config/debugbar.php` file. You can:

- Enable/disable specific collectors
- Configure storage options
- Set up remote path mapping
- Customize the editor integration
- Adjust AJAX request handling
- Configure theme (light/dark/auto)

#### Quick Debugging with dd() and dump()

Laravel provides two convenient debugging functions that integrate with Debugbar:

1. `dump()`: Dumps the contents of a variable and continues execution

   ```php
   dump($user); // Shows user data and continues
   dump($payment); // Shows payment data and continues
   ```

2. `dd()`: Dumps the contents of a variable and dies (stops execution)

   ```php
   dd($user); // Shows user data and stops execution
   ```

These functions are useful for:

- Inspecting variable contents
- Debugging complex objects
- Checking array structures
- Verifying database query results
- Examining request/response data

Example usage:

```php
public function show(Payment $payment)
{
    dump($payment); // Shows payment details
    dump($payment->user); // Shows associated user
    dd($payment->transactions); // Shows transactions and stops
}
```

The output will appear in:

- The Debugbar's Messages tab
- The browser's console
- The terminal (if running in CLI)

### Performance Monitoring

The application includes automatic performance monitoring through the `LogSlowRequests` middleware. Any request that takes longer than 200ms will be logged with detailed information including:

- Request URL and method
- Duration in milliseconds
- IP address
- User ID (if authenticated)
- Unique request ID
- Memory usage

Example log entry:

```
[2024-05-13 10:15:23] local.WARNING: Slow request detected {
    "url": "http://localhost:8000/api/v1/payments",
    "method": "POST",
    "duration": "245.67ms",
    "ip": "127.0.0.1",
    "user_id": 1,
    "request_id": "65f2a3b4c5d6e",
    "memory_usage": "12.5MB"
}
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
