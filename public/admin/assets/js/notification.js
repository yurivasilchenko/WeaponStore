$(document).ready(function() {
    $("#product-form").on("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission
        // Serialize the form data
        var formData = new FormData(this);

        // Send an AJAX request to submit the form
        $.ajax({
            url: uploadProductURL,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show a success notification
                    showNotification(response.message, "success");
                    // Clear the form
                    $("#product-form")[0].reset();
                } else {
                    // Handle errors if necessary
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                showNotification("An error occurred: " + error, "error");
            }
        });
    });

    // Function to show a notification
    function showNotification(message, type) {
        var notification = $("#notification");
        notification.text(message);
        notification.removeClass();
        notification.addClass("notification " + type).show();

        // Hide the notification after a few seconds
        setTimeout(function() {
            notification.hide();
        }, 5000); // 5000 milliseconds = 5 seconds
    }
});




$(document).ready(function() {
    $(".delete-product").click(function(e) {
        e.preventDefault(); // Prevent the default link behavior
        var productId = $(this).data("id");

        if (confirm("Are you sure you want to delete this product?")) {
            deleteProduct(productId);
        }
    });

    function deleteProduct(productId) {
        $.ajax({
            type: "GET",
            url: "/deleteproduct/" + productId,
            data: {
                "_token": "{{ csrf_token() }}",
                "_method": "GET"
            },
            success: function(response) {
                if (response.success) {
                    // Show a success notification
                    showNotification(response.message, "success");
                    // Optionally, remove the table row
                    $(`[data-id="${productId}"]`).closest("tr").remove();
                } else {
                    // Handle errors if necessary
                    showNotification("Error deleting product", "error");
                }
            },
            error: function(xhr, status, error) {
                // Handle errors if necessary
                showNotification("An error occurred: " + error, "error");
            }
        });
    }

    // Function to show a notification
    function showNotification(message, type) {
        var notification = $("#notification");
        notification.text(message);
        notification.removeClass();
        notification.addClass("notification " + type).css("display", "block");

        // Hide the notification after 5 seconds
        setTimeout(function() {
            notification.css("display", "none");
        }, 5000); // 5000 milliseconds = 5 seconds
    }
});

