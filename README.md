# NxB Ninja Decker

Naruto x Boruto Ninja Decker  is a browser-based collecting game. Players can create an account, then do free daily draw or spend coins on a paid draw, and complete their collection. Every draw gives three cards, and duplicates are automatically converted into coins so each pull still moves the player forward.

> This is a fan project. It is not affiliated with the Naruto/Boruto rights holders. See [Miscellaneous](#miscellaneous).

## Table of Contents

- [Project Brief](#nxb-ninja-decker)
- [Table of Contents](#table-of-contents)
- [Requirements](#requirements)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Features](#features)
- [Tools](#tools)
- [Miscellaneous](#miscellaneous)

## Requirements

| Requirement | Version / notes |
| --- | --- |
| PHP | 8.3 or newer |
| Composer | 2.x |
| Node.js | 20.19+ or 22.12+ |
| SQL Databases | Any recent version; this project is tested using `SQLite`, `PostgreSQL` and `MySQL` |
| PHP extensions | Standard Laravel extensions, including `pdo_pgsql` if you are using `pgsql` |

Optional development tools:

- **Laravel Boost** - AI-assisted development tooling, already installed as a dev dependency.
- **Laravel Pail** - live log viewer.
- **Laravel Pint** - code formatter.

## Quick Start

### 1. Get the source code

```bash
git clone https://github.com/Sekonso/nxb-ninja-decker.git
cd nxb-ninja-decker
```

### 2. Configure Database

Create a database for the project:

```sql
CREATE DATABASE nxb_ninja_decker;
```

Adjust the database name and credentials to match your setup. The example below uses PostgreSQL.

### 3. Configure environment

Create your local environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Then update the application configuration in `.env`

```dotenv
APP_NAME="NxB Ninja Decker"
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nxb_ninja_decker
DB_USERNAME=postgres
DB_PASSWORD=your-password
```

Other configuration exist aswell, provided by Laravel. You can visit official Laravel documentation for more details

### 4. Run Composer install

```bash
composer install
```

Then generate the application key:

```bash
php artisan key:generate
```

Optionally, you can test if your previous DB config is working:

```bash
php artisan db:show
```

### 6. Run npm install

```bash
npm install
```

### 7. Run migration

```bash
php artisan migrate
```

This creates the application tables.

### 8. Run seeders

Seed the required system data first:

```bash
php artisan db:seed --class=SystemSeeder
```

This will populate your database with built-in rarities and all of the sample cards. It is required for the gacha and codex pages to work.

Optionally, you can create demo user accounts:

```bash
php artisan db:seed --class=UserSeeder
```

To run both seeders at once, use `php artisan db:seed`.

> `SystemSeeder` uses `create()`, so it is not idempotent. Running it twice against the same database will fail on unique constraints. Use `php artisan migrate:fresh --seed` to rebuild local data, but note that this command reset all existing data.

### 9. Run the project

Link public storage first:

```bash
php artisan storage:link
```

This step is **required** so all of your storage asset can be accessible through client request. Card art, rarity icons, logos, and avatars live in `storage/app/public/images` and are served through `/storage/...`. Without the link, the server won't return the assets.

Then start the application:

```bash
composer run dev
```

Then open the URL printed in the terminal, usually `http://localhost:8000`.

For a production-style asset build, run `npm run build` instead of the Vite dev server.

### Sample accounts

The `UserSeeder` creates three local test accounts. All use the password `12345678`.

| Username | Coins | Starting state |
| --- | ---: | --- |
| `Adam` | 300 | Empty collection |
| `Eve` | 99,999 | Empty collection, plenty of coins |
| `Bryan` | 300 | Complete collection |

These accounts are for local development only. Change or remove them before exposing the app publicly.

### Game settings

Game balance is **not** environment-driven. These values are currently hardcoded:

| Setting | Value | Location |
| --- | --- | --- |
| Cards per draw | 3 | `GachaController::draw_cards()` |
| Paid draw cost | 100 coins | `GachaController::gacha_paid()` |
| Rarity drop rates | C 65%, R 25%, SR 10% | `GachaController::draw_cards()` |
| Duplicate rewards | C 10, R 25, SR 50 coins | `GachaController::convert_card_to_coins()` |
| Starting coins | 400 | `users` table migration |
| Daily draw limit | Once per calendar day in `APP_TIMEZONE` | `GachaController::gacha_daily()` |
| Avatar rules | JPG/JPEG/PNG/WebP, maximum 2 MB | `ProfileController::update()` |
| Minimum password length | 8 characters | `RegisterController` and `ProfileController` |

Changing the game balance means editing the controller and re-running the tests. There is no admin panel or balance config file yet.

### Production checklist

- Set `APP_ENV=production`, `APP_DEBUG=false`, and the correct `APP_URL`.
- Point the web server document root at the `public/` directory.
- Run `php artisan migrate --force`.
- Run `php artisan storage:link`.
- Run `npm ci && npm run build`.
- Cache configuration and routes with `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`.
- Serve over HTTPS and use a strong database password.

## Features

### Game rules

| Rarity | Drop rate | Duplicate reward |
| --- | ---: | ---: |
| Common (C) | 65% | 10 coins |
| Rare (R) | 25% | 25 coins |
| Super Rare (SR) | 10% | 50 coins |

- A free daily draw gives 3 cards once per calendar day, based on `APP_TIMEZONE`.
- A paid draw gives 3 cards for 100 coins.
- A new card is added to the player's collection.
- A duplicate card is converted into coins based on its rarity.
- New accounts start with 300 coins.
- The seeder ships with 26 cards: 17 C, 6 R, and 3 SR.

### Accounts and authentication

- Username and password only. The `users` table has no email column, and there is no email verification or password reset flow.
- Usernames are unique, and passwords are hashed with Laravel's `hashed` cast.
- Registration and login pages are restricted to guests.
- Game pages are restricted to authenticated users.
- Login regenerates the session; logout invalidates the session and regenerates the CSRF token.

### Gacha

- `GET /gacha` shows the draw page with the player's current coin balance.
- `POST /gacha/daily` checks `latest_daily` against the current date and rejects a second draw with HTTP 400.
- `POST /gacha/paid` checks for at least 100 coins and rejects the draw with HTTP 400 if the balance is too low.
- Rarity is selected first with `random_int()` and a weighted table, then a random card of that rarity is chosen.
- Card storage, coin changes, and the daily timestamp run inside a database transaction.
- Duplicate detection uses `firstOrCreate()` on the unique `(user_id, card_id)` pair. Existing cards add coins to the player's balance.
- The result page reads the draw from the session flash data and renders each card with its duplicate status and coin value.

### Collection and codex

- `GET /my-page` shows the player's owned cards, grouped by rarity.
- `GET /codex` shows every card in the game, grouped by rarity, with an `owned` flag for the current player.
- A collection row represents one owned card. The unique `(user_id, card_id)` constraint prevents duplicate inventory rows.

### Profile

- `GET /profile/edit` shows the profile form.
- `PATCH /profile` updates the username, optionally changes the password, and optionally uploads an avatar.
- The current password is always required, even when only the username or avatar changes.
- Avatars are validated, renamed with a UUID, and stored on the `public` disk under `images/avatars/`.
- If the database update fails after an upload, the newly stored avatar file is deleted during rollback.

### Data model

| Model | Responsibility |
| --- | --- |
| `User` | Login account, coins, daily draw timestamp, avatar filename, collection relation |
| `Collection` | One row per card owned by a user |
| `Card` | Card name, image filename, and rarity |
| `Rarity` | Rarity name and icon filename (C, R, SR) |

### Routes

| Method | URI | Access | Purpose |
| --- | --- | --- | --- |
| GET | `/` | Public | Cover page |
| GET/POST | `/register` | Guest | Create an account |
| GET/POST | `/login` | Guest | Log in |
| GET | `/my-page` | Auth | Owned cards |
| GET | `/codex` | Auth | Full card list with ownership |
| GET | `/guide` | Auth | Game guide |
| GET | `/about` | Auth | Project and author info |
| GET | `/profile/edit` | Auth | Profile form |
| PATCH | `/profile` | Auth | Update profile |
| GET | `/gacha` | Auth | Gacha page |
| POST | `/gacha/daily` | Auth | Free daily draw |
| POST | `/gacha/paid` | Auth | Paid draw |
| GET | `/gacha/result` | Auth | Draw results |
| DELETE | `/logout` | Auth | Log out |

## Tools

### Seeders

| Seeder | What it does |
| --- | --- |
| `DatabaseSeeder` | Runs `SystemSeeder` followed by `UserSeeder` |
| `SystemSeeder` | Creates the initial rarities and sample cards |
| `UserSeeder` | Creates several sample user accounts |

Run all seeders:

```bash
php artisan db:seed
```

Run a specific seeder:

```bash
php artisan db:seed --class=SystemSeeder
```

> `SystemSeeder` uses `create()`, so it is not idempotent. Running it twice against the same database will fail on unique constraints. Use `php artisan migrate:fresh --seed` to rebuild local data. That command destroys all existing data.

### Artisan commands

| Command | Purpose |
| --- | --- |
| `php artisan migrate` | Run pending migrations |
| `php artisan migrate:fresh --seed` | Drop all tables, migrate, and seed (destructive) |
| `php artisan db:seed` | Run the database seeders |
| `php artisan storage:link` | Create the `public/storage` link |
| `php artisan route:list` | List all registered routes |
| `php artisan about` | Show application and environment details |
| `php artisan cards:webp` | Change every card filename in the database to the `.webp` extension |
| `php artisan cards:webp --dry-run` | Preview the filename changes without saving |

> `cards:webp` updates database filenames only. It does **not** convert image files. Convert the actual assets separately, then run the command.

### Composer scripts

| Command | What it does |
| --- | --- |
| `composer run dev` | Runs the server, queue listener, and Vite dev server concurrently |
| `composer run setup` | Installs dependencies, prepares `.env`, migrates, and builds assets |
| `composer run test` | Clears config cache and runs the test suite |

### npm scripts

| Command | What it does |
| --- | --- |
| `npm run dev` | Starts the Vite dev server with hot reload |
| `npm run build` | Builds production assets into `public/build` |

## Miscellaneous

NxB Ninja Decker is built and maintained by [Sekonso](https://github.com/sekonso). "NxB" stands for **Naruto x Boruto**. The card pool includes characters from both series, along with fan-favorites **John Jonin**.