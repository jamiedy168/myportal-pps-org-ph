# PPS Member Portal — Composer Package Audit
**Date:** 2026-04-05  
**Laravel Version:** 9.52.20  
**PHP Version:** ^8.0  
**Audit tools:** `composer audit`, `composer outdated`

---

## Summary

| Category | Count |
|----------|-------|
| Security vulnerabilities (direct + transitive) | 9 across 7 packages |
| Abandoned packages (direct + transitive) | 5 |
| Packages with major version updates available | 15+ |
| Stripe-related packages flagged for removal | 0 (no Stripe package found — PayMongo only) |

---

## 1. Security Vulnerabilities (`composer audit`)

### 🔴 HIGH — aws/aws-sdk-php (transitive, installed: 3.356.17)

**CVE:** GHSA-27qh-8cxx-2cr5 (no CVE number)  
**Title:** CloudFront Policy Document Injection via Special Characters  
**Affected:** >=3.11.7, <=3.371.3  
**Reported:** 2026-03-27  
**Action:** Update `league/flysystem-aws-s3-v3` to latest (`^3.32.0`) — this will pull in a newer `aws/aws-sdk-php`. Also consider pinning aws/aws-sdk-php directly.

---

**CVE:** CVE-2025-14761  
**Title:** Key Commitment Issues in S3 Encryption Clients  
**Affected:** >=3.0.0, <3.368.0  
**Reported:** 2025-12-17  
**Action:** Same as above — update flysystem-aws-s3-v3 to pull in aws-sdk-php >= 3.368.0.

---

### 🟡 MEDIUM — laravel/framework (installed: 9.52.20)

**CVE:** CVE-2025-27515  
**Title:** File Validation Bypass  
**Affected:** <10.48.29 (Laravel 9.x is affected — no patch available for Laravel 9)  
**Reported:** 2025-03-05  
**Action:** This vulnerability is only patched in Laravel 10.48.29+, 11.44.1+, and 12.1.1+. Laravel 9 is EOL — **the fix requires upgrading to Laravel 10 or higher (Phase 4 task P4-T6).** Interim: avoid using file validation rules on untrusted uploads in new code.

---

### 🟡 MEDIUM — league/commonmark (transitive, installed: 2.7.1)

**CVE:** CVE-2026-33347  
**Title:** embed extension allowed_domains bypass  
**Reported:** 2026 (recent)  
**Action:** Update `league/commonmark` to >= 2.8.0 via `composer update league/commonmark`.

---

### 🟡 MEDIUM — composer/composer (dev tool)

**CVE:** CVE-2025-33828 — Unparsed Symlink Targets May Confuse Classmaps  
**Action:** Update Composer itself: `composer self-update`

---

### 🟡 MEDIUM — symfony/http-foundation (transitive, installed: 6.4.25)

**CVE:** CVE-2025-64500  
**Title:** Incorrect parsing of PATH_INFO can lead to limited authorization bypass  
**Affected:** All versions up to 6.4.28, 7.3.6  
**Reported:** 2025-11-12  
**Action:** Update `laravel/framework` to latest Laravel 9.x patch — this will pull in symfony/http-foundation 6.4.29+. Run `composer update laravel/framework`.

---

### 🟡 MEDIUM — symfony/process (transitive, installed: 6.4.25)

**CVE:** CVE-2026-24739  
**Title:** Incorrect argument escaping under MSYS2/Git Bash can lead to destructive file operations on Windows  
**Affected:** <6.4.33, <5.4.51  
**Reported:** 2026-01-28  
**Note:** This affects Windows development environments (Git Bash). Production runs on Linux (Elastic Beanstalk) — lower risk in prod but should still be patched.  
**Action:** Update `laravel/framework` to pull in symfony/process 6.4.33+.

---

### 🟡 MEDIUM — laravel/framework (second advisory)

**CVE:** CVE-2025-29791  
**Title:** Potential mass-assignment bypass via Request merge/replace  
**Action:** Same fix — update laravel/framework.

---

### Full Vulnerability Table

