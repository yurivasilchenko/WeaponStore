<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the cart items from local storage
        let cartItems = localStorage.getItem('cartItems');
        if (!cartItems) {
            // If cartItems is empty, initialize it as an empty array
            cartItems = [];
        } else {
            // Parse the cartItems JSON string into an array
            cartItems = JSON.parse(cartItems);
        }
        updateTotalPrice();




        // Select all delete buttons
        document.querySelectorAll('.deletebtn').forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the default click behavior


                // Get the product ID of the item to be deleted
                let productId = this.dataset.productId;

                // Remove the product ID from the cartItems array
                cartItems = cartItems.filter(id => id !== productId);

                // Update the cartItems in local storage
                localStorage.setItem('cartItems', JSON.stringify(cartItems));

                // Send an AJAX request to delete from the server
                fetch(this.href, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete item from cart.');
                    }
                    return response.json();
                }).then(data => {
                    // Update the cart count in the UI
                    updateCartCount(data.count);

                    // Remove the item from the UI
                    this.closest('tr').remove();
                    updateTotalPrice();

                    // Check if the cart is empty
                    if (data.count === 0) {
                        // Refresh the page
                        location.reload();
                    }

                }).catch(error => {
                    console.error('An error occurred:', error);
                });
            });
        });

        // Select the "Place an Order" button
        let placeOrderButton = document.querySelector('.btn.btn-success');
        if (placeOrderButton) {
            placeOrderButton.addEventListener('click', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Store a reference to the form
                let form = this.closest('form');

                // Show the modal
                let modal = document.getElementById('myModal');
                modal.style.display = 'block';

                // Add event listener for the "OK" button inside the modal
                let modalOkButton = document.getElementById('modalOkButton');
                modalOkButton.addEventListener('click', function () {
                    // Hide the modal
                    modal.style.display = 'none';

                    // Submit the form
                    form.submit();
                });
            });
        }



        document.querySelectorAll('.custom-number-input .increment').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input[type="number"]');
                input.stepUp();
                updatePrice(input);
                updateTotalPrice();
            });
        });

        document.querySelectorAll('.custom-number-input .decrement').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input[type="number"]');
                input.stepDown();
                updatePrice(input);
                updateTotalPrice();

            });
        });

        function updatePrice(input) {
            // Get the original price from the data attribute
            let priceElement = input.closest('tr').querySelector('.price-display');
            let originalPrice = parseFloat(priceElement.getAttribute('data-price'));
            console.log(originalPrice)

            // Get the quantity value
            let quantity = parseInt(input.value);

            // Calculate the new price
            let newPrice = originalPrice * quantity;

            // Update the price display if it exists
            if (priceElement) {
                priceElement.textContent = newPrice.toFixed(2).replace(/\.00$/, ''); // Remove .00
            }

            // Update the hidden price input value
            let hiddenPriceInput = input.closest('tr').querySelector('input[name="price[]"]');
            hiddenPriceInput.value = newPrice.toFixed(2);
        }

        function updateTotalPrice() {
            let total = 0;
            document.querySelectorAll('.price-display').forEach(priceDisplay => {
                let quantityInput = priceDisplay.closest('tr').querySelector('input[name="quantity[]"]');
                if (quantityInput) {
                    total += parseFloat(priceDisplay.getAttribute('data-price')) * parseInt(quantityInput.value);
                }
            });

            document.getElementById('totalPrice').textContent = total.toFixed(2);
        }

    });


    function updateCartCount() {
        fetch('{{ route('updatecartcount') }}')
            .then(response => response.json())
            .then(data => {
                let cartCountElement = document.querySelector('.cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = data.count ;
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
    }





</script>
