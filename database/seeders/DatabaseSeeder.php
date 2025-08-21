<?php

namespace Database\Seeders;

use App\Actions\RefundPayment;
use App\Enums\Permissions;
use App\Enums\StaffRoles;
use App\Models\Boatweek;
use App\Models\Booking;
use App\Models\Camp;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Campsite;
use App\Models\Lodge;
use App\Models\Mooring;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\Room;
use App\Models\Staff;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        activity()->disableLogging();

        DB::transaction(function () {
            // Create user pool for payments only 
            $paymentUsers = User::factory()->count(20)->create();
            
            // Create staff pool (each needs unique user, so don't recycle)
            $staff = Staff::factory()->count(50)->create();
            
            // Create student and payment pools for registrations
            $students = Student::factory()->count(100)->create();
            $payments = collect();
            foreach ($paymentUsers as $user) {
                $payments = $payments->merge(Payment::factory()->forUser($user)->count(5)->create());
            }

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

            // Create camps without staff attachments first
            $camps = Camp::factory()->count(10)->create();
            
            // Attach staff to camps in bulk
            foreach ($camps as $camp) {
                $camp->staff()->attach($staff->random(1)->first()->id, [
                    'role' => StaffRoles::kc,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 5500,
                    'status_updated_at' => now(),
                ]);
                
                $camp->staff()->attach($staff->random(1)->first()->id, [
                    'role' => StaffRoles::bkc,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 4500,
                    'status_updated_at' => now(),
                ]);
                
                $camp->staff()->attach($staff->random(4)->pluck('id')->toArray(), [
                    'role' => StaffRoles::ins,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 3500,
                    'status_updated_at' => now(),
                ]);
                
                $camp->staff()->attach($staff->random(2)->pluck('id')->toArray(), [
                    'role' => StaffRoles::ass,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 1500,
                    'status_updated_at' => now(),
                ]);
                
                $camp->staff()->attach($staff->random(2)->pluck('id')->toArray(), [
                    'role' => StaffRoles::ass,
                    'status' => 'pending',
                    'percent' => 1,
                    'weekly_salary' => 1500,
                    'status_updated_at' => null,
                    'reminder_sent' => now(),
                ]);
            }

            // Create registrations using pre-created pools
            $registrations = collect();
            for ($i = 0; $i < 200; $i++) {
                $student = $students->random();
                $payment = $payments->random();
                $camp = $camps->random();
                
                $registration = Registration::create([
                    'camp_id' => $camp->id,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'address_1' => $student->address_1,
                    'address_2' => $student->address_2,
                    'zipcode' => $student->zipcode,
                    'city' => $student->city,
                    'country' => $student->country,
                    'date_of_birth' => $student->date_of_birth,
                    'allergies' => $student->allergies,
                    'dietary_restrictions' => $student->dietary_restrictions,
                    'notes' => fake()->optional(0.1)->sentence(),
                    'student_id' => $student->id,
                    'user_id' => $payment->user_id,
                    'deposit_id' => $payment->id,
                    'sex' => $student->sex,
                    'status' => 'confirmed',
                ]);
                $registrations->push($registration);
            }

            // Create cancelled registrations
            $cancelled = collect();
            for ($i = 0; $i < 20; $i++) {
                $student = $students->random();
                $payment = $payments->random();
                $camp = $camps->random();
                
                $registration = Registration::create([
                    'camp_id' => $camp->id,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'address_1' => $student->address_1,
                    'address_2' => $student->address_2,
                    'zipcode' => $student->zipcode,
                    'city' => $student->city,
                    'country' => $student->country,
                    'date_of_birth' => $student->date_of_birth,
                    'allergies' => $student->allergies,
                    'dietary_restrictions' => $student->dietary_restrictions,
                    'notes' => fake()->optional(0.1)->sentence(),
                    'student_id' => $student->id,
                    'user_id' => $payment->user_id,
                    'deposit_id' => $payment->id,
                    'sex' => $student->sex,
                    'status' => 'cancelled',
                    'cancelled_at' => now()->subDays(rand(1, 30)),
                ]);
                $cancelled->push($registration);
            }

            // Create refunds for cancelled registrations (simplified for seeding performance)
            // Instead of running full RefundPayment actions, just update payment status
            $cancelled->each(function (Registration $registration) {
                $registration->deposit->update(['status' => 'refunded']);
            });

            // Create boatweeks without staff attachments first
            $boatweeks = Boatweek::factory()->count(10)->create();
            
            // Attach staff to boatweeks in bulk
            foreach ($boatweeks as $boatweek) {
                $boatweek->staff()->attach($staff->random(1)->first()->id, [
                    'role' => StaffRoles::sc,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 6500,
                    'status_updated_at' => now(),
                ]);
                
                $boatweek->staff()->attach($staff->random(1)->first()->id, [
                    'role' => StaffRoles::bc,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 5500,
                    'status_updated_at' => now(),
                ]);
                
                $boatweek->staff()->attach($staff->random(4)->pluck('id')->toArray(), [
                    'role' => StaffRoles::bat_ins,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 3500,
                    'status_updated_at' => now(),
                ]);
                
                $boatweek->staff()->attach($staff->random(2)->pluck('id')->toArray(), [
                    'role' => StaffRoles::bat_ass,
                    'status' => 'confirmed',
                    'percent' => 1,
                    'weekly_salary' => 1500,
                    'status_updated_at' => now(),
                ]);
                
                $boatweek->staff()->attach($staff->random(2)->pluck('id')->toArray(), [
                    'role' => StaffRoles::bat_ass,
                    'status' => 'pending',
                    'percent' => 1,
                    'weekly_salary' => 1500,
                    'status_updated_at' => null,
                    'reminder_sent' => now(),
                ]);
            }

            // Reset cached roles and permissions
            app()[PermissionRegistrar::class]->forgetCachedPermissions();

            // Create roles
            $adminRole = Role::create(['name' => 'admin']);

            // Create permissions from Permissions.enum
            foreach(Permissions::cases() as $permission) {
                Permission::create(['name'=> $permission->name]);
                $adminRole->givePermissionTo($permission->name);
            }

            // Create test user
            User::factory()->create([
                'first_name' => 'Test',
                'email' => 'test@test.com',
                'password' => bcrypt('password'),
            ])->assignRole($adminRole);
        });
    }
}
