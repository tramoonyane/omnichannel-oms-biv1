# OmniChannel OMS-BI

## Overview

**OmniChannel OMS-BI (Order Management System & Business Intelligence Platform)** is a decoupled full-stack application that simulates enterprise-level omnichannel retail operations.

The system centralizes inventory management, order processing, business analytics, and secure user authentication into a single platform capable of supporting multiple sales channels through standardized RESTful API contracts.

The project demonstrates modern backend architecture by separating presentation, business logic, authentication, authorization, and data access into independent layers while exposing a JSON-based API consumed by an independent frontend.

---

# Project Goals

The primary objective of the project is to demonstrate practical software engineering principles through the development of a scalable business application.

The project focuses on:

- Software architecture
- REST API development
- Business logic implementation
- Relational database design
- Authentication and authorization
- Inventory management
- Order management
- Business intelligence and analytics
- Frontend-backend separation
- Technology-independent system design

---

# Technology Stack

## Backend

- PHP 8
- Slim Framework 4
- MySQL
- Composer
- JSON Web Tokens (JWT)

## Frontend

- HTML5
- CSS3
- Vanilla JavaScript

## Development Tools

- Git
- GitHub
- Postman
- XAMPP

---

# Core Business Domains

The platform is built around four primary business domains.

## Inventory Management

Responsible for:

- Product management
- Stock tracking
- Inventory valuation
- Low-stock monitoring

---

## Order Management

Responsible for:

- Order creation
- Order processing
- Order-item relationships
- Sales transactions

---

## Authentication & Authorization

Responsible for:

- Secure login
- JWT generation
- Token validation
- Role-based authorization
- Protected API access

Supported roles currently include:

- Admin
- Manager

---

## Business Intelligence

Provides operational insights including:

- Sales overview
- Revenue analysis
- Inventory overview
- Low-stock alerts
- Top-selling products
- Dashboard summaries

---

# System Architecture

The application follows a decoupled architecture where the frontend and backend evolve independently.

```
Frontend
      │
      ▼
REST API
      │
      ▼
Controllers
      │
      ▼
Presentation Services
      │
      ▼
Business Services
      │
      ▼
Database
```

The frontend never communicates directly with the database.

All requests pass through backend controllers where validation, business rules, and processing occur before data persistence.

---

# Backend Architecture

The backend follows a layered architecture that separates responsibilities across multiple application layers.

```
HTTP Request
      │
      ▼
JWT Authentication Middleware
      │
      ▼
Role Authorization Middleware
      │
      ▼
Controller
      │
      ▼
Presentation Service
      │
      ▼
Business Service
      │
      ▼
Database
```

This design promotes:

- Loose coupling
- High cohesion
- Maintainability
- Scalability
- Testability

---

# Authentication

The backend uses **JSON Web Tokens (JWT)** for stateless authentication.

Authentication flow:

```
Client Login
      │
      ▼
Credential Validation
      │
      ▼
JWT Generation
      │
      ▼
Bearer Token
      │
      ▼
Authenticated Requests
      │
      ▼
JWT Authentication Middleware
      │
      ▼
Role Authorization Middleware
      │
      ▼
Protected Endpoint
```

After successful authentication, every protected endpoint validates the JWT before business logic is executed.

---

# Authorization

Authorization is enforced through dedicated middleware.

Instead of allowing business services to determine the authenticated user, middleware attaches the authenticated user to the request.

Controllers then pass only the required data (such as the user's role) into the service layer.

Example:

```
HTTP Request
      │
      ▼
Authenticated User
      │
      ▼
Dashboard Controller
      │
      ▼
Dashboard Service(role)
```

This keeps business services independent of:

- HTTP
- JWT
- Middleware
- Authentication implementation

---

# REST API

The backend exposes RESTful JSON endpoints for:

- Authentication
- Dashboard
- Inventory
- Orders
- Sales Analytics
- Inventory Analytics
- Chart Data

Protected endpoints require a valid JWT bearer token.

---

# Request Lifecycle

Example order creation workflow:

```
User Creates Order
        │
        ▼
Frontend Form
        │
        ▼
POST /api/v1/orders
        │
        ▼
Authentication Middleware
        │
        ▼
Order Controller
        │
        ▼
Business Validation
        │
        ▼
Database Transaction
        │
        ▼
JSON Response
        │
        ▼
Frontend Update
```

This request flow is consistently applied across the application.

---

# Current Features

- JWT Authentication
- Role-Based Authorization
- RESTful JSON API
- Dashboard Summary
- Inventory Management
- Order Management
- Sales Analytics
- Inventory Analytics
- Business Intelligence Reporting
- Chart Data APIs
- Layered Backend Architecture
- Decoupled Frontend and Backend

---

# Architectural Philosophy

Business concepts remain constant.

Technologies evolve.

Products, inventory, orders, users, analytics, and business workflows are the permanent foundations of the system.

Programming languages, frameworks, databases, and frontend technologies are implementation details that can evolve without changing the underlying business model.

This philosophy allows the project to adapt to future technologies while preserving the core business domain.

---

# Future Enhancements

The current backend represents the project's core functionality.

Future improvements may include:

- Frontend completion
- Interactive dashboards
- Advanced filtering and search
- Pagination
- API documentation (OpenAPI / Swagger)
- Unit and integration testing
- Docker support
- CI/CD pipeline
- Audit logging
- Refresh tokens
- Performance optimization
- Caching

---

# Project Status

✅ Backend Core Complete

- JWT Authentication implemented
- Role-Based Authorization implemented
- REST API completed
- Business services implemented
- Analytics completed
- Inventory module completed
- Order management completed

🚧 Frontend Development In Progress

The current focus is completing the frontend application that consumes the REST API.

After frontend completion, future work will primarily consist of enhancements, testing, documentation improvements, and deployment.