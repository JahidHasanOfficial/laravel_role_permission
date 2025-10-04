<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


        <!-- head -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<!-- body 끝ের কাছে -->
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>






<!-- layout.blade.php -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if(session('success'))
        Toastify({
            text: "{{ session('success') }}",
            duration: 4000,
            close: true,
            gravity: "bottom", // top or bottom
            position: "right", // left, center or right
            // backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)" // যদি CDN তে না থাকে, Toastify accepts CSS string but avoid hardcoding colors unless you want
        }).showToast();
    @endif

    @if(session('error'))
        Toastify({
            text: "{{ session('error') }}",
            duration: 5000,
            close: true,
            gravity: "top",
            position: "right",
        }).showToast();
    @endif

    @if(session('info'))
        Toastify({
            text: "{{ session('info') }}",
            duration: 3500,
            close: true,
            gravity: "top",
            position: "right",
        }).showToast();
    @endif

    @if(session('warning'))
        Toastify({
            text: "{{ session('warning') }}",
            duration: 4500,
            close: true,
            gravity: "top",
            position: "right",
        }).showToast();
    @endif

    // Validation errors দেখাতে চাইলে (একাধিক):
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            Toastify({
                text: "{{ $error }}",
                duration: 5000,
                close: true,
                gravity: "top",
                position: "right",
            }).showToast();
        @endforeach
    @endif
});
</script>

{{-- <script>
    Toastify({
  text: "Success!",
  duration: 3000,
  close: true,
  gravity: "top",
  position: "right",
  style: {
    background: "linear-gradient(to right, #00b09b, #96c93d)"
  }
}).showToast();

</script> --}}








    </body>
</html>
