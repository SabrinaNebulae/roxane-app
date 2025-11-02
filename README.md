# LRL APP - Centralized Portal with Laravel, React & Keycloak SSO

This project is a **centralized portal application** built with **Laravel 12 & React19**, designed to provide a seamless and secure entry point for both **end users** and **administrators**.

-  **Front Office (Users)**
      - Build on React19 
      - (V2) Authentication via **Keycloak SSO (OIDC)**
      - Unified dashboard to access external applications (cloud storage, mailing tools, file sharing, etc.)
      - Role-based access control synced from Keycloak
-  **Back Office (Admins)**
    - Authentication handled **locally in Laravel** (separate from Keycloak)
    - Built with **FilamentPHP** for a modern and intuitive admin panel
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
    - Keycloak SSO (OIDC)
    - FilamentPHP (admin panel)
    - Redis (cache, sessions, queues)
    - MySQL (PostgreSQL coming soon)
    - Docker-ready + CI/CD support (coming soon)

This architecture allows associations to **centralize authentication and app access** while keeping the **admin back office independent and highly secure**.
