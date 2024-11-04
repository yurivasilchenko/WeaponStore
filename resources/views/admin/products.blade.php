

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    @include('admin.css')
</head>
<body>
<div class="container-scroller">

    <script>
        var uploadProductURL = "{{ url('uploadproduct') }}";
    </script>

    <!-- partial:partials/_sidebar.html -->
    @include('admin.sidebar')
    <!-- partial -->
    @include('admin.navbar')

    <div class="container-fluid page-body-wrapper">

        <div class="container">


            <form action="{{url('uploadproduct')}}" method="post" id="product-form" class="custom-form" enctype="multipart/form-data">
                <div id="notification" class="notification"></div>

                @csrf


                <div class="form-row">
                    <div class="form-group ">
                        <h1 style="color: white; padding: 25px 25px 25px 0; font-size: 25px;">Add Product</h1>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Give a product name" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="type">Product Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="A1">A1</option>
                            <option value="A2">A2</option>
                            <option value="A3">A3</option>
                            <option value="A4">A4</option>
                            <option value="A5">A5</option>
                        </select>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Give a product price" required>
                    </div>

                    <div class="form-group col-md-4 ">
                        <label for="quantity">Product Quantity</label>
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Product quantity" required>
                    </div>

                    <div class="form-group col-md-4 description">
                        <label for="desc">Description</label>
                        <textarea type="text" class="form-control" id="desc" name="desc" rows="4" placeholder="Enter a detailed product description" required></textarea>
                    </div>

                  <div class="form-group col-md-4">
                      <label for="specs">Specifications</label>
                      <div id="specs-container">
                          <div class="specs-row mb-2 row">
                              <div class="col-md-6">
                                  <input type="text" class="form-control mb-1" placeholder="Key" name="specs[0][key]" >
                              </div>
                              <div class="col-md-6">
                                  <input type="text" class="form-control" placeholder="Value" name="specs[0][value]" >
                              </div>
                          </div>
                      </div>
                      <div class="btn-group">
                          <button type="button" class="btn btn-secondary" id="add-specs-btn">+ Add Specifications</button>
                          <button type="button" class="btn btn-danger" id="remove-specs-btn">- Remove Specifications</button>
                      </div>

                  </div>




                    <div class="form-group col-md-4">
                        <label for="files">Choose Files</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="files" name="files[]" multiple>
                            <label class="custom-file-label" for="files"></label>
                        </div>
                    </div>


                </div>



                <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>


    <!-- container-scroller -->
<!-- plugins:js -->
@include('admin.scripts')

</div>
</body>

</html>
