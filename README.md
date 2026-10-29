# CampusEvents — College Event Management

A college event management web app built for the **Web Technology SL component, IT-25 (A & B)**.
Built with HTML, CSS, JavaScript, PHP, **Laravel 12** and XML (DOM + XSLT).

Students browse upcoming events, filter/search them, and register for a seat with a printable
ticket. Admins manage events, registrations (with CSV export) and contact messages from a
protected panel.

## Features

- Event list with category filter, upcoming/past/all toggle, server-side search plus live JS search
- Event detail page with live seat counter, "full" and "past" states
- Registration form with client + server validation, CSRF protection, duplicate-registration check
  and seat limit enforced inside a DB transaction, ending in a printable ticket
- Contact form with validated messages readable in the admin panel
- Admin panel: add / edit / delete events, view and remove registrations, download CSV, read messages
- XML feed at `/feed.xml` rendered through `public/events.xsl` (DOM + XSLT)
- Responsive layout (phone, tablet, desktop) with print styles for the ticket

## Tech stack

| Layer | Used |
|---|---|
| Backend | PHP 8.2+, Laravel 12 |
| Database | SQLite by default (MySQL optional, see below) |
| Frontend | Semantic Blade templates, hand-written CSS/JS — **no npm build needed** |
| XML | `DOMDocument` + XSLT via `public/events.xsl` |
| Tests | PHPUnit (installed; the project currently ships no test cases) |

## Requirements

- PHP 8.2 or newer with `mbstring`, `openssl`, `pdo_sqlite`, `fileinfo`, `tokenizer`, `xml`
  (all on by default in XAMPP)
- Composer (https://getcomposer.org)

## Quick start (from a fresh clone)

```bash
composer install
cp .env.example .env            # Windows: copy .env.example .env
php artisan key:generate
touch database/database.sqlite  # Windows: type nul > database\database.sqlite
php artisan migrate --seed
php artisan serve
```

Then open http://127.0.0.1:8000

`.env` and the SQLite database file are **not** committed on purpose, so the three commands above
are what a new clone needs. To reset everything back to the sample data:

```bash
php artisan migrate:fresh --seed
```

> On Windows without PHP on your PATH (e.g. XAMPP), prefix commands with the full binary, e.g.
> `C:\xampp\php\php.exe artisan serve`. If Composer isn't installed globally, download
> `composer.phar` and run `php composer.phar install`.

## Admin panel

- URL: http://127.0.0.1:8000/admin
- Email: `admin@campusevents.test`
- Password: `admin123`

Created by the seeder — see [database/seeders/DatabaseSeeder.php](database/seeders/DatabaseSeeder.php)
to change it.

## Using XAMPP/MySQL instead of SQLite (optional)

Create an empty database called `campusevents` in phpMyAdmin, then in `.env` replace the DB lines with:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=campusevents
DB_USERNAME=root
DB_PASSWORD=
```

and run `php artisan migrate:fresh --seed`.

## Project map

```
routes/web.php                         every URL in the site, with names
app/Http/Controllers/                  Home, Event, Registration, Contact, Feed
app/Http/Controllers/Admin/            Login, Dashboard, Event (CRUD), Registration (+CSV), Message
app/Http/Requests/                     form validation (Registration, Contact, Event)
app/Http/Middleware/EnsureAdmin.php    protects /admin/* (alias "admin" in bootstrap/app.php)
app/Models/                            Event, Registration, Message (Eloquent)
database/migrations/                   events, registrations, messages tables
database/seeders/DatabaseSeeder.php    admin user + sample events and registrations
resources/views/layouts/               app.blade.php (site) and admin.blade.php
resources/views/components/            <x-event-card>, <x-flash>
resources/views/                       Blade pages
public/css/style.css, public/js/main.js   styles and scripts (no npm/Vite build needed)
public/events.xsl                      XSLT stylesheet for the XML feed (/feed.xml)
tests/                                 PHPUnit setup (no test cases yet)
```

## Syllabus topics

| Topic | Where |
|---|---|
| HTML | Semantic Blade templates on every page |
| CSS | `public/css/style.css` — variables, grid/flexbox, responsive, print styles |
| JavaScript | `public/js/main.js` — live search, validation, countdown, counters, menu |
| PHP | Models, controllers, form requests, sessions, CSV export |
| Laravel | Routing, controllers, Blade layouts and components, Eloquent, migrations, seeders, form requests, middleware, authentication |
| XML | `/feed.xml` built with PHP DOM and displayed through `events.xsl` |

## Routes

```
GET  /                                  home
GET  /about                             about page
GET  /events                            listing (cat, show, q query params)
GET  /events/{event}                    event detail + registration form
POST /events/{event}/register           register a seat
GET  /registrations/{id}/confirmed      session-gated printable ticket
GET  /contact  |  POST /contact         contact form
GET  /feed.xml                          XML feed (styled by events.xsl)

/admin/login  |  POST /admin/login      admin sign-in (throttled)
GET  /admin                             dashboard
/admin/events …                         event CRUD (resource routes)
/admin/registrations                     list + DELETE
/admin/registrations/export              CSV download
/admin/messages                          contact messages + DELETE
POST /admin/logout                       sign out
```
