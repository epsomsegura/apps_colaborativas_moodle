@extends('layouts.app')

@section('title','Dashboard')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    ¡Que tal {{Auth::user()->name}}! Que bueno que esta de vuelta
                </div>
            </div>
        </div>
    </div>
</div>
@endsection