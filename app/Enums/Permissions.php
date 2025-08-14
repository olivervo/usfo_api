<?php

namespace App\Enums;

use InvalidArgumentException;

enum Permissions: string
{
    // User Permissions
    case UsersView = 'users.view';
    case UsersCreate = 'users.create';
    case UsersUpdate = 'users.update';
    case UsersDelete = 'users.delete';

    // Role Permissions
    case RolesView = 'roles.view';
    case RolesCreate = 'roles.create';
    case RolesUpdate = 'roles.update';
    case RolesDelete = 'roles.delete';

    // Booking Permissions
    case BookingsView = 'bookings.view';
    case BookingsCreate = 'bookings.create';
    case BookingsUpdate = 'bookings.update';
    case BookingsDelete = 'bookings.delete';

    // Payment Permissions
    case PaymentsView = 'payments.view';
    case PaymentsCreate = 'payments.create';
    case PaymentsUpdate = 'payments.update';
    case PaymentsDelete = 'payments.delete';
    case PaymentsProcess = 'payments.process';
    case PaymentsRefund = 'payments.refund';

    // Lodge Permissions
    case LodgesView = 'lodges.view';
    case LodgesCreate = 'lodges.create';
    case LodgesUpdate = 'lodges.update';
    case LodgesDelete = 'lodges.delete';

    // Room Permissions
    case RoomsView = 'rooms.view';
    case RoomsCreate = 'rooms.create';
    case RoomsUpdate = 'rooms.update';
    case RoomsDelete = 'rooms.delete';

    // Campsite Permissions
    case CampsitesView = 'campsites.view';
    case CampsitesCreate = 'campsites.create';
    case CampsitesUpdate = 'campsites.update';
    case CampsitesDelete = 'campsites.delete';

    // Mooring Permissions
    case MooringsView = 'moorings.view';
    case MooringsCreate = 'moorings.create';
    case MooringsUpdate = 'moorings.update';
    case MooringsDelete = 'moorings.delete';

    /**
     * Get all permissions for a specific model
     */
    public static function forModel(string $model): array
    {
        return match (strtolower($model)) {
            'user' => [self::UsersView, self::UsersCreate, self::UsersUpdate, self::UsersDelete],
            'role' => [self::RolesView, self::RolesCreate, self::RolesUpdate, self::RolesDelete],
            'booking' => [self::BookingsView, self::BookingsCreate, self::BookingsUpdate, self::BookingsDelete],
            'payment' => [self::PaymentsView, self::PaymentsCreate, self::PaymentsUpdate, self::PaymentsDelete, self::PaymentsProcess, self::PaymentsRefund],
            'lodge' => [self::LodgesView, self::LodgesCreate, self::LodgesUpdate, self::LodgesDelete],
            'room' => [self::RoomsView, self::RoomsCreate, self::RoomsUpdate, self::RoomsDelete],
            'campsite' => [self::CampsitesView, self::CampsitesCreate, self::CampsitesUpdate, self::CampsitesDelete],
            'mooring' => [self::MooringsView, self::MooringsCreate, self::MooringsUpdate, self::MooringsDelete],
            default => throw new InvalidArgumentException("Unknown model: {$model}"),
        };
    }

    /**
     * Get all CRUD permissions for all models
     */
    public static function all(): array
    {
        return [
            'user' => self::forModel('user'),
            'role' => self::forModel('role'),
            'booking' => self::forModel('booking'),
            'payment' => self::forModel('payment'),
            'lodge' => self::forModel('lodge'),
            'room' => self::forModel('room'),
            'campsite' => self::forModel('campsite'),
            'mooring' => self::forModel('mooring'),
        ];
    }

    /**
     * Get all view permissions
     */
    public static function allViewPermissions(): array
    {
        return [
            self::UsersView,
            self::RolesView,
            self::BookingsView,
            self::PaymentsView,
            self::LodgesView,
            self::RoomsView,
            self::CampsitesView,
            self::MooringsView,
        ];
    }

    /**
     * Get all create permissions
     */
    public static function allCreatePermissions(): array
    {
        return [
            self::UsersCreate,
            self::RolesCreate,
            self::BookingsCreate,
            self::PaymentsCreate,
            self::LodgesCreate,
            self::RoomsCreate,
            self::CampsitesCreate,
            self::MooringsCreate,
        ];
    }

    /**
     * Get all update permissions
     */
    public static function allUpdatePermissions(): array
    {
        return [
            self::UsersUpdate,
            self::RolesUpdate,
            self::BookingsUpdate,
            self::PaymentsUpdate,
            self::LodgesUpdate,
            self::RoomsUpdate,
            self::CampsitesUpdate,
            self::MooringsUpdate,
        ];
    }

    /**
     * Get all delete permissions
     */
    public static function allDeletePermissions(): array
    {
        return [
            self::UsersDelete,
            self::RolesDelete,
            self::BookingsDelete,
            self::PaymentsDelete,
            self::LodgesDelete,
            self::RoomsDelete,
            self::CampsitesDelete,
            self::MooringsDelete,
        ];
    }
}
