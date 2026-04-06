# Roxane

Roxane is an open source membership management application designed for associations. It centralizes member management, subscriptions, and integration with self-hosted third-party services (Dolibarr, ISPConfig, Nextcloud, Sympa).

The project is developed in the context of **Le Retzien Libre**, a non-profit association promoting digital freedom and self-hosting. It is intended to be generic enough to be adapted by other associations with similar needs.

> Work in progress. The application is functional for core features but is actively being developed. See the [known TODOs](#known-todos) section.

---

## Features

**Back office (administrators)**
- Member management (status, nature, groups)
- Subscription and package management
- Manual and automated synchronization with third-party services
- Role and permission management (Spatie Permissions + Filament Shield)
- Two-factor authentication for admin accounts

**Front office (members)**
- Registration and membership form
- Personal dashboard with access to associated services
- Profile and password management
- Two-factor authentication

**Integrations**
- Dolibarr ERP (member and subscription import via REST API)
- ISPConfig (mail and web hosting account management via SOAP)
- Nextcloud (account provisioning via OCS API)
- Sympa (mailing list management)

**Planned in V2**
- SSO authentication via Keycloak (OIDC) for the front office
- Admin back office remains on local Laravel authentication

---

## Tech stack

| Layer     | Technologies                                          |
|-----------|-------------------------------------------------------|
| Backend   | Laravel 12, PHP 8.3, MySQL                            |
| Admin     | Filament v4, Livewire 3                               |
| Frontend  | React 19, Inertia v2, Tailwind CSS v4                 |
| Auth      | Laravel Fortify, 2FA, Spatie Permissions + Shield     |
| Queue     | Redis (cache, sessions, queues)                       |
| Tests     | PHPUnit 11                                            |
| Dev tools | Pint, ESLint, Prettier, Laravel Sail, Wayfinder       |

---

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+ and npm
- MySQL 8+ or MariaDB 10.6+
- Redis
- Docker (optional, via Laravel Sail)

---

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/your-org/roxane.git
cd roxane
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` and configure:
- Database connection (`DB_*`)
- Redis connection (`REDIS_*`)
- Mail configuration (`MAIL_*`)
- Third-party service credentials (Dolibarr, ISPConfig, Nextcloud)

### 4. Database setup

```bash
php artisan migrate
php artisan db:seed
```

The seeder creates:
- Member groups (`admin-interface`, `website`)
- Default packages (`custom`, `one-year`, `two-years`)
- Default services (mail, file2link, nextcloud, sympa, webhosting)
- Admin account (`contact@nebulae-design.com` / `password`)
- Notification templates

In non-production environments, a demo member (Jane Doe) is also created.

**Change all default credentials immediately after installation.**

### 5. Build frontend assets

```bash
npm run build
```

For local development with hot reload:

```bash
npm run dev
```

Or use the all-in-one development command:

```bash
composer run dev
```

### 6. Queues and scheduler

The application uses queued jobs for synchronization tasks and notifications. In production, configure a queue worker and the Laravel scheduler.

```bash
# Queue worker
php artisan queue:work

# Scheduler (add to crontab)
* * * * * cd /path/to/roxane && php artisan schedule:run >> /dev/null 2>&1
```

---

## Running with Laravel Sail (Docker)

```bash
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed
./vendor/bin/sail npm run build
```

---

## Default accounts

| Account     | Email                       | Password | Role        |
|-------------|----------------------------|----------|-------------|
| Admin       | contact@nebulae-design.com | password | super_admin |
| Demo member | jane@doe.com               | password | —           |

These accounts are created by the seeder. Remove or change them before any production deployment.

---

## Artisan commands

Synchronization commands can be triggered manually from the admin panel (Synchronisations page) or via CLI:

| Command                        | Description                                                  |
|-------------------------------|--------------------------------------------------------------|
| `sync:dolibarr-members`       | Import members and subscriptions from Dolibarr               |
| `members:cleanup-expired`     | Deactivate expired members across all services (`--dry-run`) |
| `sync:ispconfig-mail-members` | Link members to their ISPConfig mail accounts                |
| `sync:ispconfig-web-members`  | Link members to their ISPConfig web hosting accounts         |
| `nextcloud:sync-members`      | Link members to their Nextcloud accounts                     |
| `memberships:sync-services`   | Synchronize services associated with active memberships      |

---

## Running tests

```bash
php artisan test --compact
```

---

## Known TODOs

| Area                      | Description                                                         |
|---------------------------|---------------------------------------------------------------------|
| ContactService            | Send email notification to administrator on new contact request     |
| MemberService             | Send emails to member and admin on deactivation                     |
| SubscriptionExpiredPhase1 | Generic template + backend UI for notification content management   |
| User.php                  | Restrict admin access in production to @retzien.fr emails           |
| SyncDolibarrMembers       | Extract `toDate()` method into a shared service or helper           |
| SyncISPConfigMailMembers  | Handle multiple email addresses per member                          |
| SyncISPConfigMailMembers  | Track `ispconfig_client_id`                                         |
| Global                    | Make Roxane fully generic for any association ERP use case          |
| Translations              | Audit project for missing translation keys                          |
| Global                    | Raise PHPStan to level 8                                            |
| V2                        | Keycloak SSO integration (OIDC) for front office authentication     |

---

## License

This project is licensed under the [GNU Affero General Public License v3.0](LICENSE) (AGPL-3.0).

Any modification to the source code, including versions run as a network service, must be made available under the same license. This ensures the project remains free and open for all.

Contributions are welcome. If you are adapting Roxane for your own association, feel free to open an issue or submit a pull request.
