let containerEl = document.querySelector(".container")
let itemsOnCart = 0
let itemsOnCartText = document.getElementById("items-count")
let addToCartForm = document.getElementById("add-to-cart")
let removingItemForm = document.getElementById("remove-items-form")
let addetItemData = document.querySelector(".added-item-name")
function updateItemCount() {
    fetch("s.php")
     .then(response=>response.text())
     .then(data => {
        itemsOnCartText.textContent = data
     })
}


updateItemCount()



function preventRel(event) {
    updateItemCount()
}

$(document).ready(function() {
    $("#ajax-loader").hide()  
        $(document).on('click', '.add-to-cart', function(event) {
            event.preventDefault(); // Prevent the default form submission
            
            
            // Get the form data
            const item_id = $(this).closest('.items').find('#item_id').val();
            const item_name = $(this).closest('.items').find('#item_name').val();
            const item_image = $(this).closest('.items').find('#item_image').val();
            const item_price = $(this).closest('.items').find('#item_price').val();
            const quantity = $(this).closest('.items').find('#quantity').val();


            // const item_id = $('#item_id').val();
            // const item_name = $('#item_name').val();
            // const item_image = $('#item_image').val();
            // const item_price = $('#item_price').val();
            // const quantity = $('#quantity').val();
            
            // Sending an AJAX request
            $.ajax({
                url: 'add-to-cart.php', // URL to send the data to
                type: 'POST',
                data: {
                    item_id: item_id,
                    item_name: item_name,
                    item_image: item_image,
                    item_price: item_price,
                    quantity: quantity
                },
                beforeSend: function () {
                    $("#ajax-loader").show()
                },
                success: function(response) {
                    console.log(response)
                    $('.added-item-name').text(response)
                    $('#cart-response').addClass("active"); // Displaying the server response
                    console.log(item_id, item_image, item_name, item_price)
                },
                complete: function () {
                    $("#ajax-loader").hide()  
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error); // Log any errors
                }
            });
            updateItemCount()
        });    
   
    
});

$("#close-dialog").on("click", function () {
    $('#cart-response').removeClass("active")
})







