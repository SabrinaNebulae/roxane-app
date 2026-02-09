# Roxane - Structure du projet

Roxane est une application de gestion d'adhésions pour **Le Retzien Libre**, une association libre/open source.
Elle gère les membres, les cotisations, et s'intègre avec des services tiers (Dolibarr, ISPConfig, Nextcloud).

## Stack technique

| Couche    | Technologies                                      |
| --------- | ------------------------------------------------- |
| Backend   | Laravel 12, PHP 8.4, MySQL                        |
| Admin     | Filament v4, Livewire 3                           |
| Frontend  | React 19, Inertia v2, Tailwind CSS v4             |
| Auth      | Laravel Fortify, 2FA, Spatie Permissions + Shield |
| Tests     | PHPUnit 11                                        |
| DevTools  | Pint, ESLint, Prettier, Sail, Wayfinder           |

---

## Modeles Eloquent

### User

- **Table** : `users`
- **Traits** : HasRoles, TwoFactorAuthenticatable, HasFactory, Notifiable
- **Relations** : `members()` hasMany(Member)
- **Role** : Compte utilisateur de l'application. Implemente `FilamentUser` pour l'acces admin.

### Member

- **Table** : `members` (soft deletes)
- **Champs cles** : `user_id`, `dolibarr_id`, `keycloak_id`, `status`, `nature`, `group_id`, lastname, firstname, email, company, date_of_birth, address, zipcode, city, country, phone1, phone2, public_membership, website_url
- **Statuts** : draft, valid, pending, cancelled, excluded
- **Natures** : physical, legal
- **Relations** :
  - `user()` belongsTo(User)
  - `group()` belongsTo(MemberGroup)
  - `memberships()` hasMany(Membership)
  - `ispconfigs()` hasMany(IspconfigMember)
  - `nextcloudAccounts()` hasMany(NextCloudMember)
- **Accessors** : `full_name`, `retzien_email`
- **Methodes** : `lastMembership()`, `hasService()`, `isExpired()`

### Membership

- **Table** : `memberships` (soft deletes)
- **Champs cles** : `member_id`, `admin_id`, `package_id`, start_date, end_date, status, validation_date, payment_method, amount, payment_status, note_public, note_private, dolibarr_id
- **Statuts** : active, expired, pending
- **Statuts paiement** : paid, unpaid, partial
- **Relations** :
  - `member()` belongsTo(Member)
  - `author()` belongsTo(User, 'admin_id')
  - `package()` belongsTo(Package)
  - `services()` belongsToMany(Service) via `services_memberships`

### Package

- **Table** : `packages`
- **Champs** : identifier, name, description, price, is_active
- **Donnees** : custom (1EUR), one-year (12EUR), two-years (24EUR)

### Service

- **Table** : `services`
- **Champs** : identifier, name, description, url, icon
- **Relations** : `memberships()` belongsToMany(Membership)
- **Donnees** : mail (RoundCube), file2link, nextcloud, sympa (listes de diffusion), webhosting

### MemberGroup

- **Table** : `member_groups`
- **Champs** : name, description, identifier
- **Relations** : `members()` hasMany(Member)
- **Donnees** : admin-interface, website

### Contact

- **Table** : `contacts`
- **Champs** : firstname, lastname, email, address, subject, message

### IspconfigMember

- **Table** : `ispconfigs_members`
- **Champs** : member_id, ispconfig_client_id, ispconfig_service_user_id, email, type, data
- **Cast** : `type` vers IspconfigType enum, `data` vers array

### NextCloudMember

- **Table** : `nextclouds_members`
- **Champs** : member_id, nextcloud_user_id, data

---

## Enums

| Enum           | Valeurs                               |
| -------------- | ------------------------------------- |
| IspconfigType  | MAIL ("Email"), WEB ("Hebergement"), OTHER ("Autre") |

---

## Services (couche metier)

### ContactService

- `registerNewContactRequest(array $data)` : cree un enregistrement Contact

### MemberService

- `registerNewMember(array $data)` : cree un Member + Membership pending, assigne au groupe "website", declenche MemberRegistered
- `deactivateMember(Member $member)` : passe le statut a "excluded", desactive la cotisation, detache les services

