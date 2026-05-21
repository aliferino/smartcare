# SmartCare - Platform Penggalangan Dana Digital

Platform web untuk penggalangan dana yang menghubungkan fundraiser dengan donor untuk mendukung berbagai kampanye sosial dan kemanusiaan.

## Tech Stack

| Tool            | Version / Notes                               |
|-----------------|-----------------------------------------------|
| Laravel         | 12                                            |
| PHP             | 8.2+                                          |
| MySQL           | Database server                               |
| Vite            | 7.0+ - Build tool & dev server                |
| Tailwind CSS    | 4.0 - Utility-first CSS framework             |
| Axios           | 1.11+ - HTTP client for API requests          |
| Pest PHP        | 4.3+ - Testing framework                      |
| Laravel Pint    | Code formatting & linting                     |
| Concurrently    | 9.0.1 - Run multiple processes simultaneously |
| Eloquent        | ORM for database operations                   |
| Blade           | Template engine for views                     |

## Project Structure

```
smartcare/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Auth/             # Login & Register
│   │       ├── Admin/            # Admin panel controllers
│   │       ├── Fundraiser/       # Fundraiser dashboard controllers
│   │       └── Web/              # Public website controllers
│   ├── Models/                   # Eloquent models
│   │   ├── User
│   │   ├── Campaign
│   │   ├── Entity
│   │   ├── Donation
│   │   ├── Withdraw
│   │   ├── Citizen (KYC)
│   │   ├── CampaignCategory
│   │   ├── EntityCategory
│   │   ├── CampaignImage
│   │   ├── CampaignUpdate
│   │   └── Notification
│   └── ...
├── database/
│   ├── migrations/               # Database schema
│   ├── factories/                # Model factories
│   └── seeders/                  # Database seeders
├── resources/
│   └── views/
│       ├── layouts/              # Layout templates
│       ├── admin/                # Admin panel views
│       ├── fundraiser/           # Fundraiser dashboard views
│       ├── web/                  # Public website views
│       └── auth/                 # Login & Register views
├── routes/
│   └── web.php                   # All application routes
├── package.json                  # Frontend dependencies
└── composer.json                 # Backend dependencies
```

## Database Schema

### Core Tables
- **users** - User accounts (admin, fundraiser)
- **citizens** - KYC/Citizen data
- **campaigns** - Penggalangan dana campaigns
- **entities** - Entitas penerima (organisasi/individu)
- **donations** - Donasi dari donor
- **withdrawals** - Penarikan dana oleh fundraiser
- **notifications** - Notifikasi sistem

### Reference Tables
- **campaign_categories** - Kategori kampanye
- **entity_categories** - Kategori entitas
- **campaign_images** - Gambar kampanye
- **campaign_updates** - Update kampanye

## Features

### 🔐 Authentication
- ✅ User registration (admin & fundraiser)
- ✅ User login
- ✅ Role-based access control
- ✅ Logout

### 👨‍💼 Admin Panel
- ✅ Dashboard overview
- ✅ View entities (all, pending, approved, rejected)
- ✅ Entity categories (CRUD)
- ✅ Update entity status
- ✅ Toggle entity active/inactive
- ✅ View campaigns (all, pending, approved, rejected, completed)
- ✅ Campaign categories (CRUD)
- ✅ Update campaign status
- ✅ Toggle campaign active/inactive
- ✅ View all donations
- ✅ View users list
- ✅ View user details
- ✅ Create user
- ✅ Update user
- ✅ Delete user

### 💰 Fundraiser Dashboard
- ✅ Dashboard overview
- 🚧 Create entity
- 🚧 View entities list
- 🚧 Edit entity
- 🚧 Delete entity
- 🚧 Create campaign
- 🚧 View campaigns list
- 🚧 Edit campaign
- 🚧 Delete campaign
- 🚧 View profile
- 🚧 Update profile
- 🚧 View donations
- 🚧 View withdrawals
- 🚧 Submit KYC form
- 🚧 Campaign updates/news posting
- 🚧 Campaign analytics
- 🚧 Withdrawal request & approval flow
- 🚧 KYC verification status tracking

### 🌐 Public Website
- ✅ Home page (list campaigns)
- 🚧 Campaign detail page
- 🚧 Campaign search & filtering
- 🚧 Donor registration
- 🚧 Donation functionality
- 🚧 Payment gateway integration
- 🚧 Donor dashboard

