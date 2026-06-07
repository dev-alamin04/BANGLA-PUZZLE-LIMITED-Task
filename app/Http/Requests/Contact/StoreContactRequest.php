<?php

namespace App\Http\Requests\Contact;

use App\Http\Requests\BaseRequest;

class StoreContactRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:30',
            'country' => 'required|string|max:30',
            'message' => 'required|string',
        ];
    }
}
