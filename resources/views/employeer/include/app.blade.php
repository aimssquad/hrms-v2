<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
    <head>
        <head>
            <title>@yield('title', 'Dashboard - HRMS admin template')</title>
            @include('employeer.layout.title-meta')
            @include('employeer.layout.head-css')
            @yield('css')
            <style>
                .gtranslate_wrapper select {
                    background: #fff;
                    border: 1px solid #ced4da;
                    border-radius: 4px;
                    padding: 4px 8px;
                    font-size: 13px;
                    color: #495057;
                    outline: none;
                    cursor: pointer;
                }

                /* ডিফল্ট অবস্থায় ইংরেজি সাব-টেক্সট লুকানো থাকবে */
                .dual-lang-sub {
                    display: none;
                    font-size: 13px;
                    color: #888888;
                    font-weight: normal;
                    display: block; /* নিচের লাইনে নেওয়ার জন্য */
                }

                /* যখন ভাষা ইংরেজি (ডিফল্ট), তখন এটি পুরোপুরি হাইড থাকবে */
                body .dual-lang-sub {
                    display: none !important;
                }

                /* যখন ভাষা আরবি হবে (Google Translate যখন html এ lang="ar" বা skiptranslate বসায়) */
                html[lang="ar"] .dual-lang-sub,
                html.translated-rtl .dual-lang-sub,
                body.translated-ar .dual-lang-sub {
                    display: block !important;
                    margin-top: 2px;
                    direction: ltr; /* ইংরেজি যেন বাম দিক থেকে শুরু হয় */
                    text-align: right; /* আরবির সাথে সামঞ্জস্য রাখতে চাইলে */
                }
            </style>
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

        <!-- GTranslate Script (Placed at the end of body) -->
        <script>
        window.gtranslateSettings = {
            "default_language": "en",
            "languages": ["en", "es", "fr", "de", "ar", "hi", "bn", "or", "tr", "it", "pt", "ru", "ja", "ko", "zh-CN"],
            "wrapper_selector": ".gtranslate_wrapper"
        };
        </script>
        <script src="https://cdn.gtranslate.net/widgets/latest/dropdown.js" defer></script>

        <script>
            // কুকি চেক করে আরবি সিলেক্ট থাকলে body-তে ক্লাস বসানো
            function checkArabicLanguage() {
                if (document.cookie.indexOf('/en/ar') !== -1 || document.documentElement.lang === 'ar') {
                    document.body.classList.add('translated-ar');
                } else {
                    document.body.classList.remove('translated-ar');
                }
            }

            // পেজ লোড ও পরিবর্তন চেক
            setInterval(checkArabicLanguage, 500);
        </script>
        </body>


		
    </body>
</html>


