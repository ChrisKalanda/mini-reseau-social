<div align="center">

# MiniSocial

**A full-featured photo-sharing social network inspired by Instagram — built with PHP 8, PDO and a custom MVC architecture.**

[![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/license-MIT-22c55e)](#license)
[![i18n](https://img.shields.io/badge/i18n-FR%20%7C%20EN-0095f6)](#language-switching)

</div>

---

## Table of Contents

1. [Overview](#overview)
2. [Features](#features)
3. [Tech Stack](#tech-stack)
4. [Project Structure](#project-structure)
5. [Getting Started](#getting-started)
6. [Configuration](#configuration)
7. [Database Schema](#database-schema)
8. [Language Switching](#language-switching)
9. [Test Accounts](#test-accounts)
10. [Security](#security)
11. [License](#license)

---

## Overview

MiniSocial is a PHP-based mini social network developed as a final project for **E-Commerce 2**. Users can register, share photos, comment on posts, edit their profile and switch the UI between French and English — all within a clean, Instagram-inspired interface.

The application follows the **MVC pattern** with a single front controller, manual routing, and zero external PHP dependencies.

---

## Features

### User Management
- Secure registration and login (bcrypt password hashing, PHP sessions)
- Editable profile: bio and avatar photo upload
- Session-based authentication with route protection

### Posts
- Create posts with image upload (JPEG, PNG, GIF, WebP — max 5 MB)
- Drag-and-drop upload zone with instant image preview
- Edit post description or delete your own posts
- Infinite-scroll–style feed with story bar

### Comments
- Add comments on any post
- Delete your own comments
- Comment count displayed per post

### UI / UX
- Premium sidebar layout (245 px fixed — similar to Instagram web)
- Animated gradient brand identity
- Like button with heart animation (localStorage persistence)
- Responsive: collapses to bottom navigation bar on mobile
- Bilingual interface: **French** and **English**
- Inter font, CSS custom properties, smooth micro-interactions

---

## Tech Stack

| Layer       | Technology                                      |
|-------------|-------------------------------------------------|
| Language    | PHP 8+ — OOP, strict types                      |
| Architecture| Custom MVC — Front controller, manual router    |
| Database    | MySQL 8 / MariaDB — PDO with prepared statements|
| Auth        | PHP sessions + `password_hash()` / `password_verify()` |
| Frontend    | Vanilla CSS (Inter, CSS variables, Flexbox/Grid)|
| i18n        | Custom `__()` helper — session-persisted locale |
| Server      | Apache (XAMPP) or PHP built-in server           |

---

## Project Structure

```
mini-reseau-social/
│
├── app/
│   ├── controllers/
│   │   ├── UserController.php      # Register, login, logout, profile, editProfile
│   │   ├── PostController.php      # Feed, create, show, edit, delete
│   │   └── CommentController.php   # Add, delete comments
│   │
│   ├── lang/
│   │   ├── fr.php                  # French string map
│   │   ├── en.php                  # English string map
│   │   └── i18n.php                # __() translation helper
│   │
│   ├── models/
│   │   ├── Database.php            # PDO Singleton
│   │   ├── User.php                # register, login, findById, updateProfile
│   │   ├── Post.php                # getAll, getByUser, findById, create, update, delete
│   │   └── Comment.php             # getByPost, add, delete
│   │
│   └── views/
│       ├── layouts/
│       │   ├── header.php          # HTML head, sidebar nav, lang switcher
│       │   └── footer.php          # Mobile nav, footer, JS
│       ├── post/
│       │   ├── feed.php            # Main feed with story bar
│       │   ├── create.php          # New post form
│       │   ├── show.php            # Post detail + comments
│       │   └── edit.php            # Edit post description
│       └── user/
│           ├── login.php
│           ├── register.php
│           ├── profile.php         # Avatar ring, stats, post grid
│           └── edit_profile.php    # Bio + avatar upload
│
├── config/
│   ├── config.php                  # BASE_URL, upload settings
│   ├── database.php                # DB credentials (⚠️ not versioned)
│   └── database.php.example        # Template for database.php
│
├── public/                         # Web root — point your server here
│   ├── index.php                   # Front controller & router
│   ├── css/
│   │   └── style.css               # Full premium stylesheet (~900 lines)
│   └── uploads/                    # User-uploaded files (⚠️ not versioned)
│
├── sql/
│   ├── schema.sql                  # CREATE TABLE statements
│   └── seed.sql                    # Sample users and posts
│
├── .gitignore
└── README.md
```

---

## Getting Started

### Prerequisites

- PHP **8.0+** with extensions: `pdo_mysql`, `fileinfo`, `mbstring`
- MySQL **8.0+** or MariaDB **10.4+**
- Apache with `mod_rewrite` — or PHP built-in server

### Installation

**1. Clone the repository**

```bash
git clone https://github.com/ChrisKalanda/mini-reseau-social.git
cd mini-reseau-social
```

**2. Create the database**

```bash
mysql -u root -p < sql/schema.sql
mysql -u root -p mini_reseau_social < sql/seed.sql
```

**3. Configure the database connection**

```bash
cp config/database.php.example config/database.php
```

Then edit `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'mini_reseau_social');
define('DB_USER', 'root');
define('DB_PASS', '');
```

**4. Set the base URL**

In `config/config.php`, adjust `BASE_URL` to match your environment:

```php
// XAMPP example
define('BASE_URL', 'http://localhost/mini-reseau-social/public');

// PHP built-in server
define('BASE_URL', 'http://localhost:8000');
```

**5. Create the uploads directory** *(if not already present)*

```bash
mkdir public/uploads
chmod 775 public/uploads   # Linux / macOS
```

**6. Start the application**

Option A — **XAMPP**: place the project inside `htdocs/` and browse to your `BASE_URL`.

Option B — **PHP built-in server**:

```bash
php -S localhost:8000 -t public/
```

Then open [http://localhost:8000](http://localhost:8000).

---

## Configuration

| File                    | Purpose                                              |
|-------------------------|------------------------------------------------------|
| `config/config.php`     | `BASE_URL`, `UPLOAD_DIR`, `MAX_FILE_SIZE`, `ALLOWED_TYPES` |
| `config/database.php`   | Database host, port, name, user and password         |

> `config/database.php` is excluded from version control via `.gitignore`. Never commit real credentials.

---

## Database Schema

```
┌──────────────────┐        ┌──────────────────┐       ┌──────────────────┐
│      users       │        │      posts       │       │    comments      │
├──────────────────┤        ├──────────────────┤       ├──────────────────┤
│ id (PK)          │───┐    │ id (PK)          │───┐   │ id (PK)          │
│ username UNIQUE  │   │    │ user_id (FK)  ───┘   │   │ post_id (FK)  ───┘
│ email UNIQUE     │   └───►│ image            │   └──►│ user_id (FK)     │
│ password         │        │ description      │       │ content          │
│ bio              │        │ created_at       │       │ created_at       │
│ avatar           │        └──────────────────┘       └──────────────────┘
│ created_at       │
└──────────────────┘
```

All foreign keys use `ON DELETE CASCADE` — deleting a user removes all their posts and comments.

---

## Language Switching

The UI is fully bilingual. The active language is stored in the PHP session and persists across all pages.

| Method              | Example                                         |
|---------------------|-------------------------------------------------|
| URL parameter       | `?lang=en` or `?lang=fr`                        |
| Sidebar toggle      | Click **FR \| EN** in the desktop sidebar       |
| Mobile toggle       | Floating **FR \| EN** button above the nav bar  |

Adding a new language requires only two steps:
1. Create `app/lang/<code>.php` with the same keys as `fr.php`
2. Add `<code>` to the allowed list in `public/index.php`

---

## Test Accounts

| Username | Email            | Password    |
|----------|------------------|-------------|
| `alice`  | alice@test.com   | `Test1234!` |
| `bob`    | bob@test.com     | `Test1234!` |

> **Before pushing to a public repository**, regenerate the password hashes in `sql/seed.sql` using `password_hash('YourPassword', PASSWORD_BCRYPT)`.

---

## Security

| Threat                  | Mitigation                                                              |
|-------------------------|-------------------------------------------------------------------------|
| SQL Injection           | All queries use PDO prepared statements — no raw interpolation          |
| XSS                     | All user output is escaped with `htmlspecialchars()`                    |
| Unauthorised access     | Session check (`requireAuth()`) on every protected route                |
| Unauthorised edit/delete| Ownership verified before any mutation (user_id comparison)             |
| Malicious file uploads  | MIME type checked with `finfo` + file size capped at 5 MB               |
| Password storage        | `password_hash()` with `PASSWORD_BCRYPT` — plain text never stored     |

---

## License

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT).  
Built for educational purposes — **E-Commerce 2**, 2025.
