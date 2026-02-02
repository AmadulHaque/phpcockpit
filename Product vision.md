## . Product vision

### Product name (working)

**DevDock** / **PHPCockpit** / **Laravel Station**

> *“One app. All your daily dev operations.”*

### Target user

* PHP / Laravel developers
* Solo devs, freelancers, small teams
* Backend engineers who also touch DevOps

### Core promise

> Replace **10 tabs + 3 terminals + sticky notes** with **one focused app**.

Built with **NativePHP** so:

* PHP-native
* Laravel-native
* Cross-platform desktop

---

## 3. Feature set (curated, not bloated)

### 🧠 Core Modules (MVP – MUST HAVE)

#### 1. Project Hub

Each project has:

* Path
* Git repo
* PHP version
* Node version
* SSH environments
* Database connections
* Notes

This is the **root abstraction**. Everything attaches to a project.

---

#### 2. Database Explorer (phpMyAdmin-inspired, but smarter)

Inspired by **phpMyAdmin**, but:

* Read-first, write-carefully
* Query runner with saved snippets
* Table schema diff
* Export (CSV, JSON)
* No overpowered admin chaos

Support:

* MySQL
* PostgreSQL
* SQLite

---

#### 3. Laravel Tinker Console

Inspired by **Tinkerwell**

Features:

* One-click `php artisan tinker`
* Project-scoped history
* Saved commands
* Context switch between environments
* Safe mode (no destructive ops in prod)

This is **daily-use gold**.

---

#### 4. SSH & Server Manager

Not a full DevOps tool — *task-based* SSH.

Features:

* SSH profiles (dev / staging / prod)
* Saved commands (deploy, restart queue, tail logs)
* Environment banners (big red PROD)
* Key-based auth only

Think:

> “Run what I run every day, faster.”

---

#### 5. Runtime Manager

Simple, opinionated.

* PHP versions (detect via brew / apt / asdf)
* Node.js versions (nvm / fnm / asdf)
* Show active version per project
* Switch with 1 click (exec behind the scenes)

You’re not re-implementing Homebrew — just **orchestrating** it.

---

#### 6. Developer Notes (context-aware)

Not Notion. Not Markdown obsession.

* Notes attached to:

  * Project
  * Server
  * Database
* Quick scratchpad
* Todos
* “Why the hell did I do this?” notes

This alone is a retention driver.

---

## 4. Power Features (Phase 2 – differentiation)

### 🔥 These make it *elite*

#### A. Log Viewer

* Laravel logs
* Live tail over SSH
* Filter by level
* Exception grouping

#### B. Git Control Panel

* Current branch
* Dirty files
* Pull / push / stash
* Commit history (read-only)

#### C. API Tester (Postman-lite)

* Run project APIs
* Auth presets
* Save requests per project

#### D. Environment Guardrails

* Disable destructive commands in prod
* Confirmation for `migrate:fresh`, `db:wipe`
* Read-only DB toggle

#### E. AI Helper (later)

* “Explain this error”
* “Generate migration”
* “Suggest index for this query”

---

## 5. Architecture & tech stack

### Desktop App

* **NativePHP**
* Laravel 10+
* Livewire / Inertia
* SQLite for app state
* OS keychain for secrets

### Execution layer

* Shell command abstraction
* SSH via system binaries
* Non-blocking process execution
* Permission sandboxing

### Security principles

* No plaintext secrets
* Read-first defaults
* Explicit prod warnings
* Audit log of commands

---

## 6. Project document (clean & usable)

### Project Name

**Laravel Dev Control Center (LDCC)**

### Problem Statement

Developers waste time switching between tools for:

* Databases
* Tinker
* SSH
* Environment management
* Notes

This fragmentation increases:

* Cognitive load
* Mistakes in prod
* Context loss

### Solution

A unified desktop app tailored for PHP/Laravel developers that centralizes daily workflows with safe defaults.

### MVP Scope

* Project hub
* DB explorer
* Tinker console
* SSH manager
* Runtime switcher
* Notes

### Non-Goals

* Full DevOps automation
* CI/CD replacement
* Cloud provider dashboards

### Target Platforms

* macOS (first)
* Linux
* Windows (later)


