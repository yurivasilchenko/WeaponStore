<div class="container filtered-products-container">
    <div class="row">
        @foreach($data as $product)
            <div class="col-md-4">
                <div class="product-item">
                    <a href="{{route('showproduct', ['id' => $product->id])}}">
                        @if(!empty($product->image))
                            @php
                                $images = json_decode($product->image);
                                $firstImage = isset($images[0]) ? $images[0] : null;
                            @endphp

                            @if(!empty($firstImage))
                                <img src="/productimages/{{$firstImage}}">
                            @endif
                        @endif
                    </a>
                    <div class="down-content">
                        <a href="{{route('showproduct', ['id' => $product->id])}}"><h4>{{$product->name}}</h4></a>
                        <h6>{{$product->price}} GEL</h6>
                        <p class="description">{{$product->description}}</p>

                        <form id="addToCartForm" action="{{ route('addcart', ['id' => $product->id, 'name' => $product->name,'type' => $product->type, 'price' => $product->price, 'quantity' => $product->quantity, 'description' => $product->description, 'image' => $product->image]) }}" method="POST">
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
        <div id="pagination-container" class="d-flex justify-content-center pagination">
            {{ $data->appends(Request::except('page'))->links()  }}

        </div>
    @endif
</div>

