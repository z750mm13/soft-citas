@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            @include('dashboard.calendar')
        </div>
        <div class="col-4">
            @include('dashboard.appointment')
        </div>
    </div>
</div>
@endsection
