@extends('backend.layouts.app')
@section('title', 'View Contact Submission')

@section('content')
    <x-breadcrumbs title="Contact Submission" :breadcrumbs="[['text' => 'Contacts', 'url' => route('admin.contacts.index')]]" />

    <section>
        <div class="container-fluid">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Contact Details</h4>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><a href="tel:+{{ $contact->phone }}">{{ $contact->phone }}</a></td>
                        </tr>
                        <tr>
                            <th>Country</th>
                            <td>{{ $contact->country }}</td>
                        </tr>

                        <tr>
                            <th>Message</th>
                            <td>{{ $contact->message }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($contact->is_read)
                                    <span class="badge bg-success">Read</span>
                                @else
                                    <span class="badge bg-warning">Unread</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection