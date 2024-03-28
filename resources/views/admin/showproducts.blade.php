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
                    <th>Image</th>
                    <th>Update</th>
                    <th>Delete</th>

                </tr>
                </thead>
                <tbody>

                @foreach($data as $product)


                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->type}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->description}}</td>
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
