@extends('layouts.app')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-8 col-sm-12 mb-5">
            @include('dashboard.calendar')
        </div>
        <div class="col-md-4 col-sm-12 mb-5">
            @include('dashboard.appointment')
        </div>
    </div>
</div>
@endsection
