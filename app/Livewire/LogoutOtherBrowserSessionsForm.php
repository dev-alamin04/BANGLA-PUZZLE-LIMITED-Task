<?php

namespace App\Livewire;

use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm as BaseLogoutOtherBrowserSessionsForm;

class LogoutOtherBrowserSessionsForm extends BaseLogoutOtherBrowserSessionsForm
{
    public function render()
    {
        return view('backend.layouts.profile.logout-other-browser-sessions-form');
    }
}
