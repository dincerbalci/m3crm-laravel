@extends('layouts.main')

@section('content')
    <link href="{{ asset('theme/dist/css/app.agent.css') }}" rel="stylesheet" type="text/css">
    <div class="chat-panel"> </div>
    @push('scripts')
        <script src="https://helpdesk.m3tech.com.pk:3001/assets/core/js/app.agent.js" type="text/javascript"></script>
        <script>
            (function() {
                var app = new App("https://helpdesk.m3tech.com.pk:3001");
                app.start();
            })();
            document.addEventListener('contextmenu', event => event.preventDefault());
        </script>
    @endpush
@endsection
