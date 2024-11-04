<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />



    <title>Weapon Store</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-sixteen.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">


</head>

<body class="showproduct-body">

<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->

<!-- Header -->
@include('user.header')

<!--Header end -->


<div class="container">
    <div class="row container-row">
        <div class="col-md-8">
            @if(!empty($product->image))
                @php
                    $images = json_decode($product->image);
                    $firstImage = isset($images[0]) ? $images[0] : null;
                @endphp
                <div class="product-main-img-container">
                    @if(!empty($firstImage))
                        <img class="product-main-img" src="/productimages/{{$firstImage}}">
                    @endif
                    <!-- Left Arrow -->
                    <button class="arrow left-arrow" onclick="changeImage(-1)">&#10094;</button>
                    <!-- Right Arrow -->
                    <button class="arrow right-arrow" onclick="changeImage(1)">&#10095;</button>
                </div>
            @endif

                @php
                    $decodedSpecs = json_decode($product->specs, true);
                    $specs = \App\Http\Controllers\HelperController::parseTree($decodedSpecs);
                @endphp


            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="row secondary-images-container">
                        @if(!empty($images))
                            @foreach($images as $image)
                                <div class="col-md-2 ">
                                    <img class="img-thumbnail product-secondary-img" src="/productimages/{{$image}}" onclick="changeMainImage(this)">
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 show-product">
            <div class="product-info">
                <div>
                    <div class="product-info">
                        <h1>{{ $product->name }}</h1>
                        <div class="price">
                            <p>{{ $product->price }}&#8382;</p>
                        </div>

                    </div>
                    <p class="product-description-preview">
                        {{ Str::limit($product->description, 150) }}
                        <span class="more-link" onclick="toggleDescription()">...more</span>
                    </p>
                    <p class="product-description-full" style="display: none;">
                        {{ $product->description }}
                        <span class="less-link" onclick="toggleDescription()">...less</span>
                    </p>

                    <div class="short-specs">
                        <h3 class="specs-header">Details: </h3> <!-- Added Details header -->
                        <ul class="custom-featured-list">
                            @foreach($specs as $spec)
                                <li>
                                    <a>
                                        <span>{{ key($spec) }}</span>: <span>{{ current($spec) }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>

            <div class="stock-info mt-4"> <!-- Added margin-top here -->
                @if($product->quantity > 0)
                    <p class="stock-status in-stock">In stock</p> <!-- Added 'in-stock' class -->
                    <p class="quantity-left">Only <span class="quantity">{{ $product->quantity }}</span> left!</p> <!-- Added a span for quantity -->
                @else
                    <p class="stock-status out-of-stock">Out of stock</p>
                @endif
            </div>

            <div class="add-to-cart-container">
                <form id="addToCartForm" action="{{ route('addcart', ['id' => $product->id, 'name' => $product->name, 'type' => $product->type, 'price' => $product->price, 'quantity' => $product->quantity, 'description' => $product->description, 'image' => $product->image]) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center">
                        <div>
                            <input type="hidden" name="productId" value="{{ $product->id }}">
                            <input class="btn btn-success cartbtn" type="submit" value="Add to Cart">
                        </div>
                        <div class="ml-2">
                            <div class="success-checkmark success-checkmark-product">
                                <div class="check-icon">
                                    <span class="icon-line line-tip"></span>
                                    <span class="icon-line line-long"></span>
                                    <div class="icon-circle"></div>
                                    <div class="icon-fix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        $decodedSpecs = json_decode($product->specs, true);
        $specs = \App\Http\Controllers\HelperController::parseTree($decodedSpecs);
    @endphp

    <div class="best-features" id="fullDescriptionSection">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading custom-section-heading">
                        <h2>About {{$product->name}}</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="left-content custom-section-heading">
                        <p>{{$product->description}}</p>
                        <p>Product Specs:</p>
                        <ul class="custom-featured-list">
                            @foreach($specs as $spec)
                                <li><a>{{ key($spec) }}: {{ current($spec) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('user.footer')

@include('user.scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>

    let currentIndex = 0; // Track the current image index
    const images = @json($images); // Pass the PHP images array to JavaScript

    function changeMainImage(element) {
        var mainImage = document.querySelector('.product-main-img');
        mainImage.src = element.src;
        currentIndex = Array.from(document.querySelectorAll('.product-secondary-img')).indexOf(element);
    }

    function changeImage(direction) {
        currentIndex += direction; // Move left or right
        if (currentIndex < 0) {
            currentIndex = images.length - 1; // Wrap to last image
        } else if (currentIndex >= images.length) {
            currentIndex = 0; // Wrap to first image
        }
        // Change the main image
        var mainImage = document.querySelector('.product-main-img');
        mainImage.src = '/productimages/' + images[currentIndex];
    }

    function toggleDescription() {
        document.getElementById('fullDescriptionSection').scrollIntoView({
            behavior: 'smooth'
        });
    }

</script>


<!-- Bootstrap core JavaScript -->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<!-- Additional Scripts -->
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/owl.js')}}"></script>
<script src="{{asset('assets/js/slick.js')}}"></script>
<script src="{{asset('assets/js/isotope.js')}}"></script>
<script src="{{asset('assets/js/accordions.js')}}"></script>


<script language = "text/Javascript">
    cleared[0] = cleared[1] = cleared[2] = 0; //set a cleared flag for each field
    function clearField(t){                   //declaring the array outside of the
        if(! cleared[t.id]){                      // function makes it static and global
            cleared[t.id] = 1;  // you could use true and false, but that's more typing
            t.value='';         // with more chance of typos
            t.style.color='#fff';
        }
    }
</script>



</body>

</html>
