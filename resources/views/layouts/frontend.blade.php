<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nazo Dry Fruit</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/vendor.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('css/template-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chocolat.css') }}">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Chewy&amp;family=Nunito:ital,wght@0,200..1000;1,200..1000&amp;display=swap" rel="stylesheet"> -->
    

    {{-- Laravel Breeze/Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>[x-cloak]{display:none!important}</style>

</head>
<body >
    @include('components.header')

    @yield('content')

    {{-- popup lives once, globally --}}
    @include('partials.auth-popup')

    @include('components.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (Required for script.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- Jarallax -->
    <script src="https://cdn.jsdelivr.net/npm/jarallax@2/dist/jarallax.min.js"></script>

    <script src="{{ asset('js/chocolat.min.js') }}" ></script>
    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')

    
    <script>
        window.routes = {
            authLogin:    "{{ route('auth.popup.login') }}",
            authRegister: "{{ route('auth.popup.register') }}",
            checkout:     "{{ route('cart.checkout') }}",
        };
    </script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/auth.js') }}" defer></script>
    <script>
    function updateCartOffcanvas() {
        fetch("{{ route('cart.offcanvas') }}")
            .then(res => res.text())
            .then(html => {
                const body = document.querySelector("#offcanvasCart .offcanvas-body");
                if (body) {
                    body.innerHTML = html; // ✅ only inner content
                }
            })
            .catch(err => {
                console.error("Cart load failed:", err);
                const body = document.querySelector("#offcanvasCart .offcanvas-body");
                if (body) {
                    body.innerHTML = `<p class="text-danger">Failed to load cart</p>`;
                }
            });
    }


    function showCartOffcanvas() {
        updateCartOffcanvas();
        new bootstrap.Offcanvas(document.getElementById('offcanvasCart')).show();
    }
    function showAlert(message, type="success") {
        const alertBox = document.createElement("div");
        alertBox.className = `alert alert-${type}`;
        alertBox.textContent = message;
        document.querySelector(".container").prepend(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }


    </script>


</body>
</html>
