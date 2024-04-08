<script>

    addToCartButtonFunction()

    function addToCartButtonFunction() {



            // Get the cart items from local storage
            let cartItems = localStorage.getItem('cartItems');
            if (!cartItems) {
                // If cartItems is empty, initialize it as an empty array
                cartItems = [];
            } else {
                // Parse the cartItems JSON string into an array
                cartItems = JSON.parse(cartItems);
            }

            // Select all cart buttons
            document.querySelectorAll('.cartbtn').forEach(button => {
                console.log('wokrs')
                // Get the product ID from the button's data attribute
                let productId = button.parentElement.querySelector('input[name="productId"]').value;


                // Check if the product ID is already in the cartItems array
                if (cartItems.includes(productId)) {

                    // If the product is already in the cart, disable the button
                    button.disabled = true;
                }

                // Add click event listener to each button
                button.addEventListener('click', function (event) {
                    console.log('wokrs 2')
                    event.preventDefault(); // Prevent the default click behavior



                    // Disable the button to prevent multiple submissions
                    this.disabled = true;

                    // Check if the user is authenticated
                    if (!authCheck()) {
                        // If the user is not authenticated, redirect to login
                        window.location.href = '/login'; // Use absolute path
                        return; // This ends the execution of the function
                    }

                    // Add the product ID to the cartItems array
                    cartItems.push(productId);

                    // Update the cartItems in local storage
                    localStorage.setItem('cartItems', JSON.stringify(cartItems));

                    // Find the parent product-item of the clicked button
                    /*let productItem = this.closest('.product-item');*/
                    let productItem = this.closest('.col-md-4');
                    console.log(productItem);

                    // Submit the form using AJAX
                    let form = this.closest('form');
                    console.log(form);
                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form)
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to add product to cart.');
                        }
                        return response.json(); // Parse the JSON response
                    }).then(data => {
                        // Show the checkmark animation for this product-item if it exists
                        let checkmark = productItem.querySelector('.success-checkmark');
                        console.log(checkmark)
                        if (checkmark) {
                            checkmark.style.display = 'block';
                        }

                        // Update the cart count
                        updateCartCount();
                    }).catch(error => {
                        console.error('An error occurred:', error);

                    }).catch(error => {
                        console.error('An error occurred:', error);




                        // Redirect to login if the user is not authenticated
                        window.location.href = '/login';
                    });
                });
            });


        // C
        function authCheck() {
            // Check if the user is authenticated using Laravel's Auth facade
            return {{Auth::check()}}; // This will output true if the user is authenticated, false otherwise
        }

        //Updating Count on Cart--------------------------------------------------------------------------------------------
        function updateCartCount() {
            console.log('Function called');
            fetch('{{ route('updatecartcount') }}')
                .then(response => response.json())
                .then(data => {
                    let cartCountElement = document.querySelector('.cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = '[' + data.count + ']';
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }
    }



</script>
