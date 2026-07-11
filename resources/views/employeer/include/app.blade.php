<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <head>
            <title>@yield('title', 'Dashboard - HRMS admin template')</title>
            @include('employeer.layout.title-meta')
            @include('employeer.layout.head-css')
            @yield('css')
        </head>
		
		 
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			@include('employeer.include.topbar')
			
			@include('employeer.include.sidebar')

            <!-- Page Wrapper -->
            <div class="page-wrapper">
                @yield('content')
            </div>
            <!-- /Page Wrapper -->
        </div>
		<!-- /Main Wrapper -->

		@include('employeer.layout.customizer')
		@include('employeer.layout.script')
        @yield('script')
        
        <script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
        
        <script>
            window.AUTH_EMID = "{{ auth()->check() ? auth()->user()->emid : '' }}";
        
            if (window.AUTH_EMID) {
        
                Pusher.logToConsole = true;
        
                const pusher = new Pusher(
                    "{{ config('broadcasting.connections.pusher.key') }}",
                    {
                        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                        forceTLS: true
                    }
                );
        
                pusher.connection.bind('connected', () => {
                    console.log('✅ Pusher connected');
                });
        
                const channel = pusher.subscribe(`notification.${window.AUTH_EMID}`);
        
                channel.bind('new-notification', function (data) {
                    console.log('🔔 Notification received:', data);
                });
            }
        </script>


		
    </body>
</html>


