@extends('admin.layouts.page')

@section('title', __('Add Country'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.countries.index') }}">{{ __('Countries') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Add Country') }}</li>
@endsection

@section('content')
    <div class="card profile-card mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row m-1">
                    {{ Form::open([
                        'method' => 'POST',
                        'url' => route('admin.countries.store'),
                        'enctype' => "multipart/form-data",
                        "class" => 'row'
                        ])
                    }}
                    @include('country::form', compact('form'))
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
