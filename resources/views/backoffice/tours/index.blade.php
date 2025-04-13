@extends('backoffice.admin')

@section('title', __('sidebar.tour'))

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jq-3.7.0/dt-2.0.8/b-3.0.2/b-html5-3.0.2/b-print-3.0.2/r-3.0.2/datatables.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
@endpush

@section('content')
    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
            <a class="btn btn-sm btn-success shadow-sm d-flex align-items-center" href="{{ route('admin.tours.create') }}">
                <i class="fas fa-plus p-1 text-white-50"></i>
                <span class="d-none d-sm-inline">&nbsp;{{ __('tour.add') }}</span>
            </a>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
        <div class="card rounded-0 p-3 shadow-sm">
                <div class="table-responsive">
                    <table id="datatables" class="table table-striped table-bordered display w-100">
                        <thead class="table-dark">
                        <th class="text-center" scope="col">{{ __('tour.image') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.title') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.description') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.price') }}</th>
                        <th class="text-center" scope="col">{{ __('tour.status') }}</th>
                        <th class="text-center" scope="col" class="text-center">{{ __('tour.actions') }}</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection