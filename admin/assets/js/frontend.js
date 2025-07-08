jQuery(document).ready(function($) {
    console.log('CoolRaf frontend yüklendi!');

    // Ürün tipi değiştiğinde motor tipini göster/gizle
    $('#product_type').change(function() {
        if ($(this).val() === 'cooling') {
            $('#motor_type_group').show();
        } else {
            $('#motor_type_group').hide();
        }
    });

    // Form submit işlemi
    $('#coolraf-submit').click(function(e) {
        e.preventDefault();
        
        // Form verilerini topla
        var formData = {
            action: 'coolraf_calculate_price',
            _ajax_nonce: coolraf_ajax.security,
            product_type: $('#product_type').val(),
            motor_type: $('#motor_type').val()
        };

        // AJAX isteği gönder
        $.ajax({
            url: coolraf_ajax.ajax_url,
            type: 'POST',
            data: formData,
            beforeSend: function() {
                $('#coolraf-submit').prop('disabled', true).text('Hesaplanıyor...');
            },
            success: function(response) {
                if (response.success) {
                    alert('Fiyat: ' + response.data.price + ' €');
                } else {
                    alert('Hata: ' + response.data.message);
                }
            },
            error: function(xhr) {
                alert('Sunucu hatası! Lütfen tekrar deneyin.');
            },
            complete: function() {
                $('#coolraf-submit').prop('disabled', false).text('Fiyat Hesapla');
            }
        });
    });
});