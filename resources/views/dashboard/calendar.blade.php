<div class="card">
    <div class="card-header">{{ __('Calendario') }}</div>

    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>

@push('postjs')
<script src='{{ asset('vendor/fullcalendar/main.js') }}'></script>
<script src='{{ asset('vendor/fullcalendar/locales/es.js') }}'></script>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
      events = [
        @foreach ($events as $event) { // this object will be "parsed" into an Event Object
          title: '{{$event->patient->name}}', // a property!
          start: '{{$event->datetime->format("Y-m-d")}}', // a property!
          end: '{{$event->datetime->addDay()->format("Y-m-d")}}' // a property! ** see important note below about 'end' **
        },
        @endforeach
      ];
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
				contentHeight: 'auto',
        events
      });
      calendar.render();
    });
</script>
@endpush

@push('css')
<link href='{{ asset('vendor/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush