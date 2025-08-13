<?php

namespace Database\Seeders;

use App\Actions\RefundPayment;
use App\Enums\StaffRoles;
use App\Models\Boatweek;
use App\Models\Booking;
use App\Models\Camp;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campsite;
use App\Models\Lodge;
use App\Models\Mooring;
use App\Models\Registration;
use App\Models\Room;
use App\Models\Staff;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        activity()->disableLogging();

        // Create 10 lodgings
        Lodge::factory()
            ->has(Room::factory()
                ->has(
                    Booking::factory()
                )
                ->count(2))
            ->count(10)
            ->create();

        // Create 10 campsites with 10 bookings each
        Campsite::factory()
            ->has(
                Booking::factory()
            )
            ->count(10)
            ->create();

        // Create 10 moorings with 10 bookings each
        Mooring::factory()
            ->has(
                Booking::factory()
            )
            ->count(10)
            ->create();

        $camps = Camp::factory()
            ->hasAttached(Staff::factory()->count(1), [
                'role' => StaffRoles::kc,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 5500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(1), [
                'role' => StaffRoles::bkc,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 4500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(4), [
                'role' => StaffRoles::ins,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 3500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(2), [
                'role' => StaffRoles::ass,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 1500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(2), [
                'role' => StaffRoles::ass,
                'status' => 'pending',
                'percent' => 1,
                'weekly_salary' => 1500,
                'status_updated_at' => null,
                'reminder_sent' => now(),
            ])
            ->count(20)
            ->create();

        // Create registrations
        Registration::factory()
            ->recycle($camps)
            ->count(400)
            ->create();

        // Create cancelled registrations
        $cancelled = Registration::factory()
            ->recycle($camps)
            ->cancelled()
            ->count(20)
            ->create();

        // Create refunds for cancelled registrations
        $cancelled->each(function (Registration $registration) {
            RefundPayment::run($registration->deposit, 500);
        });

        // Create 20 boatweeks
        Boatweek::factory()
            ->hasAttached(Staff::factory()->count(1), [
                'role' => StaffRoles::sc,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 6500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(1), [
                'role' => StaffRoles::bc,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 5500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(4), [
                'role' => StaffRoles::bat_ins,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 3500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(2), [
                'role' => StaffRoles::bat_ass,
                'status' => 'confirmed',
                'percent' => 1,
                'weekly_salary' => 1500,
                'status_updated_at' => now(),
            ])
            ->hasAttached(Staff::factory()->count(2), [
                'role' => StaffRoles::bat_ass,
                'status' => 'pending',
                'percent' => 1,
                'weekly_salary' => 1500,
                'status_updated_at' => null,
                'reminder_sent' => now(),
            ])
            ->count(20)
            ->create();
    }
}
