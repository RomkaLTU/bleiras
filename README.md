# News

A small news website: visitors read a list of published news items and open any of them in full, while signed-in users get an admin area for creating, editing and deleting news. Built with Laravel, Inertia.js and Vue 3 on top of SQLite.

## Requirements

- PHP 8.5
- Composer
- Node.js 20.19+ or 22.12+

## Setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
```

Then start the app with either

```bash
composer run dev
```

or

```bash
npm run build
php artisan serve
```

and open http://localhost:8000.

## Admin access

Sign in at http://localhost:8000/login with:

- Email: `admin@example.com`
- Password: `password`

## Notes

- The public list is not paginated; the dataset is small enough to render at once.
- Deleting a news item is confirmed with the browser's native dialog rather than a custom modal.
- Registration is disabled, because any account would gain full admin access. Accounts come from the seeder.
- News with a publish date in the future stays hidden from the public site until that time, while remaining visible in the admin list.
