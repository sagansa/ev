<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ChargerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'charger_location_id' => [
                'required',
                'exists:charger_locations,id',
            ],
            'charger_type_id' => ['required', 'exists:charger_types,id'],
            'electric_current_id' => [
                'required',
                'exists:electric_currents,id',
            ],
            'power' => ['required', 'max:10', 'string'],
            'unit' => ['required', 'max:255'],
            'charge_cost' => ['required', 'numeric'],
            'PPJ' => ['required', 'numeric'],
            'admin_cost' => ['required', 'numeric'],
            'PPN' => ['required', 'in:yes,no'],
            'status' => ['required', 'in:verified,not verified,closed'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
