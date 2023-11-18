<div class="latest-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Latest Products</h2>
                    <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>

                    <form action="{{url('search')}}" method="get"  class="form-inline mt-3 p-4 ml-auto ">

                        @csrf

                        <div class="input-group">
                            <input class="form-control" type="search" name="search" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success searchbtn">
                                    <i class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @foreach($data as $product)
            <div class="col-md-4">
                <div class="product-item">
                    <a href="#"><img src="productimage/{{$product->image}}" alt=""></a>
                    <div class="down-content">
                        <a href="#" ><h4>{{$product->name}}</h4></a>
                        <h6>{{$product->price}} GEL</h6>
                        <p>{{$product->description}}}</p>
                        <a class="btn btn-success cartbtn" href="#">Add to Cart</a>

                        <span>Reviews (24)</span>
                    </div>
                </div>
            </div>
            @endforeach



        </div>

        @if(method_exists($data,'links'))

        <div class="d-flex justify-content-center pagination">

            {!! $data->links() !!}

        </div>
        @endif
    </div>
</div>
