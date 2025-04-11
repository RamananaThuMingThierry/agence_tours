@extends('auth.app')

@section('titre', 'En atttente')

@push('styles')
  <style>
        body{
          background-color: hsl(162, 79%, 13%) !important; /* Vert Bootstrap */
        }
  </style>
@endpush
   
@section('content')
  @include('admin.modal.logout')
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-2 shadow-sm">
                <div class="card-header bg-white text-success"><i class="fas fa-sync text-muted"></i>&nbsp;En attente d'approbation</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="{{ asset(config('public_path.public_path').'images/logo.jpg') }}" class="img-fluid rounded-pill" alt="">
                    </div>
                    <div class="col-md-8 d-flex align-items-center justify-content-center">
                      <p class="text-muted">Bonjour Mr/Mm/Mlle <span class="text-primary">{{ Auth::user()->pseudo }}</span>, votre compte est en attente d'approbation par un administrateur. Vous recevrez un email une fois votre compte approuvé.</p>
                    </div>
                  </div>
                </div>
                <div class="card-footer d-flex justify-content-end bg-white">
                  <button class="btn btn-outline-danger rounded-0" id="logout-link">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                      Se déconnecter
                      </button>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection