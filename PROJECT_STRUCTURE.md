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
- **Traits** : HasRoles, TwoFactorAuthenticatable
- **Relations** : `members()` hasMany(Member)
- **Role** : Implemente `FilamentUser` pour l'acces admin.

### Member
- **Table** : `members` (soft deletes)
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
- **Statuts** : active, expired, pending
- **Statuts paiement** : paid, unpaid, partial
- **Relations** :
  - `member()` belongsTo(Member)
  - `author()` belongsTo(User, 'admin_id')
  - `package()` belongsTo(Package)
  - `services()` belongsToMany(Service) via `services_memberships`

### Package
- **Table** : `packages`
- **Donnees** : custom (1EUR), one-year (12EUR), two-years (24EUR)

### Service
- **Table** : `services`
- **Relations** : `memberships()` belongsToMany(Membership)
- **Donnees** : mail (RoundCube), file2link, nextcloud, sympa, webhosting

### MemberGroup
- **Table** : `member_groups`
- **Relations** : `members()` hasMany(Member)
- **Donnees** : admin-interface, website

### Contact
- **Table** : `contacts`

### IspconfigMember
- **Table** : `ispconfigs_members`
- **Cast** : `type` vers IspconfigType enum, `data` vers array

### NextCloudMember
- **Table** : `nextclouds_members`

---

## Enums

| Enum          | Valeurs                                               |
| ------------- | ----------------------------------------------------- |
| IspconfigType | MAIL ("Email"), WEB ("Hebergement"), OTHER ("Autre")  |

---

## Services (couche metier)

| Service                | Responsabilite                                              |
| ---------------------- | ----------------------------------------------------------- |
| ContactService         | Creation de demandes de contact                             |
| MemberService          | Inscription et desactivation de membres                     |
| DolibarrService        | Integration ERP via API REST                                |
| ISPConfigMailService   | Gestion comptes mail via SOAP                               |
| ISPConfigWebService    | Gestion hebergement web via SOAP (avec cache). Creation de clients et reassignation de sites |
| NextcloudService       | Gestion comptes Nextcloud via OCS (avec cache 7 jours)      |

---

## Commandes Artisan (synchronisation)

| Commande                        | Description                                                                    |
| ------------------------------- | ------------------------------------------------------------------------------ |
| `sync:dolibarr-members`         | Importe les membres et cotisations depuis Dolibarr                             |
| `members:cleanup-expired`       | Desactive les membres expires (Dolibarr + ISPConfig + Nextcloud). `--dry-run`  |
| `sync:ispconfig-mail-members`   | Lie les membres a leurs comptes mail ISPConfig (@retzien.fr)                   |
| `sync:ispconfig-web-members`    | Lie les membres a leurs comptes d'hebergement web                              |
| `ext:create-isp-accounts`       | Cree les clients ISPConfig pour les membres et reassigne leurs sites. `--dry-run`, `--force` |
| `nextcloud:sync-members`        | Lie les membres a leurs comptes Nextcloud                                      |
| `memberships:sync-services`     | Synchronise les services associes aux membres                                  |

---

## Panel Admin (Filament v4)

### Structure des ressources

```
app/Filament/Resources/<Nom>/
  ├── <Nom>Resource.php
  ├── Schemas/<Nom>Form.php
  ├── Tables/<Nom>sTable.php
  ├── Pages/ (List, Create, Edit)
  ├── Widgets/          (optionnel)
  └── RelationManagers/ (optionnel)
```

**Ressources** : MemberResource, MembershipResource, PackageResource, ServiceResource, MemberGroupResource, UserResource

**Pages custom** : Synchronisations (groupe "Paramètres" — lancement manuel des commandes Artisan)

**Widgets** : MemberCount, MembershipsChart

**Actions custom** : ServiceToggleAction

### Permissions (Spatie + Shield)

Format : `Action:Modele` en PascalCase (ex: `ViewAny:Member`, `Create:Membership`)

Roles :
- `super_admin` : acces complet
- `panel_user` : acces au panel avec permissions specifiques

---

## Frontend (React + Inertia v2)

### Pages

```
resources/js/pages/
  ├── welcome.tsx / maintenance.tsx / dashboard.tsx
  ├── auth/     (login, register, forgot-password, reset-password, verify-email, two-factor-challenge)
  ├── forms/    (contact.tsx, membership.tsx)
  └── settings/ (profile, password, two-factor, appearance)
```

### Composants principaux

```
resources/js/components/
  ├── app-shell.tsx / app-header.tsx / app-sidebar.tsx
  ├── nav-main.tsx / nav-user.tsx / nav-footer.tsx
  ├── breadcrumbs.tsx / flash-message.tsx
  ├── two-factor-setup-modal.tsx / appearance-tabs.tsx
  └── ui/ (Shadcn/ui)
```

---

## Notifications

Toutes les notifications sont queueable (`ShouldQueue`). Le template Blade `notifications/mail-template.blade.php` est partagé et accepte une variable `$appName` pour différencier les emails membres des emails admin.

| Classe                              | Canal | Destinataire | Déclencheur                                      |
| ----------------------------------- | ----- | ------------ | ------------------------------------------------ |
| ContactNewRequestNotification       | Email | Admin        | Soumission formulaire de contact                 |
| MemberNewRequestAdminNotification   | Email | Admin        | Soumission formulaire d'adhésion                 |
| MemberNewRequestMemberNotification  | Email | Membre       | Soumission formulaire d'adhésion (confirmation)  |
| MembershipValidatedNotification     | Email | Membre       | Validation admin d'une adhésion (action Filament)|
| MemberDeactivatedMemberNotification | Email | Membre       | Désactivation d'un membre                        |
| MemberDeactivatedAdminNotification  | Email | Admin        | Désactivation d'un membre                        |
| AdminInvitationNotification         | Email | Admin        | Création d'un compte administrateur              |
| AdminPasswordResetNotification      | Email | Admin        | Réinitialisation de mot de passe admin           |
| ServiceActivationRequestNotification| Email | Admin        | Demande d'activation de service (dashboard)      |
| SubscriptionExpiredPhase1           | Email | Membre       | Job planifié d'expiration d'adhésion             |

### Config app_name dans les emails
- Emails membres : `config('app.front_name')` (variable `FRONT_NAME` dans `.env`)
- Emails admin : `config('app.name')` (variable `APP_NAME` dans `.env`)

---

## Localisation

Langues : **fr**, **en** — fichiers dans `lang/{locale}/` : contacts, members, memberships, packages, services, users, member_groups, synchronisations.

---

## TODOs identifies dans le code

| Fichier                        | TODO                                                                           |
|--------------------------------|--------------------------------------------------------------------------------|
| Notifications (x9)             | Propager `appName` dans `->view()` pour toutes les notifications restantes     |
| SubscriptionExpiredPhase1      | UI backend pour éditer le contenu du template de notification                  |
| User.php                       | Restreindre l'acces admin en prod aux emails @retzien.fr                       |
| SyncDolibarrMembers            | Exporter la methode toDate() dans un service/helper                            |
| SyncISPConfigMailMembers       | Gerer plusieurs emails par membre                                              |
| SyncISPConfigMailMembers       | Ajouter le suivi ispconfig_client_id                                           |
| MembershipValidatedNotification| Ajouter lien HelloAsso vers le paiement quand disponible                       |
| Global                         | Refactoriser pour rendre générique le projet Roxane (ERP pour association)     |
| Traduction                     | Crawler le projet pour retrouver toutes les clés manquantes                    |
| Global                         | PHPstan niveau 8                                                               |
| dev-routes.php                 | Supprimer la route de test mail (/test/mail) avant mise en production          |
