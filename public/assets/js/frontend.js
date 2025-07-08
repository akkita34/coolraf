jQuery(document).ready(function($) {
    $('#coolraf-product-type').change(function() {
        $.post(
            coolraf_ajax.ajax_url, 
            {
                action: 'coolraf_get_options',
                product_type: $(this).val()
            },
            function(response) {
                $('#coolraf-options-container').html(response.data.html);
            }
        );
    });
	
    $('#coolraf-submit').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: coolraf_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'coolraf_calculate_price',
                security: coolraf_ajax.nonce,
                product_type: $('#product-type').val()
            },
            success: function(response) {
                $('#price-result').text(response.data.price + ' ₺');
            }
        });
    });
});