<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class UpdateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $userId = auth()->id(); // current logged-in user

        return [
            'name'        => 'nullable|string|max:50',
            'phone'       => 'nullable|string|max:30',
            'email'       => 'nullable|email:rfc,dns|unique:users,email,' . $userId,
            'avatar_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:20480', // 20MB
            'location'    => 'nullable|string|max:255',
        ];
    }
}
