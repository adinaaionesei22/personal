# Evonomix Ribbon Module

A comprehensive Magento 2 module for displaying configurable promotional ribbons on shop pages with advanced date range management, display options, and full admin interface.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Technical Architecture](#technical-architecture)
- [API Documentation](#api-documentation)
- [Database Schema](#database-schema)
- [Frontend Implementation](#frontend-implementation)
- [Admin Interface](#admin-interface)
- [Development](#development)
- [License](#license)

## Overview

The Evonomix Ribbon module provides a flexible solution for displaying promotional banners or ribbons on your Magento 2 storefront. Administrators can create, manage, and schedule ribbons with custom colors, content, and display rules. The module includes date range validation to prevent overlapping ribbons and supports both homepage-only and site-wide display options.

## Features

### Core Functionality

- **Ribbon Management**: Full CRUD operations for promotional ribbons
- **Date Range Control**: Start and end dates with automatic activation/deactivation
- **Display Options**: Choose between displaying on all pages or homepage only
- **Custom Styling**: Customizable band color for each ribbon
- **Link Support**: Optional clickable ribbons with custom URLs
- **Active Status Control**: Enable/disable ribbons without deletion
- **Date Range Validation**: Prevents overlapping ribbon schedules
- **Repository Pattern**: Modern Magento 2 architecture with repository interfaces
- **Strict Types**: Full PHP 7.4+ strict type declarations

### Admin Features

- **User-Friendly Interface**: Modern Magento 2 UI component forms
- **Grid Management**: Sortable and filterable ribbon listing
- **Visual Indicators**: Color-coded status and display page columns
- **Quick Actions**: Edit and delete actions directly from the grid
- **Form Validation**: Client and server-side validation
- **Color Picker**: Integrated color picker for band colors

### Frontend Features

- **Sticky Positioning**: Ribbons stay visible at the top while scrolling
- **Responsive Design**: Mobile-friendly ribbon display
- **Multiple Ribbons**: Support for displaying multiple active ribbons
- **Automatic Filtering**: Only displays ribbons within their date range
- **Page-Specific Display**: Respects homepage-only display settings

## Requirements

- **Magento 2.3.x, 2.4.x**
- **PHP**: 7.4.0, 8.1.0, or 8.2.0
- **MySQL**: 5.7+ or MariaDB 10.2+

## Installation

### Via Composer (Recommended)

```bash
composer require evonomix/module-ribbon
bin/magento module:enable Evonomix_Ribbon
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

### Manual Installation

1. Copy the module to `app/code/Evonomix/Ribbon/`
2. Run the following commands:

```bash
bin/magento module:enable Evonomix_Ribbon
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:flush
```

## Configuration

### Admin Access

Navigate to **Content → Ribbons → Manage Ribbons** in the Magento admin panel.

### Permissions

The module uses ACL resources:
- **Resource**: `Evonomix_Ribbon::ribbon`
- **Action**: `Evonomix_Ribbon::manage`

Assign these permissions to admin users/roles as needed.

## Usage

### Creating a Ribbon

1. Go to **Menu → Ribbons → Manage Ribbons**
2. Click **Add Ribbon**
3. Fill in the form:
   - **Title**: Display title (required)
   - **Description**: Optional description text
   - **Link URL**: Optional clickable link
   - **Band Color**: Background color (required, default: #000000)
   - **Start Date**: When the ribbon becomes active (required)
   - **End Date**: When the ribbon expires (required)
   - **Display Pages**: All Pages or Homepage Only
   - **Is Active**: Enable/disable the ribbon
4. Click **Save**

### Display Options

- **All Pages**: Ribbon displays on all storefront pages
- **Homepage Only**: Ribbon displays only on the CMS homepage

### Date Range Validation

The module automatically prevents overlapping ribbon schedules. If you try to create a ribbon with dates that overlap an existing active ribbon, you'll receive an error message.

### Frontend Display

Ribbons automatically appear at the top of pages (sticky position) when:
- The ribbon is active (Is Active = Yes)
- Current date is within the start/end date range
- The current page matches the display pages setting

## Technical Architecture

### Module Structure

```
Evonomix/Ribbon/
├── Api/                          # API Interfaces
│   ├── Data/
│   │   └── RibbonInterface.php  # Data interface
│   └── RibbonRepositoryInterface.php  # Repository interface
├── Block/                        # View Blocks
│   ├── Adminhtml/               # Admin blocks
│   └── Ribbon.php               # Frontend block
├── Controller/                  # Controllers
│   └── Adminhtml/Ribbon/        # Admin controllers
├── etc/                         # Configuration
│   ├── acl.xml                  # Access control
│   ├── adminhtml/               # Admin configuration
│   ├── db_schema.xml            # Database schema
│   ├── db_schema_whitelist.json # Schema whitelist
│   ├── di.xml                   # Dependency injection
│   └── module.xml               # Module declaration
├── Model/                       # Business Logic
│   ├── Config/                  # Configuration models
│   ├── ResourceModel/           # Resource models
│   ├── Ribbon.php               # Main model
│   ├── RibbonRepository.php     # Repository implementation
│   └── Validator/               # Validators
├── Ui/                          # UI Components
│   ├── Component/               # Grid column renderers
│   └── DataProvider.php         # Form data provider
└── view/                        # Views and assets
    ├── adminhtml/               # Admin views
    └── frontend/                # Frontend views
```

### Design Patterns

- **Repository Pattern**: All data access through `RibbonRepositoryInterface`
- **Service Layer**: Business logic separated from data access
- **Dependency Injection**: Full DI configuration in `etc/di.xml`
- **Interface Segregation**: Separate data and repository interfaces
- **Strict Types**: PHP 7.4+ strict type declarations throughout

### Key Components

#### Models

- **Ribbon**: Main entity model implementing `RibbonInterface`
- **RibbonRepository**: Repository implementation with CRUD operations
- **DateRangeValidator**: Validates ribbon date ranges to prevent overlaps
- **Collection**: Custom collection with filtering methods

#### Controllers

- **Index**: Displays the ribbon grid
- **Edit**: Handles ribbon creation and editing
- **Save**: Processes ribbon save with validation
- **Delete**: Handles ribbon deletion

#### UI Components

- **DataProvider**: Provides form data for create/edit
- **Column Renderers**: Custom grid column displays (Status, DisplayPages, Actions)

## API Documentation

### RibbonRepositoryInterface

The repository interface provides the following methods:

```php
// Get ribbon by ID
public function getById(int $ribbonId): RibbonInterface;

// Save ribbon
public function save(RibbonInterface $ribbon): RibbonInterface;

// Delete ribbon
public function delete(RibbonInterface $ribbon): bool;

// Delete ribbon by ID
public function deleteById(int $ribbonId): bool;
```

### RibbonInterface

The data interface provides getters and setters for all ribbon properties:

```php
// ID
public function getId();
public function setId($id): RibbonInterface;

// Content
public function getTitle(): string;
public function setTitle(string $title): RibbonInterface;
public function getDescription(): ?string;
public function setDescription(?string $description): RibbonInterface;
public function getLink(): ?string;
public function setLink(?string $link): RibbonInterface;

// Styling
public function getBandColor(): string;
public function setBandColor(string $bandColor): RibbonInterface;

// Dates
public function getStartDate(): string;
public function setStartDate(string $startDate): RibbonInterface;
public function getEndDate(): string;
public function setEndDate(string $endDate): RibbonInterface;

// Display Settings
public function getDisplayPages(): int;
public function setDisplayPages(int $displayPages): RibbonInterface;
public function getIsActive(): int;
public function setIsActive(int $isActive): RibbonInterface;
```

### Usage Example

```php
use Evonomix\Ribbon\Api\RibbonRepositoryInterface;
use Evonomix\Ribbon\Api\Data\RibbonInterface;

class CustomClass
{
    private RibbonRepositoryInterface $ribbonRepository;
    
    public function __construct(RibbonRepositoryInterface $ribbonRepository)
    {
        $this->ribbonRepository = $ribbonRepository;
    }
    
    public function getActiveRibbon(int $ribbonId): ?RibbonInterface
    {
        try {
            $ribbon = $this->ribbonRepository->getById($ribbonId);
            if ($ribbon->getIsActive() && $ribbon->isActive()) {
                return $ribbon;
            }
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            return null;
        }
        return null;
    }
}
```

## Database Schema

### Table: `evonomix_ribbon`

| Column | Type | Description |
|--------|------|-------------|
| `ribbon_id` | INT(10) UNSIGNED | Primary key, auto-increment |
| `title` | VARCHAR(255) | Ribbon title (required) |
| `description` | TEXT | Optional description |
| `link` | VARCHAR(255) | Optional clickable URL |
| `band_color` | VARCHAR(50) | Background color (default: #000000) |
| `start_date` | DATETIME | Activation date (required) |
| `end_date` | DATETIME | Expiration date (required) |
| `display_pages` | SMALLINT | 0=All Pages, 1=Homepage Only |
| `is_active` | SMALLINT | 0=Disabled, 1=Enabled |
| `created_at` | TIMESTAMP | Creation timestamp |
| `updated_at` | TIMESTAMP | Last update timestamp |

### Indexes

- **PRIMARY**: `ribbon_id`
- **IDX_EVONOMIX_RIBBON_ACTIVE**: `is_active`
- **IDX_EVONOMIX_RIBBON_DATES**: `start_date`, `end_date`

### Declarative Schema

The module uses Magento 2's declarative schema system:
- **Schema Definition**: `etc/db_schema.xml`
- **Whitelist**: `etc/db_schema_whitelist.json`

## Changelog

### Version 1.0.0
- Initial release
- Full CRUD operations
- Date range validation
- Display page options
- Admin interface
- Frontend rendering
- Repository pattern implementation
- Strict type declarations

