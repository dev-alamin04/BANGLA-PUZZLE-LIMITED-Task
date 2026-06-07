@extends('frontend.app')
@section('title', "$dynamicPage->page_title")
@push('style')
    <style>
        p {
            color: #ddd;
        }

        * {
            color: white
        }
    </style>
@endpush
@section('content')
    <section style="background: #ffffff !important; min-height: 100vh;">
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 py-5">
                    <p class="mt-4">
                        {!! $dynamicPage->page_content !!}
                    </p>

                </div>
            </div>
        </div>
    </section>
@endsection