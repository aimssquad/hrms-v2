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

        <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

        <script>
            window.AUTH_EMID = "{{ auth()->check() ? auth()->user()->emid : '' }}";
            window.PROJECT_ID = "{{ isset($project) ? $project->id : '' }}";

            if (window.AUTH_EMID && window.PROJECT_ID) {

                Pusher.logToConsole = false;

                const pusher = new Pusher(
                    "{{ config('broadcasting.connections.pusher.key') }}",
                    {
                        cluster: "{{ config('broadcasting.connections.pusher.options.cluster') }}",
                        encrypted: true
                    }
                );

                const channelName = `project-channel.${window.AUTH_EMID}.${window.PROJECT_ID}`;
                const channel = pusher.subscribe(channelName);

                channel.bind('project-post-live', function (res) {
                    console.log('Live notification:', res);
                    handleLiveNotification(res.data.post);
                });
            }
        </script>


		
    </body>
</html>


