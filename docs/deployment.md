# OMS-BI Deployment Guide

## Overview

OMS-BI is deployed as a PHP Slim Framework application with a Vanilla JavaScript frontend and MySQL database.

The application structure:


omnichannel-oms-bi
│
├── public
│ ├── api.php
│ └── frontend
│
├── src
│
├── database
│ ├── schema.sql
│ └── seed.sql
│
├── composer.json
└── .env


The web server document root must point to:


/public


---

# Requirements

The server requires:

- PHP 8+
- Composer
- MySQL/MariaDB
- Apache or Nginx
- Apache mod_rewrite enabled (if using Apache)

---

# Deployment Steps

## 1. Clone Repository

```bash
git clone <repository-url>

cd omnichannel-oms-bi
2. Install Dependencies

Install PHP dependencies:

composer install
3. Configure Environment Variables

Create a production .env file:

APP_NAME="Omnichannel OMS BI"
APP_ENV=production

DB_HOST=localhost
DB_NAME=database_name
DB_USER=database_user
DB_PASS=database_password

JWT_SECRET="your_secure_secret"
JWT_EXPIRES=3600

The .env file must not be committed to version control.

4. Database Setup

Create the database:

CREATE DATABASE omnichannel_oms_biv1;

Import the database structure:

mysql -u username -p omnichannel_oms_biv1 < database/schema.sql

Import demo data:

mysql -u username -p omnichannel_oms_biv1 < database/seed.sql
5. Configure Web Server

Set the document root to:

public/

The API entry point is:

public/api.php

API requests are routed through:

/api/v1

using the configured .htaccess rules.

6. Verify Deployment

Open the frontend:

https://your-domain.com/frontend/pages/login.html

Verify:

Login works
JWT authentication works
Dashboard loads
API requests return data
Production Checklist

Before going live:

Remove development test files
Keep .env private
Disable debug error output
Use HTTPS
Configure database backups

This is enough for a reviewer. It tells them **how to deploy OMS-BI** without turning `deployment.md` into a second README. 👍