# OmniChannel OMS-BI Frontend Architecture

## Overview

The OmniChannel OMS-BI frontend is a standalone client application responsible for presenting business information and interacting with the backend REST API.

The frontend is designed as a separate application layer that communicates with the backend exclusively through HTTP requests and JSON responses.

The frontend does not communicate directly with the database and does not contain backend business logic.

Its responsibilities are:

- User interface rendering
- User interaction handling
- API communication
- JWT authentication handling
- Data presentation
- Reusable UI components

The backend remains responsible for:

- Authentication
- Authorization
- Business rules
- Data processing
- Database communication

---

# High-Level System Architecture

The complete system follows a decoupled full-stack architecture.

```
                    User

                     |
                     ▼

          Frontend Application

       HTML + CSS + JavaScript

                     |
                     |
             HTTP / JSON / JWT

                     |
                     ▼

              Backend REST API

                     |
                     ▼

             Authentication Middleware

                     |
                     ▼

                 Controllers

                     |
                     ▼

              Service Layer

                     |
                     ▼

                Model Layer

                     |
                     ▼

                Database
```

The frontend and backend communicate only through defined API contracts.

---

# Frontend Architecture

The frontend follows a layered architecture.

```
Frontend

|
├── Pages
|
├── Controllers
|
├── Services
|
├── Components
|
├── Utilities
|
└── Assets
```

Each layer has a specific responsibility.

---

# Frontend Directory Structure

```
frontend/

├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── icons/
│
├── pages/
│   ├── login.html
│   ├── dashboard.html
│   ├── inventory.html
│   ├── orders.html
│   └── analytics.html
│
├── components/
│   ├── navbar.js
│   ├── sidebar.js
│   ├── modal.js
│   ├── table.js
│   └── chart.js
│
├── services/
│   ├── api.js
│   ├── auth.service.js
│   ├── dashboard.service.js
│   ├── inventory.service.js
│   ├── orders.service.js
│   └── analytics.service.js
│
├── controllers/
│   ├── login.controller.js
│   ├── dashboard.controller.js
│   ├── inventory.controller.js
│   ├── orders.controller.js
│   └── analytics.controller.js
│
├── utils/
│   ├── storage.js
│   ├── auth.js
│   ├── constants.js
│   └── helpers.js
│
└── index.html
```

---

# Frontend Request Flow

A typical frontend request follows this flow:

```
User Action

     |
     ▼

HTML Page

     |
     ▼

Frontend Controller

     |
     ▼

Frontend Service

     |
     ▼

API Communication Layer

     |
     ▼

Backend REST API

     |
     ▼

Backend Controller

     |
     ▼

Backend Service

     |
     ▼

Backend Model

     |
     ▼

Database
```

The response follows the reverse path:

```
Database

     |
     ▼

Backend Model

     |
     ▼

Backend Service

     |
     ▼

Backend Controller

     |
     ▼

JSON Response

     |
     ▼

Frontend API Layer

     |
     ▼

Frontend Service

     |
     ▼

Frontend Controller

     |
     ▼

User Interface
```

---

# Pages Layer

Location:

```
pages/
```

The pages layer contains application screens.

Examples:

- Login page
- Dashboard page
- Inventory page
- Orders page
- Analytics page

Responsibilities:

- Define page structure
- Provide HTML containers
- Load required JavaScript modules

Pages should not:

- Call backend APIs directly
- Handle JWT logic
- Contain business logic

Example:

```
dashboard.html

       |
       ▼

dashboard.controller.js
```

---

# Controllers Layer

Location:

```
controllers/
```

Controllers coordinate user actions.

They act as the connection between the user interface and frontend services.

Responsibilities:

- Initialize pages
- Handle user events
- Request data from services
- Update UI components

Example:

```
User clicks dashboard refresh

          |
          ▼

dashboard.controller.js

          |
          ▼

dashboard.service.js
```

Controllers should not:

- Perform HTTP requests directly
- Store tokens
- Implement business rules

---

# Services Layer

Location:

```
services/
```

Services communicate with backend endpoints.

Each business domain has its own service.

Examples:

```
auth.service.js

dashboard.service.js

inventory.service.js

orders.service.js

analytics.service.js
```

Responsibilities:

- Call API endpoints
- Process API responses
- Provide data to controllers

Example:

```
dashboard.controller.js

          |
          ▼

dashboard.service.js

          |
          ▼

GET /api/v1/analytics/dashboard/summary
```

---

# API Communication Layer

Location:

```
services/api.js
```

The API layer is the single communication point between frontend and backend.

Responsibilities:

- Manage HTTP requests
- Attach JWT tokens
- Handle API responses
- Manage request configuration

The rest of the frontend should not directly use:

```
fetch()
```

All backend communication should go through:

```
api.js
```

This prevents duplicated communication logic.

---

# Authentication Architecture

The frontend uses JWT authentication provided by the backend.

Authentication flow:

```
User Login

      |
      ▼

login.controller.js

      |
      ▼

auth.service.js

      |
      ▼

POST /api/v1/auth/login

      |
      ▼

JWT Token Returned

      |
      ▼

storage.js

      |
      ▼

Token Stored
```

For protected API requests:

```
Frontend Service

       |
       ▼

api.js

       |
       ▼

Authorization Header

Bearer JWT Token

       |
       ▼

Backend Authentication Middleware

       |
       ▼

Protected Endpoint
```

---

# Components Layer

Location:

```
components/
```

Components are reusable UI elements.

Examples:

- Navigation bar
- Sidebar
- Tables
- Modals
- Charts

The purpose of components is to prevent duplicated interface code.

Example:

Instead of creating multiple navigation bars:

```
dashboard.html

inventory.html

orders.html
```

a reusable component is created:

```
navbar.js
```

---

# Utilities Layer

Location:

```
utils/
```

Utilities contain shared functionality.

Examples:

## storage.js

Responsible for:

- Saving JWT tokens
- Retrieving JWT tokens
- Removing JWT tokens

## auth.js

Responsible for:

- Checking authentication status
- Protecting frontend pages
- Redirecting unauthorized users

## helpers.js

Contains reusable helper functions.

---

# Frontend and Backend Responsibility Separation

## Frontend Responsibilities

The frontend handles:

- Presentation
- User interaction
- API consumption
- Client-side state
- UI updates

## Backend Responsibilities

The backend handles:

- Authentication
- Authorization
- Validation
- Business logic
- Database operations

The frontend never directly communicates with:

- Database
- Backend models
- Backend services

---

# Architectural Benefits

## Maintainability

Each layer has a clear responsibility.

Changes in one layer do not require rewriting the entire application.

---

## Scalability

New modules can be added independently.

Example:

```
products/

customers/

reports/
```

without affecting existing modules.

---

## Technology Independence

The frontend depends only on API contracts.

The backend could change implementation technology while preserving frontend functionality.

---

# Future Enhancements

Possible future frontend improvements:

- Migration to TypeScript
- Component framework adoption (React/Vue)
- Frontend routing
- Automated testing
- State management
- Progressive Web App features
- Improved UI/UX design

---

# Project Status

Frontend development is currently in progress.

The objective is to provide a complete client application consuming the existing OmniChannel OMS-BI REST API.