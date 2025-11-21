# ROXANE - Centralized Portal with Laravel, React & Keycloak SSO

This project is a **centralized portal application & web hosting association ERP** built with **Laravel 12 & React19**, designed to provide a seamless and secure entry point for both **end users** and **administrators**.

-  **Front Office (Users)**
      - Build on React19 
      - (V2) Authentication via **Keycloak SSO (OIDC)**
      - Unified dashboard to access external applications (cloud storage, mailing tools, file sharing, etc.)
      - Role-based access control synced from Keycloak
      - Connected with : ISP Config for web hosting and mailbox management, NextCloud, Sympa for mailing list and more...
-  **Back Office (Admins)**
    - Authentication handled **locally in Laravel** (separate from Keycloak)
    - Built with **FilamentPHP**
    - Advanced admin features: app configuration, user activity logs, monitoring
-  **Security & API**
    - JWT validation for user-facing APIs (via Keycloak)
    - Laravel Sanctum / API tokens for admin endpoints
    - Support for MFA, Single Logout, and audit logging
-  **Tech Stack Highlights**
    - Laravel 12 (PHP 8.3)
    - Blade + Livewire (back office UI)
    - React19 (front office UI)
    - TailwindCSS (UI framework)
    - Keycloak SSO (OIDC) (V2)
    - FilamentPHP (admin panel)
    - Redis (cache, sessions, queues)
    - Maria DB
    - Docker-ready + CI/CD support and automated deploy

This architecture allows associations to **centralize authentication and app access** while keeping the **admin back office independent and highly secure**.
