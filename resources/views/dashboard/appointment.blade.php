<?php
use Carbon\Carbon;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha = Carbon::now();
$mes = $meses[($fecha->format('n')) - 1];
?>
<div class="card">
    <div class="card-header">{{ __('Citas de hoy') }}</div>

    <div class="card-body">
        <h5 class="card-title mt-2 mb-4">{{ $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y') }}</h5>
        @forelse($appointments as $appointment)
        <h6 class="card-subtitle text-muted">{{ $appointment->datetime->format('g:i A') }}</h6>
        <p class="card-text mb-5">{{ $appointment->patient->name.' '.$appointment->patient->lastname.' '.$appointment->patient->postlastname }}</p>
        @empty
        <p class="card-text mb-5">No hay citas para hoy</p>
        @endforelse
    </div>
</div>