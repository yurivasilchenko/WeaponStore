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
                <a href="#" class="filter-link" data-type="A1">A1</a>
                <a href="#" class="filter-link" data-type="A2">A2</a>
                <a href="#" class="filter-link" data-type="A3">A3</a>
                <a href="#" class="filter-link" data-type="A4">A4</a>
                <a href="#" class="filter-link" data-type="A5">A5</a>
            </div>
            <div id="notification" class="notification"></div>


            @include('user.filtered_products')


        </div>

    </div>
</div>

@include('user.css')
@include('user.scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>


   /*document.addEventListener('DOMContentLoaded', function () {
       // Function to disable "Add to Cart" button if product is in cart
       function disableAddToCartButtons() {
           let cartItems = localStorage.getItem('cartItems');
           if (!cartItems) {
               cartItems = [];
           } else {
               cartItems = JSON.parse(cartItems);
           }

           document.querySelectorAll('.cartbtn').forEach(button => {
               let productId = button.parentElement.querySelector('input[name="productId"]').value;

               if (cartItems.includes(productId)) {
                   button.disabled = true;
               }
           });
       }

       // Initial disable check
       disableAddToCartButtons();

       // Event listener for filter links
       document.querySelectorAll('.filter-link').forEach(link => {
           link.addEventListener('click', function (e) {

               e.preventDefault();

               var selectedType = this.dataset.type;

               $.ajax({
                   url: '/filter-products',
                   type: 'GET',
                   data: { type: selectedType },
                   success: function (response) {
                       $('.filtered-products-container').html(response);
                       history.pushState(null, null, '/filter-products?type=' + selectedType);

                       // After updating products, re-run the disable check
                       disableAddToCartButtons();

                       console.log('I am here');
                       addToCartButtonFunction();


                   },
                   error: function (xhr) {
                       console.log(xhr.responseText);
                   }
               });
           });
       });

       // Event listener for browser back button
       window.addEventListener('popstate', function (event) {
           // Re-run the disable check when navigating back
           disableAddToCartButtons();
       });
   });
*/


   document.addEventListener('DOMContentLoaded', function () {
       // Function to load products based on filter

       function disableAddToCartButtons() {
           let cartItems = localStorage.getItem('cartItems');
           if (!cartItems) {
               cartItems = [];
           } else {
               cartItems = JSON.parse(cartItems);
           }

           document.querySelectorAll('.cartbtn').forEach(button => {
               let productId = button.parentElement.querySelector('input[name="productId"]').value;

               if (cartItems.includes(productId)) {
                   button.disabled = true;
               }
           });
       }

       function loadProducts(filter) {
           $.ajax({
               url: '/filter-products',
               type: 'GET',
               data: { type: filter },
               success: function (response) {
                   $('.filtered-products-container').html(response);
                   disableAddToCartButtons(); // Re-run the disable check for add to cart buttons

                   console.log('I am here');
                   addToCartButtonFunction();
               },
               error: function (xhr) {
                   console.log(xhr.responseText);
               }
           });
       }

       // Event listener for filter links
       document.querySelectorAll('.filter-link').forEach(link => {
           link.addEventListener('click', function (e) {
               e.preventDefault();
               var selectedType = this.dataset.type;
               loadProducts(selectedType);
               history.pushState(null, null, '/filter-products?type=' + selectedType);
           });
       });

       // Event listener for browser back/forward button
       window.addEventListener('popstate', function (event) {
           var selectedType = getFilterTypeFromUrl();
           loadProducts(selectedType);
       });

       // Function to extract filter type from the current URL
       function getFilterTypeFromUrl() {
           var urlParams = new URLSearchParams(window.location.search);
           return urlParams.get('type');
       }

       // Initial load based on current filter in URL
       var initialFilter = getFilterTypeFromUrl();
       if (initialFilter) {
           loadProducts(initialFilter);
       }
   });


</script>
