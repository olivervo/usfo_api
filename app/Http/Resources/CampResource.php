<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            // Public data - always visible
            'id' => $this->id,
            'name' => $this->name,
            'campName' => $this->camp_name,
            'year' => $this->year,
            'startDate' => $this->start_date->format('Y-m-d'),
            'endDate' => $this->end_date->format('Y-m-d'),
            'ageGroup' => $this->age_group,
            'campCategory' => $this->camp_category,
            'campFee' => $this->camp_fee,
            'totalSpaces' => $this->total_spaces,
            'isAvailable' => $this->is_available,
            'freeMales' => $this->getFreeMales(),
            'freeFemales' => $this->getFreeFemales(),
            'availability' => $this->getAvailability(),
            'numberMales' => $this->number_males,
            'numberFemales' => $this->number_females,
            'malesCount' => $this->males_count ?? 0,
            'femalesCount' => $this->females_count ?? 0,
            'activeRegistrationsCount' => $this->active_registrations_count ?? 0,

            // Admin-specific data
            $this->mergeWhen($user?->hasRole('admin'), [
                'registrationCode' => $this->registration_code,
                'publishAt' => $this->publish_at?->format('Y-m-d H:i:s'),
                'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
                'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
            ]),
        ];
    }
}
