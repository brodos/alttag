<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('head')
</head>
<body class="h-full bg-grey-lighter font-sans text-base">
    <div id="app" class="wrapper">

        <nav class="bg-blue-dark shadow-inner z-10">

            <div class="container mx-auto text-grey-lightest flex items-center justify-between py-5 leading-normal">

                <a class="navbar-brand inherit text-3xl no-underline text-grey-lightest tracking-wide leading-none flex flex-col" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                    <span class="text-xs text-right">beta</span>
                </a>
                
                <div class="flex items-center">

                    @auth
                        <div class="">
                            <a href="{{ route('user-sites.index') }}" class="no-underline text-blue-lightest hover:text-blue-lighter">My Sites</a>
                        </div>
                        <div class="user flex items-center lg:pl-6 lg:ml-6 border-l border-blue">
                            
                            <img src="{{ auth()->user()->avatar() }}" class="rounded-full w-8 h-8 sm:mr-3">
                                
                            <div class="meta hidden sm:flex flex-col justify-between text-sm font-semibold text-white leading-tight">
                                <span>{{ auth()->user()->name }}</span>
                                <span><a href="{{ route('logout') }}" class="no-underline font-normal text-blue-lighter hover:underline hover:text-blue-darkest">Ieșire</a></span>
                            </div>
                        </div>
                    @else
                        @if (! Request::is('login'))
                            <a href="{{ route('login') }}" class="btn btn-secondary-blue-light">Sign In</a>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <main class="container mx-auto">

            @yield('content')

        </main>

        <footer>

            <div class="container mx-auto py-10 text-center">

                <span class="text-grey-dark text-sm">&copy; {{ date('Y') }}</span>

            </div>
            
        </footer>

    </div>
    
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
