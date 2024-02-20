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
            <div id="notification" class="notification"></div>

            @foreach($data as $product)
            <div class="col-md-4">
                <div class="product-item">
                    <a href="#"><img src="productimage/{{$product->image}}" alt=""></a>
                    <div class="down-content">
                        <a href="#" ><h4>{{$product->name}}</h4></a>
                        <h6>{{$product->price}} GEL</h6>
                        <p>{{$product->description}}}</p>

                        <form action="{{ route('addcart', ['id' => $product->id, 'name' => $product->name, 'price' => $product->price, 'quantity' => $product->quantity, 'description' => $product->description, 'image' => $product->image]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="productId" value="{{$product->id}}">
                            <input class="btn btn-success cartbtn" type="submit" value="Add to Cart">
                        </form>

                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach



        </div>

        @if(method_exists($data,'links'))

        <div class="d-flex justify-content-center pagination">

            {{ $data->links() }}

        </div>
        @endif

    </div>
</div>

@include('user.css')
@include('user.scripts')