| Package | Installed | Severity | CVE | Fix |
|---------|-----------|----------|-----|-----|
| `aws/aws-sdk-php` | 3.356.17 | 🔴 High | GHSA-27qh-8cxx-2cr5 | Update flysystem-aws-s3-v3 |
| `aws/aws-sdk-php` | 3.356.17 | 🟡 Medium | CVE-2025-14761 | Update flysystem-aws-s3-v3 |
| `laravel/framework` | 9.52.20 | 🟡 Medium | CVE-2025-27515 | Upgrade Laravel (Phase 4) |
| `laravel/framework` | 9.52.20 | 🟡 Medium | CVE-2025-29791 | `composer update laravel/framework` |
| `league/commonmark` | 2.7.1 | 🟡 Medium | CVE-2026-33347 | `composer update league/commonmark` |
| `symfony/http-foundation` | 6.4.25 | 🔴 High | CVE-2025-64500 | `composer update laravel/framework` |
| `symfony/process` | 6.4.25 | 🟡 Medium | CVE-2026-24739 | `composer update laravel/framework` |

---

## 2. Abandoned Packages

| Package | Type | Installed | Suggested Replacement | Action |
|---------|------|-----------|----------------------|--------|
| `amrshawky/laravel-currency` | direct (require) | 6.0.0 | None suggested | **Remove** — currency functionality can be replaced with `ashallendesign/laravel-exchange-rates` already installed |
| `amrshawky/currency` | transitive | 1.0.0 | None suggested | **Removed automatically** when `amrshawky/laravel-currency` is removed |
| `fruitcake/laravel-cors` | direct (require) | 2.2.0 | None — CORS is built into Laravel 8+ | **Remove** — Laravel's built-in `HandleCors` middleware handles this |
| `box/spout` | transitive | 3.3.0 | None suggested | Pulled in by `rap2hpoutre/fast-excel` — evaluate if fast-excel is still used |
| `laravelcollective/html` | transitive | 6.4.1 | `spatie/laravel-html` | Low priority — check if anything uses `Form::` or `HTML::` facades |

---

## 3. All Direct Packages (`composer.json require`)

| Package | Version Constraint | Installed | Latest | Status |
|---------|-------------------|-----------|--------|--------|
| `php` | ^7.3\|^8.0 | — | — | ⚠️ Should be `^8.2` minimum |
| `amrshawky/laravel-currency` | ^6.0 | 6.0.0 | 6.0.0 | 🔴 Abandoned — remove |
| `ashallendesign/laravel-exchange-rates` | ^7.1 | 7.9.0 | 7.11.0 | ✅ Minor update available |
| `barryvdh/laravel-dompdf` | ^3.0 | 3.1.1 | 3.1.2 | ✅ Patch update available |
| `endroid/qr-code` | ^5.0 | 5.0.7 | 6.0.9 | ⚠️ Major version available |
| `fruitcake/laravel-cors` | ^2.0 | 2.2.0 | 3.0.0 | 🔴 Abandoned — remove (CORS built into Laravel) |
| `guzzlehttp/guzzle` | ^7.8 | 7.x | — | ✅ Active |
| `intervention/image` | ^3.10 | 3.11.4 | 3.11.7 | ✅ Patch update available |
| `intervention/image-laravel` | ^1.3 | 1.5.6 | 1.5.9 | ✅ Patch update available |
| `ixudra/curl` | ^6.22 | 6.22.2 | 6.23.0 | ⚠️ Low maintenance — redundant with Guzzle |
| `laravel/framework` | ^9.0 | 9.52.20 | 12.56.0 | 🔴 EOL — upgrade path needed (Phase 4) |
| `laravel/sanctum` | ^2.15 | 2.15.1 | 4.3.1 | ⚠️ 2 major versions behind |
| `laravel/tinker` | ^2.6 | 2.10.1 | 3.0.0 | ⚠️ Major update available |
| `league/flysystem-aws-s3-v3` | 3.0 | 3.0.0 | 3.32.0 | 🔴 Pinned to exact old version — security risk |
| `luigel/laravel-paymongo` | ^2.4 | 2.5.0 | 2.6.0 | ✅ Minor update available |
| `maatwebsite/excel` | ^3.1 | 3.1.67 | 3.1.68 | ✅ Patch update available |
| `mavinoo/laravel-batch` | ^2.3 | — | — | ⚠️ Low maintenance — check if used |
| `owen-it/laravel-auditing` | ^13.5 | 13.7.2 | 14.0.3 | ⚠️ Major update available — review breaking changes |
| `predis/predis` | ^2.0 | — | — | ✅ Active |
| `simplesoftwareio/simple-qrcode` | ^4.2 | — | — | ✅ Active |
| `yajra/laravel-address` | ^0.7 | 0.7.0 | 12.2.0 | ⚠️ 12 major versions behind |
| `yajra/laravel-datatables-oracle` | ^10.11 | 10.11.4 | 12.7.0 | ⚠️ 2 major versions behind |

