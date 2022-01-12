@extends('admin.layouts.page')

@section('title', __('Edit Country'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.countries.index') }}">{{ __('Countries') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit Country') }}</li>
@endsection

@section('content')
    <div class="card profile-card mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row m-1">
                    @include('country::form', compact('form'))
                </div>
            </div>
        </div>
    </div>
@endsection
