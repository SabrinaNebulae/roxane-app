---
title: Schéma de Base de Données - Roxane - Le Retzien Libre
---
erDiagram
users ||--o{ members : "a"
users ||--o{ memberships : "gère (admin)"
users ||--o{ sessions : "a"
users ||--o| password_reset_tokens : "peut avoir"

    members }o--|| users : "appartient à"
    members }o--|| membergroups : "dans le groupe"
    members ||--o{ memberships : "a des adhésions"
    
    memberships }o--|| members : "pour"
    memberships }o--|| packages : "utilise"
    memberships }o--|| users : "créé par (admin)"
    
    membergroups ||--o{ members : "contient"
    
    packages ||--o{ memberships : "inclus dans"
    
    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at "nullable"
        string password
        string remember_token "nullable"
        timestamp created_at
        timestamp updated_at
    }
    
    password_reset_tokens {
        string email PK
        string token
        timestamp created_at "nullable"
    }
    
    sessions {
        string id PK
        bigint user_id FK "nullable, indexed"
        string ip_address "nullable, max 45"
        text user_agent "nullable"
        longtext payload
        integer last_activity "indexed"
    }
    
    members {
        bigint id PK
        bigint user_id FK
        string keycloak_id "nullable"
        string status "valid/pending/expired"
        string nature "physical/moral"
        bigint group_id FK
        string lastname
        string firstname
        string email
        string company "nullable"
        date date_of_birth "nullable"
        text address "nullable"
        string zipcode "nullable"
        string city "nullable"
        string country "nullable"
        string phone1 "nullable"
        string phone2 "nullable"
        boolean public_membership "default false"
        timestamp created_at
        timestamp updated_at
    }
    
    membergroups {
        bigint id PK
        string identifier UK
        string name
        text description "nullable"
        timestamp created_at
        timestamp updated_at
    }
    
    packages {
        bigint id PK
        string identifier UK
        string name
        text description "nullable"
        boolean is_active "default true"
        timestamp created_at
        timestamp updated_at
    }
    
    services {
        bigint id PK
        string identifier UK
        string name
        text description "nullable"
        string url "nullable"
        string icon "nullable"
        timestamp created_at
        timestamp updated_at
    }
    
    memberships {
        bigint id PK
        bigint member_id FK
        bigint admin_id FK "créateur"
        bigint package_id FK
        date start_date
        date end_date
        string status "active/expired/cancelled"
        decimal amount "montant payé"
        string payment_status "paid/pending/failed"
        timestamp created_at
        timestamp updated_at
    }
