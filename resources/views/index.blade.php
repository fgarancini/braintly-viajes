@extends('layouts.master')

@section('content')
    @include('components.header')

    <div class="container mt-3">
        <h2>Nuestros destinos más populares</h2>
        <div class="row">
            <div class="col-3">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/mendoza.jpg') }}" alt="Card image cap">
                    <div class="card-body">
                        <h4>Mendoza</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/bariloche.jpg') }}" alt="Card image cap">
                    <div class="card-body">
                        <h4>Bariloche</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/cordoba.jpg') }}" alt="Card image cap">
                    <div class="card-body">
                        <h4>Córdoba</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('images/iguazu.jpg') }}" alt="Card image cap">
                    <div class="card-body">
                        <h4>Misiones</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
