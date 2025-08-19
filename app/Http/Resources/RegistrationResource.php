<?php

namespace App\Http\Resources;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Registration */
class RegistrationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'studentId' => $this->student_id,
            'campId' => $this->camp_id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'allergies' => $this->allergies,
            'notes' => $this->notes,
            'dietaryRestrictions' => $this->dietary_restrictions,
            'sex' => $this->sex,
            'status' => $this->status,
            'paidComplete' => $this->paid_complete,
            'cancelledAt' => $this->cancelled_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            $this->mergeWhen($user->can('viewDetails', $this), [
                'address1' => $this->address_1,
                'address2' => $this->address_2,
                'zipcode' => $this->zipcode,
                'city' => $this->city,
                'country' => $this->country,
                'dateOfBirth' => $this->date_of_birth?->format('Y-m-d'),
            ]),

            $this->mergeWhen($user->can('viewFinances', $this), [
                'invoiceSentAt' => $this->invoice_sent_at,
                'depositId' => $this->deposit_id,
            ]),
        ];
    }
}