### 📊 Additional Features
- 🚧 Email notifications
- 🚧 Image upload & management
- 🚧 Campaign completion workflow
- 🚧 Admin reports & statistics
- 🚧 Refund/cancellation handling

## Key Routes

### Public Routes
- `GET /` - Home page
- `GET /campaigns/{slug}` - Campaign detail

### Auth Routes
- `GET /login` - Login form
- `POST /login` - Login action
- `GET /register` - Register form
- `POST /register` - Register action
- `POST /logout` - Logout

### Admin Routes (prefix: `/admin`)
- `/dashboard` - Dashboard
- `/entities/*` - Entity management
- `/campaigns/*` - Campaign management
- `/donations` - Donations list
- `/users/*` - User management & KYC

### Fundraiser Routes (prefix: `/fundraiser`)
- `/dashboard` - Dashboard
- `/entities/*` - Entity CRUD
- `/campaigns/*` - Campaign CRUD
- `/profile` - Profile management
- `/donations` - Donations list
- `/withdraw` - Withdrawals list
- `/kyc` - KYC form & submission

## Code Conventions

### Variable Naming
- **Modal state**: `open{EntityName}` (e.g., `openCampaigns`, `openEntities`, `openUsers`)
- **Form data**: `form{EntityName}` (e.g., `formCampaign`, `formEntity`)
- **Loading state**: `loading{Action}` (e.g., `loadingSubmit`, `loadingDelete`)
- **Error state**: `error{Action}` (e.g., `errorSubmit`, `errorValidation`)
- **List data**: `{entityName}List` (e.g., `campaignList`, `entityList`)
- **Selected item**: `selected{EntityName}` (e.g., `selectedCampaign`, `selectedEntity`)

### File & Folder Naming
- **Controllers**: PascalCase (e.g., `CampaignController.php`)
- **Models**: PascalCase (e.g., `Campaign.php`)
- **Views**: kebab-case (e.g., `campaign-list.blade.php`)
- **Routes**: kebab-case in URL (e.g., `/admin/campaigns/list`)
- **JavaScript files**: camelCase (e.g., `campaignModal.js`)

### Component Structure
- **Modals**: Separate file with `_modal.blade.php` suffix
- **Tables**: Separate file with `_table.blade.php` suffix
- **Forms**: Inline or separate file with `_form.blade.php` suffix
- **Partials**: Use `_` prefix for partial files

### UI/UX Consistency
- **Search bar**: Always at top-left of table section
- **Action buttons**: Always at top-right (Create/Add button)
- **Table actions**: Edit, Delete buttons at right side of each row
- **Modal naming**: Match the entity (Campaign modal = openCampaigns)
- **Button styling**: Use consistent Tailwind classes across all pages

## Do Not

- ❌ Do not use inconsistent variable naming across pages
- ❌ Do not create modals without following the `open{EntityName}` convention
- ❌ Do not place search bars or action buttons in different locations
- ❌ Do not mix camelCase and snake_case in the same file
- ❌ Do not create new UI patterns without checking existing implementations
- ❌ Do not hardcode styling - use Tailwind CSS classes
- ❌ Do not create duplicate components - reuse existing ones
- ❌ Do not forget to update CLAUDE.md when adding new conventions

## Development Commands

```bash
# Setup project
composer run setup

# Development (runs server, queue, vite concurrently)
composer run dev

# Run tests
composer run test

# Code formatting
./vendor/bin/pint

# Build frontend
npm run build

# Dev frontend
npm run dev
```

## Recent Changes

- Consolidated modal system into single universal Modal API (resources/js/modal.js)
- Deleted public/js/modal.js (replaced with Vite-compiled version)
- Updated entities, campaigns, and donations modals to use new Modal API
- Fixed modal scrolling and centering issues
- Added smooth fade-in/out animations (300ms ease-in-out)
- Fixed rounded corners with overflow-hidden
- Updated layout.blade.php to use @vite directive for asset loading
- Sidebar fundraiser updated
- Admin dashboard completed (temporary)
- Donations admin panel completed
- Campaign + entities admin panel completed
- KYC controllers removed (deleted)
- Public components removed (deleted)
- User management admin panel added

