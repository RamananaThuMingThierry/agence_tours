@extends('admin.admin')

@section('content')
    <img class="img-fluid p-4 img-width" src="{{ asset(config('public_path.public_path').'img/undraw_server_down_s-4-lk.svg') }}">
    <p class="lead">Erreur du Serveur</p>
@endsection
