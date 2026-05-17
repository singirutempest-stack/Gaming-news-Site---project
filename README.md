# Gaming News Portal

Full-stack Laravel 11 gaming news portal using PHP 8.2+, MySQL, Bootstrap 5, Blade, HTML5, and CSS3.

## Requirements

- PHP 8.2+
- Composer
- MySQL 8+
- PHP extensions required by Laravel: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, Tokenizer, XML

## Installation Steps

1. Install dependencies:
   ```bash
   composer install
   ```
2. Create the environment file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Configure MySQL in `.env`.
4. Run migrations and seeders:
   ```bash
   php artisan migrate --seed
   ```
5. Create the public storage symlink:
   ```bash
   php artisan storage:link
   ```
6. Start the app:
   ```bash
   php artisan serve
   ```

## Gmail SMTP Setup

Set these values in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
ADMIN_EMAIL=your@gmail.com
```

Use a Gmail App Password, not your normal Google account password.

## Test Accounts

| Email | Password | Role |
| --- | --- | --- |
| admin@portal.com | password | admin |
| journalist@portal.com | password | journalist |
| guest@portal.com | password | guest |

## Project Structure

- `app/Http/Controllers/Frontend` public portal controllers
- `app/Http/Controllers/Admin` admin dashboard and moderation controllers
- `app/Http/Controllers/Auth` login, register, and profile controllers
- `app/Http/Middleware` role, banned-user, and locale middleware
- `app/Models` User, News, Category, Comment, Translation
- `resources/views/layouts` public, admin, and auth layouts
- `resources/views/components` reusable news card, sidebar, flash, and video components
- `resources/views/pages` public pages and shared news form
- `resources/views/admin` admin screens
- `lang/en`, `lang/ru`, `lang/kz` interface translations
- `database/migrations` database schema
- `database/seeders` demo data

## Known Limitations

- Seeded images use remote placeholder URLs until real uploaded images are added.
- Welcome email includes an account-entry link; full email verification routes can be added if strict verification is required.
- The environment used to generate this project did not have PHP or Composer installed, so runtime validation should be done after installing local dependencies.
