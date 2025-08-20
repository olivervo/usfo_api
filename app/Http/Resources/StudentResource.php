<?php

namespace App\Http\Resources;

use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Student */
class StudentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            // Public data
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'fullName' => $this->full_name,
            'dateOfBirth' => $this->date_of_birth?->format('Y-m-d'),
            'sex' => $this->sex,
            'address1' => $this->address_1,
            'address2' => $this->address_2,
            'zipcode' => $this->zipcode,
            'city' => $this->city,
            'country' => $this->country,

            // Restricted to authenticated users with permission to view
            $this->mergeWhen($user?->can('view', $this), [
                'idNumber' => $this->id_number,
                'createdAt' => $this->created_at?->format('Y-m-d H:i:s'),
                'updatedAt' => $this->updated_at?->format('Y-m-d H:i:s'),
            ]),

            // Relationships - only include registrations if user has permission to view them
            $this->mergeWhen($user?->can('viewAny', Registration::class), [
                'registrations' => RegistrationResource::collection($this->whenLoaded('registrations')),
            ]),
        ];
    }
}
