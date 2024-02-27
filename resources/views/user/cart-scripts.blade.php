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
                }).catch(error => {
                    console.error('An error occurred:', error);
                });
            });
        });
    });

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




</script>
