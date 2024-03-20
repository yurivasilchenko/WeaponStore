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

<body class="showcart-body">

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
    <div class="d-flex justify-content-center">
        <form action="{{url('order')}}" method="POST">

        <table class="table">
            <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>


               @csrf

            @foreach($cart as $carts)
                <tr>
                    <td class="align-middle">
                        <input type="text" name="product_name[]" value="{{$carts->product_name}}" hidden="">
                        {{$carts->product_name}}
                    </td>

                    <td class="align-middle">
                        <input type="text" name="quantity[]" value="{{$carts->quantity}}" hidden="">
                        {{$carts->quantity}}
                    </td>

                    <td class="align-middle">
                        <input type="text" name="price[]" value="{{$carts->price}}" hidden="">
                        {{$carts->price}}
                    </td>

                    <td class="text-center align-middle">
                        <input type="text" name="image[]" value="{{$carts->image}}" hidden="">

                        @if(!empty($carts->image))
                            @php
                                $images = json_decode($carts->image);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                            @endphp

                            @if(!empty($firstImage))
                                <img height="100px" width="100px" src="/productimages/{{$firstImage}}">
                            @endif
                        @endif

                    </td>

                    <td class="align-middle">
                        <a class="btn btn-danger deletebtn" href="{{url('delete',$carts->id)}}" data-product-id="{{$carts->id}}">Delete</a>
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>

            <div class="container showcart-footer">
                <div class="row">
                    <div class="col-md-12">
                        <div class="inner-content">
                            <button class="btn btn-success">Place an Order</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>



<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<!-- Additional Scripts -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/owl.js"></script>
<script src="assets/js/slick.js"></script>
<script src="assets/js/isotope.js"></script>
<script src="assets/js/accordions.js"></script>


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

@include('user.cart-scripts')

</body>

</html>