### DolibarrService

Integration avec l'ERP Dolibarr via API REST.

- `getAllMembers()` : recupere la liste des membres
- `getMemberSubscriptions()` : recupere les cotisations d'un membre
- `updateMember()` : met a jour un membre

### ISPConfigService (base)

Integration via SOAP. Sous-classes :

**ISPConfigMailService** (serveur mail) :
- `getAllMailDomains()`, `getAllMailUsers()`
- `getMailDomainsForClient()`, `getMailUsersForDomain()`
- `getMailUserDetails()` : quota, usage, protocoles
- `updateMailUser()` : modification d'un compte mail

**ISPConfigWebService** (serveur web) :
- `getAllWebsites()`, `getAllDatabases()`, `getAllFtpUsers()`, `getAllShellUsers()`, `getAllDnsZones()`
- `getWebsiteCompleteInfo()` : infos agregees d'un site
- Gestion de cache avec invalidation

### NextcloudService

Integration avec l'API OCS Nextcloud.

- `disableUserByEmail()`, `disableUserById()`
- `listUsers()`, `getUserDetails()`
- `findUserIdByEmail()` : recherche avec cache 7 jours

---

## Commandes Artisan (synchronisation)

| Commande                          | Description                                              |
| --------------------------------- | -------------------------------------------------------- |
| `sync:dolibarr-members`           | Importe les membres et cotisations depuis Dolibarr       |
| `members:cleanup-expired`         | Desactive les membres expires (Dolibarr + ISPConfig mail + Nextcloud). Supporte `--dry-run` |
| `sync:ispconfig-mail-members`     | Lie les membres a leurs comptes mail ISPConfig (@retzien.fr) |
| `sync:ispconfig-web-members`      | Lie les membres a leurs comptes d'hebergement web        |
| `sync:nextcloud-members`          | Lie les membres a leurs comptes Nextcloud                |
| `sync:services-members`           | Synchronise les services associes aux membres            |

---

## Routes

### Publiques

| Methode   | URI              | Description                     |
| --------- | ---------------- | ------------------------------- |
| GET       | `/welcome`       | Page d'accueil (home)           |
| GET       | `/`              | Page de maintenance             |
| GET/POST  | `/contact`       | Formulaire de contact           |
| GET/POST  | `/membership`    | Formulaire d'adhesion           |

### Authentification (guest)

| Methode   | URI                      | Description                |
| --------- | ------------------------ | -------------------------- |
| GET/POST  | `/login`                 | Connexion                  |
| GET/POST  | `/register`              | Inscription                |
| GET/POST  | `/forgot-password`       | Mot de passe oublie        |
| GET/POST  | `/reset-password/{token}`| Reinitialisation           |
| GET/POST  | `/two-factor-challenge`  | Challenge 2FA              |

### Authentifie

| Methode       | URI                      | Description                |
| ------------- | ------------------------ | -------------------------- |
| GET           | `/dashboard`             | Tableau de bord            |
| GET/PATCH/DEL | `/settings/profile`      | Profil utilisateur         |
| GET/PUT       | `/settings/password`     | Mot de passe               |
| GET           | `/settings/appearance`   | Theme / apparence          |
| GET           | `/settings/two-factor`   | Configuration 2FA          |
| GET           | `/verify-email`          | Verification email         |
| POST          | `/logout`                | Deconnexion                |

### Admin (Filament)

| URI                        | Ressource              |
| -------------------------- | ---------------------- |
| `/admin`                   | Dashboard              |
| `/admin/members`           | Gestion des membres    |
| `/admin/memberships`       | Gestion des cotisations|
| `/admin/packages`          | Formules d'adhesion    |
| `/admin/services`          | Services numeriques    |
| `/admin/member-groups`     | Groupes de membres     |
| `/admin/users`             | Utilisateurs           |
| `/admin/shield/roles`      | Roles et permissions   |

---

## Panel Admin (Filament v4)

### Ressources

Chaque ressource suit une structure modulaire :

