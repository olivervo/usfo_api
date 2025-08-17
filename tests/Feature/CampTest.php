<?php

use App\Models\Camp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns published camps in index', function () {
    $publishedCamps = Camp::factory()->published()->count(3)->create();
    $unpublishedCamp = Camp::factory()->unpublished()->create();

    $response = $this->getJson('/api/camps');

    $response->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'campName',
                    'year',
                    'startDate',
                    'endDate',
                    'ageGroup',
                    'campCategory',
                    'campFee',
                    'totalSpaces',
                    'isAvailable',
                    'freeMales',
                    'freeFemales',
                    'availability',
                    'numberMales',
                    'numberFemales',
                    'malesCount',
                    'femalesCount',
                    'activeRegistrationsCount',
                ],
            ],
        ]);

    $response->assertJsonMissing(['registrationCode', 'publishAt', 'createdAt', 'updatedAt']);;

    foreach ($publishedCamps as $camp) {
        $response->assertJsonFragment([
            'id' => $camp->id,
            'campName' => $camp->camp_name,
        ]);
    }

    $response->assertJsonMissing(['id' => $unpublishedCamp->id]);
});

it('filters camps by year', function () {
    $camp2024 = Camp::factory()->published()->create(['year' => 2024]);
    $camp2025 = Camp::factory()->published()->create(['year' => 2025]);

    $response = $this->getJson('/api/camps?filter[year]=2024');

    $response->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $camp2024->id])
        ->assertJsonMissing(['id' => $camp2025->id]);
});

it('filters camps by age group', function () {
    $youngCamp = Camp::factory()->published()->create(['age_group' => '7-9']);
    $oldCamp = Camp::factory()->published()->create(['age_group' => '16-18']);

    $response = $this->getJson('/api/camps?filter[age_group]=7-9');

    $response->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $youngCamp->id])
        ->assertJsonMissing(['id' => $oldCamp->id]);
});

it('filters camps by camp category', function () {
    $weekCamp = Camp::factory()->published()->create(['camp_category' => 'Enveckasläger']);
    $confirmationCamp = Camp::factory()->published()->create(['camp_category' => 'Konfirmationsläger']);

    $response = $this->getJson('/api/camps?filter[camp_category]=Enveckasläger');

    $response->assertSuccessful()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['id' => $weekCamp->id])
        ->assertJsonMissing(['id' => $confirmationCamp->id]);
});

it('shows a specific camp', function () {
    $camp = Camp::factory()->published()->create();

    $response = $this->getJson("/api/camps/{$camp->id}");

    $response->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'campName',
                'year',
                'startDate',
                'endDate',
                'ageGroup',
                'campCategory',
                'campFee',
                'totalSpaces',
                'isAvailable',
                'freeMales',
                'freeFemales',
                'availability',
                'numberMales',
                'numberFemales',
                'malesCount',
                'femalesCount',
                'activeRegistrationsCount',
            ],
        ])
        ->assertJsonFragment([
            'id' => $camp->id,
            'campName' => $camp->camp_name,
            'year' => $camp->year,
            'ageGroup' => $camp->age_group,
            'campCategory' => $camp->camp_category,
        ]);

    expect($response->json('data'))->not->toHaveKey('registrationCode');
});

it('shows admin-specific data when authenticated as admin', function () {
    // Create admin role
    \Spatie\Permission\Models\Role::create(['name' => 'admin']);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    $camp = Camp::factory()->published()->withRegistrationCode()->create();

    $response = $this->actingAs($admin, 'sanctum')
        ->getJson("/api/camps/{$camp->id}");

    $response->assertSuccessful()
        ->assertJsonFragment([
            'registrationCode' => $camp->registration_code,
        ])
        ->assertJsonStructure([
            'data' => [
                'registrationCode',
                'publishAt',
                'createdAt',
                'updatedAt',
            ],
        ]);
});

it('returns 404 for non-existent camp', function () {
    $response = $this->getJson('/api/camps/999');

    $response->assertNotFound();
});
