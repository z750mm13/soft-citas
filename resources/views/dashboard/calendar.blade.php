<div class="card">
    <div class="card-header">{{ __('Calendario') }}</div>

    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>

@push('postjs')
<script src='{{ asset('vendor/fullcalendar/main.js') }}'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth'
      });
      calendar.render();
    });
</script>
@endpush

@push('css')
<link href='{{ asset('vendor/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush