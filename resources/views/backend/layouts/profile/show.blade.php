<x-profile-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <div class="content-wrapper">        
        <x-breadcrumbs title="Profile Info" subtitle="Update your account's profile information and email address."
            :breadcrumbs="[['text' => 'Profile', 'url' => route('admin.profile.show')]]" />
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="row g-4  mb-4">
                <div class="col-12 col-md-6">
                    @livewire('update-profile-picture-form')
                    <x-section-border />
                </div>
                <div class="col-12 col-md-6 ">
                    @livewire('update-profile-information-form')
                    <x-section-border />
                </div>
            </div>


            <div class="row g-4">
                <div class="col-12 col-md-6">
                    @livewire('update-password-form')
                    <x-section-border />
                </div>
                <div class="col-12 col-md-6 ">
                    @livewire('logout-other-browser-sessions-form')
                    <x-section-border />
                </div>
            </div>



            {{-- @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::UpdateProfilePictureForm())) --}}

            {{-- @endif --}}

            {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="mt-5 sm:mt-0">
                @livewire('profile.two-factor-authentication-form')
            </div>

            <x-section-border />
            @endif --}}



            {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-section-border />

            <div class="mt-5 sm:mt-0">
                @livewire('profile.delete-user-form')
            </div>
            @endif --}}
        </div>
    </div>
</x-profile-layout>
