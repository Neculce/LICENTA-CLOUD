<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Laravel</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="./app.css">

    <!-- Styles -->

</head>

<body class="font-mono antialiased bg-slate-700 dark:text-white/50 justify-center">

<!-- Div pentru navbar. De asemenea include codul de verificare pentru controllere -->

    <div class="flex justify-between py-2 bg-slate-900">
        <header class="flex justify-between items-center w-full">
            @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 justify-between px-5 items-center">

                    <div> <!-- Div aliniat stanga-->
                        <p class="rounded-lg px-4 font-mono text-3xl  text-slate-400"> Reti Matei </p>
                    </div>

                    <div>
                        <p class="px-4 font-mono text-4xl text-slate-300">Cloud Storage </p>
                    </div>

                    <div> <!-- Div aliniat dreapta-->
                        @auth
                            <a href="{{ url('/dashboard') }}" class="rounded-lg inline-block py-3 px-4 mr-2 leading-5 bg-slate-800 hover:bg-slate-500 hover:text-slate-950 text-xl">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-lg inline-block py-3 px-4 mr-2 leading-5 bg-slate-800 hover:bg-slate-500 hover:text-slate-950 text-xl">
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="rounded-lg inline-block py-3 px-4 mr-2 leading-5 bg-slate-800 hover:bg-slate-500 hover:text-slate-950 text-xl">
                                    Register
                                </a>
                            @endif
                        @endauth
                    </div>
                </nav>
            @endif
        </header>
    </div>

<!-- Section pentru "carduri" ce contin pasii pentru inregistrare, log-in si utilizare-->

    <section class="flex justify-between">

        <div class="flex justify-between px-5 py-5 ">

            <!-- Div pas 1 : inregistrare -->

            <div class=" rounded-[30px] border-4 border-black bg-slate-400 py-5 px-5 m-10 text-slate-950 items-center justify-center text-center ">

                <img class="h-32 w-32 m-5 block mx-auto" src="{{ asset('images/edit.png') }}">

                <div class="bg-slate-600 rounded-lg">
                <h1 class="text-center"> First step : Registering </h1>
                </div>
                <p class="text-center"> You will need to register first and verify your email in order to acces our cloud storage service </p>
            </div>

            <!-- Div pas 2 : logare -->

            <div class=" rounded-[30px] border-4 border-black bg-slate-400 py-5 px-5 m-10 text-slate-950 items-center justify-center text-center ">

                <img class="h-32 w-32 m-5 block mx-auto" src="{{ asset('images/log-in.png') }}">

                <div class="bg-slate-600 rounded-lg">
                <h1 class="text-center"> Second step : Log in </h1>
                </div>

                <p class="text-center"> After the registration process you will be redirected to the login page. For security purposes, whenever you close the browser,
                    you will have to log in again. </p>
            </div>

            <!-- Div pas 3 : stocare -->

            <div class=" rounded-[30px] border-4 border-black bg-slate-400 py-5 px-5 m-10 text-slate-950 items-center justify-center text-center ">

                <img class="h-32 w-32 m-5    block mx-auto" src="{{ asset('images/hosting.png') }}">
                
                <div class="bg-slate-600 rounded-lg">
                <h1 class="text-center"> Final step : Store </h1>
                </div>

                <p class="text-center"> Now that you are registered and logged in, you may use your storage to store any kind of files you wish </p>
            </div>

        </div>


    </section>



<!-- Div pentru footer. -->
    <div class="flex align-bottom justify-center">
        <footer
            class=" rounded-md text-center bottom-6 py-4 text-slate-900 dark:text-white/70 fixed  w-max font-mono text-sm">
            Reti M. Matei - Licenta - Universitatea Titu Maiorescu - Prof. Mihai Popescu
        </footer>
    </div>


</body>

</html>
