# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Backend (Laravel/PHP)
- `composer dev` - Start full development environment (API server, queue worker, logs, frontend build)
- `composer test` - Run PHP tests via PHPUnit/Pest
- `php artisan serve` - Start Laravel development server only
- `php artisan test` - Run tests directly via artisan
- `php artisan migrate` - Run database migrations
- `php artisan queue:listen --tries=1` - Start queue worker
- `php artisan pail --timeout=0` - View real-time logs

### Frontend (Vite)
- `npm run dev` - Start Vite development server for asset compilation
- `npm run build` - Build production assets

### Code Quality
- Uses Tighten Duster for linting and code style formatting (`vendor/bin/duster fix`)
- Uses Laravel Pint for PHP code formatting
- Tests use Pest framework (configured in tests/Pest.php)

## Architecture Overview

This is a Laravel-based API for managing all bookable and assignable entities of a national park in Sweden's archipelago. A primary function is registering for camps. The application handles user registration, payments via Stripe, and staff management.

### Core Business Models
- **Camp**: Central entity representing sailing camps with availability management
- **Registration**: Student camp registrations with complex status workflows
- **User**: Authentication and billing entity (uses Laravel Cashier for Stripe)
- **Student**: Participant information linked to registrations with membership validation
- **Staff**: Camp instructors with role-based assignments
- **Payment**: Stripe payment integration with morphable billing relationships
- **Membership**: Annual membership system with polymorphic relationships to Students
- **Booking**: Handles lodge, campsite, and mooring reservations
- **Lodge/Campsite/Mooring**: Different accommodation types with room management

### Key Architectural Patterns
- **Actions Pattern**: Uses Laravel Actions (lorisleiva/laravel-actions) for business logic encapsulation
- **JSON:API**: Configured for JSON:API standardization
- **Activity Logging**: Uses Spatie\ActivityLog across major models for audit trails
- **Permission System**: Spatie\Permission for role-based access control
- **Stripe Integration**: Laravel Cashier for subscription and payment handling with custom checkout sessions
- **Queue System**: Background job processing for payments and notifications
- **Settings Management**: Spatie\Settings for configurable application settings (PublicSettings, AdminSettings, StaffSettings)
- **SPAR Integration**: Swedish Population Registry integration via SOAP client with DTO pattern
- **Data Transfer Objects**: Spatie\LaravelData for structured API responses and SPAR integration

### Database Structure
- Uses standard Laravel migrations with proper foreign key relationships
- Pivot tables for many-to-many relationships (camp_staff, boatweek_staff, camp_room)
- Polymorphic relationships for payments (billable_type/billable_id)
- Soft deletes and activity logging for audit requirements

### Business Logic Highlights
- **Camp Availability**: Complex gender-based availability calculation in Camp model
- **Registration Workflow**: Multi-status registration system with automatic pruning of pending registrations
- **Payment Processing**: Integrated Stripe webhooks and subscription management with custom checkout sessions
- **Staff Assignments**: Role-based staff assignments to camps with percentage-based compensation
- **Phone Number Handling**: Production-environment specific E164 phone number casting
- **Membership Validation**: Annual membership system with year-based validation logic
- **SPAR Lookups**: Swedish Population Registry integration for automatic address/name population
- **Data Masking**: Sensitive information masking via MaskAttributes trait

### Key Actions (Business Logic)
- **CreateStripeCheckoutSession**: Handles complex Stripe checkout for registration and membership fees
- **SearchSpar**: SPAR (Swedish Population Registry) lookups with caching
- **RefundPayment**: Payment refund processing
- **SyncOrCreateStripeCustomer**: Customer synchronization with Stripe

### Services & Utilities
- **DateService**: Centralized year/date logic for camp seasons
- **SPAR SOAP Client**: Integration with Swedish Population Registry
- **MaskAttributes Trait**: Data privacy protection for sensitive information
- **Settings Classes**: Configurable application settings (fees, messages, etc.)
- Custom Enums for status management (RegistrationStatus, PaymentStatus, etc.)

### Testing
- Uses Pest testing framework
- SQLite in-memory database for tests
- Factory patterns for all major models
- Separate Feature and Unit test suites

## Git workflow
- Do not use pull requests for code changes
- Use issues for bug reports and feature requests
- Use branches for development
- Use tags for releases
- Use GitHub Actions for CI/CD
- I'm currently a solo developer so keep Github workflow simple
