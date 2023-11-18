<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    <!-- Required meta tags -->
    @include('admin.css')
</head>
<body>
<div class="container-scroller">



    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')

    <div class="container-fluid page-body-wrapper">

        <div class="container">


            <form action="{{url('updatedproduct',$data->id)}}" method="post"  enctype="multipart/form-data">
                <div id="notification" class="notification"></div>

                @csrf


                <div class="form-row">
                    <div class="form-group ">
                        <h1 style="color: white; padding: 25px 25px 25px 0; font-size: 25px;">Add Product</h1>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{$data->price}}" required>
                    </div>

                    <div class="form-group col-md-4 ">
                        <label for="quantity">Product Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" value="{{$data->quantity}}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="desc">Description</label>
                        <textarea type="text" class="form-control" id="desc" name="desc" rows="4" required>{{$data->description}}</textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Old Image</label>
                        <img height="200px" width="200px" src="/productimage/{{$data->image}}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="file">Choose a new Image</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                        </div>
                    </div>

                </div>



                <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>



    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.scripts')
</body>
</html>
