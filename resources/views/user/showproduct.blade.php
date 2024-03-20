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

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            @if(!empty($product->image))
                @php
                    $images = json_decode($product->image);
                    $firstImage = isset($images[0]) ? $images[0] : null;
                @endphp
                @if(!empty($firstImage))
                    <img class="product-main-img" src="/productimages/{{$firstImage}}">
                @endif
            @endif
        </div>
        <div class="col-md-4">
            <div style="margin-top: 20px;">
                <h2>{{ $product->name }}</h2>
            </div>
            <div>
                <p>Price: {{ $product->price }}</p>
            </div>
            <div>
                <p>Quantity: {{ $product->quantity }}</p>
            </div>
            <div>
                <form action="{{ route('addcart', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="productId" value="{{ $product->id }}">
                    <button class="btn btn-success" type="submit">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <p>Description: {{ $product->description }}</p>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="row">
                @if(!empty($images))
                    @foreach($images as $image)
                        <div class="col-md-2">
                            <img class="img-thumbnail product-secondary-img" src="/productimages/{{$image}}" onclick="changeMainImage(this)">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(element) {
        var mainImage = document.querySelector('.product-main-img');
        mainImage.src = element.src;
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
