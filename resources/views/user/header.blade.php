<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><h2>Weapon <em>Store</em></h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item {{ request()->route()->uri === 'redirect' ? ' active' : '' }}">
                        <a class="nav-link" href="/">Home<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Our Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('contact') }}">Contact Us</a>
                    </li>

                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item nav-cart-count {{ request()->route()->uri === 'showcart' ? ' active' : '' }}">
                                <a class="nav-link" href="{{ url('showcart') }}">
                                    <i class="fas fa-shopping-cart"></i> My Cart <div class="counter-count">[<span class="cart-count"> {{$count}} </span>]</div>
                                </a>
                            </li>
                            <li class="nav-item app-layout">
                                <x-app-layout></x-app-layout>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize navbar collapsed by default on smaller screens
        if ($(window).width() < 992) {
            $('#navbarResponsive').collapse('hide');
        } else {
            $('#navbarResponsive').collapse('show');
            $('.navbar-toggler').attr('aria-expanded', 'true');
        }

        // Toggle navbar on button click with collapse animation
        $('.navbar-toggler').on('click', function (e) {
            e.stopPropagation(); // Prevent conflicts with other JS

            const $navbar = $('#navbarResponsive');
            const isExpanded = $(this).attr('aria-expanded') === 'true';

            $navbar.collapse('toggle'); // Use Bootstrap's collapse
            $(this).attr('aria-expanded', !isExpanded); // Toggle aria-expanded attribute
        });

        // Handle resizing events for navbar behavior
        $(window).on('resize', function () {
            if ($(window).width() >= 992) {
                $('#navbarResponsive').collapse('show');
                $('.navbar-toggler').attr('aria-expanded', 'true');
            } else {
                $('#navbarResponsive').collapse('hide');
                $('.navbar-toggler').attr('aria-expanded', 'false');
            }
        });
    });
</script>