```
app/Filament/Resources/<Nom>/
  ├── <Nom>Resource.php        # Definition (modele, navigation, schema, table)
  ├── Schemas/<Nom>Form.php    # Formulaire
  ├── Tables/<Nom>sTable.php   # Tableau
  ├── Pages/
  │   ├── List<Nom>s.php
  │   ├── Create<Nom>.php
  │   └── Edit<Nom>.php
  ├── Widgets/                 # (optionnel)
  └── RelationManagers/        # (optionnel)
```

**Ressources disponibles** : MemberResource, MembershipResource, PackageResource, ServiceResource, MemberGroupResource, UserResource

**Widgets** : MemberCount, MembershipsChart

**Actions custom** : ServiceToggleAction

### Permissions (Spatie + Shield)

Format : `Action:Modele` en PascalCase (ex: `ViewAny:Member`, `Create:Membership`)

Roles :
- `super_admin` : acces complet
- `panel_user` : acces au panel avec permissions specifiques

Chaque modele a sa Policy associee verifiant les permissions Spatie.

---

## Frontend (React + Inertia v2)

### Pages

```
resources/js/pages/
  ├── welcome.tsx                  # Accueil
  ├── maintenance.tsx              # Maintenance
  ├── dashboard.tsx                # Tableau de bord (placeholder)
  ├── auth/
  │   ├── login.tsx
  │   ├── register.tsx
  │   ├── forgot-password.tsx
  │   ├── reset-password.tsx
  │   ├── verify-email.tsx
  │   ├── confirm-password.tsx
  │   └── two-factor-challenge.tsx
  ├── forms/
  │   ├── contact.tsx              # Formulaire de contact
  │   └── membership.tsx           # Formulaire d'adhesion
  └── settings/
      ├── profile.tsx
      ├── password.tsx
      ├── two-factor.tsx
      └── appearance.tsx
```

### Composants principaux

```
resources/js/components/
  ├── app-shell.tsx                # Layout principal
  ├── app-header.tsx / app-sidebar.tsx
  ├── nav-main.tsx / nav-user.tsx / nav-footer.tsx
  ├── breadcrumbs.tsx
  ├── flash-message.tsx
  ├── two-factor-setup-modal.tsx
  ├── appearance-tabs.tsx
  └── ui/                         # Composants Shadcn/ui
```

---

## Notifications

| Classe                       | Canal | Description                        |
| ---------------------------- | ----- | ---------------------------------- |
| SubscriptionExpiredPhase1    | Email | Notification d'expiration d'adhesion (queued) |

---

## Configuration externe

Definie dans `config/services.php` via variables d'environnement :

| Service | Type d'integration  | Description                                |
|--------|---------------------|--------------------------------------------|
| Dolibarr | API REST + htaccess | ERP - gestion des adherents et cotisations |
| ISPConfig | SOAP (3 serveurs)   | Mail, hebergement web, test. Cache 5 min   |
| Nextcloud | API OCS             | Comptes cloud des membres                  |
| Sympa  | Mail Listing        | Liste de diffusion mail (à venir)          |

---

## Localisation

Langues supportees : **francais** (fr), **anglais** (en)

Fichiers de traduction par modele dans `lang/{locale}/` : contacts, members, memberships, packages, services, users, member_groups.

---

## Seeders

Le `DatabaseSeeder` cree :
- 1 super admin (contact@nebulae-design.com)
- 2 groupes de membres (admin-interface, website)
- 3 formules (custom, one-year, two-years)
- 5 services (mail, file2link, nextcloud, sympa, webhosting)
- 1 utilisateur test (JaneDoe) avec profil membre et cotisation active

---

## TODOs identifies dans le code

| Fichier                          | TODO                                                |
| -------------------------------- | --------------------------------------------------- |
| ContactService                   | Envoyer un email a l'administrateur                 |
| MemberService                    | Envoyer des emails au membre + admin a la desactivation |
| SubscriptionExpiredPhase1        | Creer un template generique + UI backend pour le contenu |
| User.php                         | Restreindre l'acces admin en prod aux emails @retzien.fr |
| SyncDolibarrMembers              | Exporter la methode toDate() dans un service/helper |
| SyncISPConfigMailMembers         | Gerer plusieurs emails par membre                   |
| SyncISPConfigMailMembers         | Ajouter le suivi ispconfig_client_id                |
| MembershipFormController         | Supprimer le `dd()` de debug (ligne 37)             |
