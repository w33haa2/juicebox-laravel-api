# JuiceBox Code Exam

This project uses **Laravel Sail**, a lightweight command-line interface for interacting with Docker-based Laravel development environments.

📚 Laravel Sail Documentation: [https://laravel.com/docs/12.x/sail](https://laravel.com/docs/12.x/sail)

---

## 🛠️ Initial Setup

1. Copy the environment file:
    ```bash
    cp .env.example .env
    ```

2. Build the Docker containers:
    ```bash
    sail build
    ```

3. Start the containers:
    ```bash
    sail up -d
    ```

4. Install project dependencies:
    ```bash
    sail composer install
    ```

5. Generate the application key:
    ```bash
    sail artisan key:generate
    ```

6. Run database migrations:
    ```bash
    sail artisan migrate
    ```

7. Seed initial data (optional):
    ```bash
    sail artisan db:seed
    ```

8. Start the queue worker (for background jobs like emails):
    ```bash
    sail artisan queue:work
    ```
9. Check the current schedule list (optional):
    ```bash
    sail artisan schedule:list
    ```
10. Run manually the schedule (optional):
    ```bash
    sail artisan schedule:run
    ```
---

## Documentation

This project uses **Swagger** as a documentation Tool. You can check it in http://your-test.site/api/documentation#/

## 🌦️ Weather Data Integration

This project integrates with **OpenWeatherMap** to fetch and store weather data for **Perth, AU**.

### OpenWeatherMap API Key

Ensure you have added your OpenWeatherMap API key to `.env`:

```env
OPENWEATHERMAP_API_KEY=your_openweathermap_api_key
```

## ✉️ Mail Configuration (SMTP)Weather Data Integration

To enable email sending (for example, welcome emails), update the following **Mail Configuration** in your `.env` file:

### OpenWeatherMap API Key

Ensure you have added your OpenWeatherMap API key to `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**⚠️ Important:** `MAIL_PASSWORD` should be your App Password if using Gmail, not your regular Gmail password.
How to generate an App Password: https://support.google.com/accounts/answer/185833

## ⚙️ Custom Artisan Commands

The project includes custom Artisan commands for specific features.

### Fetch Weather Data for Perth

Fetches the weather data for Perth, AU and stores it in the database:

```bash
sail artisan weather:fetch-perth
```

### Send Welcome Email to a Specific User

Sends a welcome email to the specified user:

```bash
sail artisan user:send-welcome-email user@example.com
```

## 🔄 Common Sail Commands Reference

| Command  | Description |
| ------------- | ------------- |
| `sail up -d`  | Start Docker containers in detached mode  |
| `sail down`  | Stop all running containers  |
| `sail build`  | Build Docker images  |
| `sail composer install`  | Install Composer dependencies  |
| `sail artisan migrate`  | Run database migrations  |
| `sail artisan db:seed`  | Seed initial data into the database  |
| `sail artisan key:generate`  | Generate application key  |
| `sail artisan queue:work`  | Start the queue worker for background jobs  |






