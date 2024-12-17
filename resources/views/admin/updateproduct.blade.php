<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/public">
    <!-- Required meta tags -->
    <link rel="stylesheet" href="assets/css/css-admin/products.css">
    @include('admin.css')
</head>
<body>
<div class="container-scroller">



    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')

        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                <div class="content-wrapper">

            <div class="container">


                <form action="{{url('updatedproduct',$data->id)}}" class="custom-form" method="post"  enctype="multipart/form-data">
                    <div id="notification" class="notification"></div>

                    @csrf


                    <div class="form-row">
                        <div class="form-group ">
                            <h1>Update Product</h1>
                        </div>
                        <div class="form-group ">
                            <label for="name">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$data->name}}" required>
                        </div>

                        <div class="form-group ">
                            <label for="type">Product Type</label>
                            <select class="form-control" id="type" name="type" value="{{$data->type}}" required>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="A3">A3</option>
                                <option value="A4">A4</option>
                                <option value="A5">A5</option>
                            </select>
                        </div>

                        <div class="form-group ">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" value="{{$data->price}}" required>
                        </div>

                        <div class="form-group ">
                            <label for="quantity">Product Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" value="{{$data->quantity}}" required>
                        </div>

                        <div class="form-group description">
                            <label for="desc">Description</label>
                            <textarea type="text" class="form-control" id="desc" name="desc" rows="4" required>{{$data->description}}</textarea>
                        </div>

                        <div class="form-group ">
                            <label for="specs">Specifications</label>
                            <div id="specs-container">
                                @php
                                    // Decode the JSON specifications from the database
                                    $specsArray = json_decode($data->specs, true);
                                @endphp
                                @foreach($specsArray as $key => $value)
                                    <div class="specs-row mb-2 row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control mb-1" placeholder="Key" name="specs[{{ $key }}][key]" value="{{ $key }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" placeholder="Value" name="specs[{{ $key }}][value]" value="{{ $value }}" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-secondary" id="add-specs-btn">+ Add Specifications</button>
                                <button type="button" class="btn btn-danger" id="remove-specs-btn">- Remove Specifications</button>
                            </div>
                        </div>




                        <div class="form-group ">
                            <label>Old Image</label>
                            @if(!empty($data->image))
                                @php
                                    $images = json_decode($data->image);
                                    $firstImage = isset($images[0]) ? $images[0] : null;
                                @endphp

                                @if(!empty($firstImage))
                                    <img height="100px" width="100px" src="/productimages/{{$firstImage}}">
                                @endif
                            @endif
                        </div>

                        <div class="form-group ">
                            <label for="files">Choose Files</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="files" name="files[]" multiple>
                                <label class="custom-file-label" for="files"></label>
                            </div>
                        </div>

                    </div>



                    <div class="form-group text-center">
                        <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
@include('admin.scripts')
</body>
</html>
