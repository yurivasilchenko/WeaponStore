<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    @include('admin.css')
</head>
<body>
<div class="container-scroller">

    <script>
        var deleteProductURL = "{{ url('deleteproduct') }}";
    </script>

    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')



    <div class="container-fluid page-body-wrapper custom-table-container">


        <div class="container text-center">
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card custom-card">
                        <div class="card-body py-0 px-0 px-sm-3">
                            <div class="row align-items-center">
                                <div class="col-4 col-sm-3 col-xl-2">
                                    <img src="admin/assets/images/dashboard/Group126@2x.png" class="gradient-corona-img img-fluid" alt="">
                                </div>

                                <div class="col-3 col-sm-2 col-xl-2 ps-0 text-center">
                                    <ul class="navbar-nav w-100">
                                        <li class="nav-item w-100">
                                            <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search" method="GET" action="{{route('showproducts')}}">
                                                <input type="text" class="form-control" name="query" placeholder="Name">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="notification" class="notification "></div>

            <table class="table table-striped table-bordered justify-content-center custom-table" >

                @csrf
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Description</th>
                    <th>Specs</th>
                    <th>Image</th>
                    <th>Update</th>
                    <th>Delete</th>

                </tr>
                </thead>
                <tbody>

                @foreach($products as $product)


                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->type}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->quantity}}</td>
                    <td class="description-cell">{{$product->description}}</td>
                    <td class="description-cell">


                        @php
                            $decodedSpecs = json_decode($product->specs, true);

                      $specs =  \App\Http\Controllers\HelperController::parseTree($decodedSpecs);

                        @endphp

                        <ul>
                            @foreach($specs as $spec)
                                <li>{{ key($spec) }}: {{ current($spec) }}</li>
                            @endforeach
                        </ul>



                    </td>
                    <td class="d-flex justify-content-center align-items-center">
                        @if(!empty($product->image))
                            @php
                                $images = json_decode($product->image);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                            @endphp

                            @if(!empty($firstImage))
                                <img height="100px" width="100px" src="/productimages/{{$firstImage}}">
                            @endif
                        @endif
                    </td>

                    <td>
                       <a class="btn btn-warning" href="{{url('updateproduct', $product->id) }}">Update</a>
                    </td>

                    <td>
                        <a class="btn btn-danger delete-product" href="{{ route('deleteproduct', $product->id) }}" data-id="{{ $product->id }}">Delete</a>
                    </td>



                </tr>

                @endforeach


                <!-- Add more rows for additional products here -->
                </tbody>
            </table>
        </div>
    </div>



        <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.scripts')
</body>
</html>