---

## 4. Dev Dependencies (`composer.json require-dev`)

| Package | Version Constraint | Installed | Latest | Status |
|---------|-------------------|-----------|--------|--------|
| `fakerphp/faker` | ^1.17 | — | — | ✅ Active |
| `laravel/sail` | ^1.12 | 1.45.0 | 1.56.0 | ✅ Minor update |
| `mockery/mockery` | ^1.4.2 | — | — | ✅ Active |
| `nunomaduro/collision` | ^6.1 | 6.4.0 | 8.9.2 | ⚠️ 2 major versions behind |
| `phpunit/phpunit` | ^9.5.10 | 9.6.27 | 11.5.55 | ⚠️ 2 major versions behind |
| `spatie/laravel-ignition` | ^1.0 | 1.7.0 | 2.12.0 | ⚠️ Major update available |

---

## 5. Stripe-Related Packages

**No Stripe packages found in composer.json or composer.lock.**  
The project uses **PayMongo only** (`luigel/laravel-paymongo`). No action needed.

> Note: A Stripe/PayMongo secret key (`sk_live_*`) appeared in old config files — this was the PayMongo live secret key which uses the same `sk_live_` prefix format as Stripe. GitHub's secret scanner flagged it as "Stripe API Key" but it is actually a PayMongo key.

---

## 6. Recommended Actions by Priority

### Immediate (security fixes — do before Phase 1)

| # | Action | Command |
|---|--------|---------|
| 1 | Update `league/flysystem-aws-s3-v3` to fix aws/aws-sdk-php CVEs | `composer require league/flysystem-aws-s3-v3:"^3.0" --update-with-dependencies` |
| 2 | Update `laravel/framework` to latest 9.x to fix symfony/http-foundation and symfony/process | `composer update laravel/framework` |
| 3 | Update `league/commonmark` for embed bypass CVE | `composer update league/commonmark` |
| 4 | Remove `fruitcake/laravel-cors` (abandoned, built into Laravel) | `composer remove fruitcake/laravel-cors` |
| 5 | Remove `amrshawky/laravel-currency` (abandoned, no replacement needed — exchange rates already covered) | `composer remove amrshawky/laravel-currency` |

### Phase 1 / Phase 4

| # | Action | Notes |
|---|--------|-------|
| 6 | Upgrade `laravel/framework` 9 → 10 → 11 | Fixes CVE-2025-27515 (file validation bypass). Requires significant testing. |
| 7 | Update `yajra/laravel-address` (0.7 → 12.x) | Check for breaking changes — used in member registration |
| 8 | Update `owen-it/laravel-auditing` (13 → 14) | Check breaking changes before updating |
| 9 | Replace `ixudra/curl` with Guzzle directly | Guzzle is already a direct dependency |
| 10 | Review `mavinoo/laravel-batch` usage | Confirm it's actually used — remove if not |
| 11 | Update `yajra/laravel-datatables-oracle` (10 → 12) | Review migration guide |
| 12 | Fix PHP version constraint (`^7.3\|^8.0` → `^8.2`) | Lock to minimum supported PHP version |

---

*Audit generated: 2026-04-05*  
*Next step: P0-T8 (fix Composer vulnerabilities) — implement the immediate actions above*
