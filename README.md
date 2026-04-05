# PPS Member Portal

Official membership management portal for the **Philippine Pediatric Society (PPS)**.  
Serving approximately 9,000 members across the Philippines.

**Production:** https://myportal.pps.org.ph  
**Staging:** https://dev.myportal.pps.org.ph

---

## 📋 Table of Contents

- [About](#about)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [Roles & Permissions](#roles--permissions)
- [Local Development Setup](#local-development-setup)
- [Environment Variables](#environment-variables)
- [Deployment](#deployment)
- [Database](#database)
- [Code Standards](#code-standards)
- [Git Workflow](#git-workflow)
- [Changelog](#changelog)

---

## About

The PPS Member Portal is a Laravel-based web application that manages:
- Member registration, profiles, and directory
- Membership applications and approvals
- Event registration and management
- Payment processing via PayMongo
- Live streaming via AWS IVS
- Audit trails for all admin actions
- Role-based access control for all user types

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 9.52 |
| Language | PHP 8.2 |
| Database | PostgreSQL (AWS RDS) |
| Cache / Queue | AWS ElastiCache Valkey 8.1 (TLS) |
| File Storage | AWS S3 |
| Hosting | AWS Elastic Beanstalk (Amazon Linux 2023) |
| Web Server | nginx + php-fpm |
| DB Proxy (Prod) | AWS RDS Proxy |
| Payments | PayMongo |
| Live Streaming | AWS IVS |
| Roles & Permissions | Spatie Laravel Permission |
| Audit Trails | OwenIt Laravel Auditing |
| Local Dev | Windows / Laragon / VS Code |

---

## Features

- **Member Management** — Full member profiles, directory, search, and filtering
- **Membership Applications** — Online application workflow with admin approval
- **Event Management** — Event creation, registration, and attendance tracking
- **Live Streaming** — AWS IVS integration with secure signed URLs
- **Payments** — PayMongo integration with webhook verification and reconciliation
- **Audit Trails** — Full audit log of all admin and member actions
- **Impersonation** — Admins can impersonate member accounts for support
- **Role-Based Access** — Granular permissions via Spatie Laravel Permission
- **Payment Gateway Settings** — Admin-configurable live/sandbox PayMongo toggle

---

## Roles & Permissions

Roles are managed via **Spatie Laravel Permission**. The following roles exist:

| Role | Description |
|---|---|
| Admin | Full system access. Highest role. Can impersonate members. |
| Creator | Content creation access. |
| Member | Standard member access. Can be impersonated by Admin. |
| Cashier | Payment and reconciliation access. |
| Hospital | Hospital institution access. |
| Attendance | Attendance tracking access only. |

> All access decisions use `hasRole()` and `can()` — never hardcoded role IDs.

---

## Local Development Setup

### Requirements
- PHP 8.2
- Composer
- Node.js & npm
- Laragon (Windows) or Laravel Valet (Mac)
- Git

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/YOUR-ORG/pps-portal.git
cd pps-portal

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install && npm run dev

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure your .env file (see Environment Variables section below)

# 7. Run database migrations
php artisan migrate

# 8. Seed roles and permissions
php artisan db:seed --class=RolesAndPermissionsSeeder

# 9. Clear and cache config
php artisan config:clear
php artisan config:cache
```

---

## Environment Variables

Copy `.env.example` to `.env` and fill in the following:

```env
APP_NAME="PPS Member Portal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database (points to RDS PostgreSQL)
DB_CONNECTION=pgsql
DB_HOST=your-rds-host
DB_PORT=5432
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Cache / Queue (local uses file drivers)
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# S3 Storage
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

# PayMongo
PAYMONGO_PUBLIC_KEY=
PAYMONGO_SECRET_KEY=
PAYMONGO_WEBHOOK_SECRET=

# Redis / ElastiCache (prod/staging only — not needed locally)
REDIS_HOST=
REDIS_PASSWORD=null
REDIS_PORT=6379
```

> ⚠️ **Never commit `.env` to Git.** It is in `.gitignore`.  
> ⚠️ **Production environment variables** are set in the AWS Elastic Beanstalk Console — not in `.env`.

---

## Deployment

This application is hosted on **AWS Elastic Beanstalk**.

### Deployment Steps

```bash
# 1. Make sure all changes are committed and pushed
git add .
git commit -m "your commit message"
git push origin main

# 2. Create a deployment ZIP (exclude unnecessary files)
# ZIP the project root — exclude: .git, node_modules, .env, storage/logs

# 3. Upload ZIP to AWS Elastic Beanstalk Console
# Application → Environments → Upload and Deploy

# 4. Monitor the deployment in the EB Console
```

> ⚠️ **Never edit files directly on the EB server.** All changes will be wiped on the next deployment.  
> ⚠️ **Run `php artisan view:cache` as the `webapp` user** — not root.

---

## Database

- **Engine:** PostgreSQL (AWS RDS)
- **Production:** Accessed via RDS Proxy (`pps-portal-db-proxy`) for connection pooling
- **Staging:** Direct RDS connection (no proxy)
- **ORM:** Laravel Eloquent — no raw `DB::` queries

### Key Tables

| Table | Description |
|---|---|
| `users` | All user accounts |
| `tbl_member_info` | Member profile data (linked to users via `pps_no`) |
| `tbl_member_type` | Member type definitions (`member_type_name` column) |
| `tbl_event` | Events |
| `roles` | Spatie roles |
| `permissions` | Spatie permissions |
| `audits` | OwenIt audit trail |
| `payment_gateway_settings` | Admin-configurable PayMongo settings |
| `ivs_streams` | AWS IVS stream configurations |

> ⚠️ `pps_no` links `users` to `tbl_member_info` — not `pps_number`.  
> ⚠️ Admin users have **no** `tbl_member_info` record — always use `optional()` when accessing member properties.

---

## Code Standards

All code in this project must follow these standards. No exceptions.

1. **PSR-4** naming conventions throughout
2. **Eloquent only** — no raw `DB::` queries
3. **Spatie** for all role and permission checks — `hasRole()` / `can()`
4. **Thin controllers** — business logic lives in Service classes
5. **Blade views** use `<x-page-template>` component — never `@extends()`
6. **S3 files** always served via `temporaryUrl()`
7. **No hardcoded values** — use config files or admin settings
8. **`optional()`** on all member property access
9. **PostgreSQL syntax only** — no MySQL-specific functions
10. **`php -l`** must pass on all modified PHP files before committing
11. **OwenIt Auditing** for audit trails — `activity()` helper does NOT exist here
12. Every feature must include: admin controls, permissions, audit trail, clean UI

---

## Git Workflow

```
main          → Production-ready code only
staging       → Pre-production testing
feature/*     → Individual feature branches
fix/*         → Bug fix branches
```

### Branch Rules
- Never commit directly to `main`
- All changes go through a feature or fix branch
- Merge to `staging` first — test on dev.myportal.pps.org.ph
- Only merge to `main` after staging is verified

### Commit Message Format
```
feat: add member search filter
fix: null check on member picture upload
docs: update README deployment steps
refactor: move payment logic to PaymentService
chore: update composer dependencies
```

---

## Changelog

All changes are documented in [CHANGELOG.md](./CHANGELOG.md) following the [Keep a Changelog](https://keepachangelog.com) format.

---

## Rebuild Tracker

This project is currently undergoing a full rebuild for best practices and modularity.  
See [REBUILD.md](./REBUILD.md) for the full plan, current phase, and progress tracking.

---

*Philippine Pediatric Society — Member Portal*  
*For technical issues contact the development team.*
