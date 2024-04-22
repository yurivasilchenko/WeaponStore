<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/"><h2>Weapon <em>Store</em></h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Our Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>




                    @if (Route::has('login'))

                        @auth
{{--
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('showcart')}}">
                                    <i class="fas fa-shopping-cart"></i> My Cart <span class="cart-count">[{{$count}}]</span>
                                </a>
                            </li>--}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('showcart') }}">
                                    <i class="fas fa-shopping-cart"></i> My Cart <span class="cart-count">[{{$count}}]</span>
                                </a>
                            </li>





                            <li class="nav-item">

                                <x-app-layout>

                                </x-app-layout>

                            </li>

                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li>


                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}" >Register</a>
                                </li>


                            @endif
                        @endauth

                    @endif



                </ul>
            </div>
        </div>
    </nav>
</header>

<script>


</script>
