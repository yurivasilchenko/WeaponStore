<div class="latest-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>Latest Products</h2>
                    <a href="#">view all products <i class="fa fa-angle-right"></i></a>

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

                <div class="filter-container">
                    <div class="filter-box filter-link filter-icon" data-type="All">
                        <div class="filter-content">
                            <img src="assets/images/All.png" alt="All">
                            <p class="filter-label">All</p>
                        </div>
                    </div>

                    <div class="filter-box filter-link filter-icon" data-type="A1">
                        <div class="filter-content">
                            <img src="assets/images/weapon-pistol.png" alt="A1">
                            <p class="filter-label">Pistol</p>
                        </div>
                    </div>

                    <div class="filter-box filter-link filter-icon" data-type="A2">
                        <div class="filter-content">
                            <img src="assets/images/weapon-winchester.png" alt="A2">
                            <p class="filter-label">Shotgun</p>
                        </div>
                    </div>

                    <div class="filter-box filter-link filter-icon" data-type="A3">
                        <div class="filter-content">
                            <img src="assets/images/weapon-AR.png" alt="A3">
                            <p class="filter-label">Assault-Rifle</p>
                        </div>
                    </div>

                    <div class="filter-box filter-link filter-icon" data-type="A4">
                        <div class="filter-content">
                            <img src="assets/images/weapon-knife.png" alt="A4">
                            <p class="filter-label">Cold Weapons</p>
                        </div>
                    </div>

                    <div class="filter-box filter-link filter-icon" data-type="A5">
                        <div class="filter-content">
                            <img src="assets/images/weapon-ammo.png" alt="A5">
                            <p class="filter-label">Ammo</p>
                        </div>
                    </div>

                </div>




            </div>
            <div id="notification" class="notification"></div>


            @include('user.filtered_products')


        </div>

    </div>
</div>


@include('user.scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>




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
                   // Ensure the response contains only the inner content
                   $('.filtered-products-container').html('<div class="row">' + response + '</div>');
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
