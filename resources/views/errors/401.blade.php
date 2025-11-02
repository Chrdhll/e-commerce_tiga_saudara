@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')

    <section class="bg-gradient-primary-dark text-white py-5">
        <div class="container">
            <h1 class="display-4">401</h1>
            <p class="fs-5 text-white-50">
                Anda tidak memiliki izin untuk mengakses halaman ini
            </p>
        </div>
    </section>

@endsection