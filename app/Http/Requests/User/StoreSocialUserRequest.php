<?php
namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class StoreSocialUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // The token we’ll verify with Google/Apple
            'provider'    => 'required|in:google,apple',
            'provider_id' => 'required|string',

            'name'        => 'nullable|string|max:50',
            'email'       => 'required|email:rfc,dns',
            'avatar_path' => 'nullable|url',
        ];
    }
}
