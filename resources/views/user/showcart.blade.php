<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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



<div class="container mt-4 container-cart">
    <div class="justify-content-center">
        @if($cart->isEmpty())
            <div class="text-center empty">
                <h2>Your cart is empty!</h2>
                <div class="d-flex justify-content-center">
                    <!-- Add your icon here -->
                    <img src="assets/images/empty.png" alt="A2">
                </div>
            </div>
        @else
        <form action="{{url('order')}}" method="POST" class="cart-form">
            @csrf

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @csrf
                    @foreach($cart as $carts)
                        <tr>

                            <td class="align-middle">
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
                                <input type="text" name="product_name[]" value="{{$carts->product_name}}" hidden="">
                                {{$carts->product_name}}
                            </td>
                            <td class="align-middle" style="display: none;">
                                <input type="text" name="type[]" value="{{$carts->type}}">
                                {{$carts->type}}
                            </td>
                            <td class="align-middle">
                                <div class="custom-number-input">
                                    <div class="decrement">-</div>
                                    <input type="number" name="quantity[]" value="1" min="1" step="1">
                                    <div class="increment">+</div>
                                </div>
                            </td>


                            <td class="align-middle">
                                <input type="text" name="price[]" value="{{$carts->price}}" hidden="">
                                <span class="price-display" data-price="{{$carts->price}}">{{$carts->price}}</span>
                                <a>  &#8382;</a>
                            </td>

                            <td class="align-middle">
                                <a class="btn btn-danger deletebtn" href="{{url('delete',$carts->id)}}" data-product-id="{{$carts->id}}">Delete</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>



            <div class="row custom-row-flex">
                <div class="empty-space"></div>
                <div class="custom-col-md-4">
                    <div>Total price :</div>
                </div>
                <div class="custom-col-md-4 total-price">
                    <div><span id="totalPrice"></span> &#8382;</div>
                </div>
            </div>





            <!-- Place an Order button -->
            <div class="container showcart-footer">
                <div class="row justify-content-end">
                    <div class="showcart-btn text-right">
                        <div class="inner-content">
                            <button class="btn btn-success">Place an Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endif


    </div>
</div>



@include('user.footer')


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

<div id="myModal" class="modal">
    <div class="modal-content">
        <h2>Your order has been placed!</h2>
        <p>We will contact you via email or phone! Also, if you have any questions, you can contact us first!</p>
        <p>Thanks for choosing us!</p>
        <button id="modalOkButton" class="btn btn-success">OK</button>
    </div>
</div>



</html>
