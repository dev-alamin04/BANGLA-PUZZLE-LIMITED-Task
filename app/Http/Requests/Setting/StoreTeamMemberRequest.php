<?php
namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class StoreTeamMemberRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $allPermissions = Permission::pluck('name')->toArray();

        return [
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8'],

            'team_role'     => ['required', 'string', 'max:50'],

            'permissions'   => ['nullable', 'array'],

            // Validate each permission against the DB
            'permissions.*' => ['string', Rule::in($allPermissions)],

            'has_all_jobs'  => ['required', 'boolean'],
            'job_ids'       => ['required_if:has_all_jobs,false', 'array'],
            'job_ids.*'     => ['exists:jobs,id'],
        ];
    }
}
