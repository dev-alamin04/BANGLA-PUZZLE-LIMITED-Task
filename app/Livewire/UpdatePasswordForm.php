<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm as BaseUpdatePasswordForm;

class UpdatePasswordForm extends BaseUpdatePasswordForm
{
    public function render()
    {
        return view('backend.layouts.profile.update-password-form');
    }
}
