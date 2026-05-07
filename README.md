# Issue Intake & Smart Summary System (Laravel)

This project implements an **Issue Intake and Smart Summary System** for a support/operations team.

It supports:
- **Create** issues (title, description, priority, category — status defaults to `open`, due date defaults to current system time)
- **Store** issues in a relational database (**MySQL**)
- **List + filter** issues by status/category/priority
- **Automation layer** that generates a short **summary** + **suggested next action**, and flags **escalation** for high/critical or overdue items
- **Web UI** (Tailwind) and a **clean JSON API**

No admin/user separation is required for this assessment, so the app is intentionally **public** and accessible without authentication.

## Tech stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL (relational) in current `.env`
- **Frontend**: Blade + Tailwind (via Vite)

### Why MySQL?
For this project, MySQL is used because it is:
- **Relational** and well-suited for issue/ticket schemas
- **Production-friendly** and widely used in backend systems
- Natively supported by Laravel migrations, validation, and query builder

## Quick start (Windows / PowerShell)

### 1) Install dependencies

```bash
composer install
copy .env.example .env
php artisan key:generate
npm install
```

### 2) Create database + run migrations + seed sample data

```bash
php artisan migrate --seed
```

### 3) Start the app

```bash
php artisan serve
```

Open:
- **Web UI**: `http://127.0.0.1:8000/`
- **Submit issue**: `http://127.0.0.1:8000/issues/create`

## API (JSON)

Routes are defined via `Route::apiResource('issues', IssueController::class);` in `routes/api.php`.

Base URL:
- `http://127.0.0.1:8000/api/issues`

### Endpoints
- **List**: `GET /api/issues?status=&category=&priority=`
- **Create**: `POST /api/issues`
- **View**: `GET /api/issues/{id}`
- **Update**: `PUT/PATCH /api/issues/{id}`
- **Delete** (extra): `DELETE /api/issues/{id}`

### Example: create an issue

```bash
curl -X POST "http://127.0.0.1:8000/api/issues" ^
  -H "Accept: application/json" ^
  -H "Content-Type: application/json" ^
  -d "{\"title\":\"Printer not working\",\"description\":\"Printer shows error and cannot print from Windows 10.\",\"priority\":\"high\",\"category\":\"technical\"}"
```

Note:
- `status` is optional on create. If omitted, the system saves `status = open`.
- `due_at` is optional on create. If omitted, the system saves `due_at = current system time`.

### Validation behavior
Invalid/incomplete requests are rejected with **422** and field-level error messages (Laravel validation in controllers).

## Browser-friendly API pages
If you open the API endpoints directly in a browser, you’ll see a Tailwind page (easier to test manually):
- `GET /api/issues` shows an HTML list + filters
- `GET /api/issues/{id}` shows an HTML detail page

To force JSON in a browser or API client, send:
- `Accept: application/json`

## Data model

Migration: `database/migrations/2026_05_07_004002_create_issues_table.php`

Key fields:
- `title`, `description`
- `priority` (low/medium/high/critical), `category`, `status`
- `summary`, `suggested_action`
- `escalation_required` (boolean), `due_at` (optional)

## Automation & business rules

Service: `app/Services/IssueAutomationService.php`

What it does on create/update:
- **Summary**: short summary derived from the description (rules-based)
- **Suggested next action**: rules based on category and keywords
- **Escalation rule**:
  - Escalate when **priority is high/critical**, unless already resolved/closed
  - Escalate when **due_at is in the past**, unless resolved/closed

This is a **well-structured rules-based fallback** (no external AI dependency required). With more time, this service is the seam where an LLM provider can be added while keeping the fallback behavior.

## Seed data
Seeder: `database/seeders/IssueSeeder.php` (called by `DatabaseSeeder`)

It inserts several sample issues across categories and priorities and runs them through the automation service.

## Architecture notes (key decisions)
- **Thin controllers, centralized automation**: both the Web UI and API call `IssueAutomationService` so summary/action/escalation are consistent.
- **Resource responses for API**: `app/Http/Resources/IssueResource.php` defines the JSON response shape.
- **Filtering in one place**: list endpoints accept `status`, `category`, `priority` filters; category filtering is case-insensitive to be robust with real-world data.

## What I would improve with more time
- Add optional LLM integration (feature-flagged) in `IssueAutomationService` with graceful fallback
- Add pagination + sorting for large issue volumes
- Add normalized categories (enum/table) and better full-text search
- Add audit history for status changes and basic SLA metrics
