<?php
namespace CoolRaf;

defined('ABSPATH') || exit;

class Ajax {
    public function __construct() {
        // Fiyat hesaplama AJAX endpoint'i
        add_action('wp_ajax_coolraf_calculate_price', [$this, 'calculate_price']);
        add_action('wp_ajax_nopriv_coolraf_calculate_price', [$this, 'calculate_price']);

        // Konfigürasyon seçenekleri endpoint'i
        add_action('wp_ajax_coolraf_get_options', [$this, 'get_options']);
        add_action('wp_ajax_nopriv_coolraf_get_options', [$this, 'get_options']);
		add_action('wp_ajax_coolraf_new_action', [$this, 'new_ajax_handler']);
		add_action('wp_ajax_nopriv_coolraf_new_action', [$this, 'new_ajax_handler']);
    }

    /**
     * Fiyat hesaplama AJAX işleyicisi
     */
    public function calculate_price() {
        check_ajax_referer('coolraf-nonce', 'security');

        $product_type = sanitize_text_field($_POST['product_type'] ?? '');
        $motor_type = sanitize_text_field($_POST['motor_type'] ?? '');
        $temperature = sanitize_text_field($_POST['temperature'] ?? '');

        try {
            $price = $this->calculate_product_price($product_type, $motor_type, $temperature);
            
            wp_send_json_success([
                'price' => number_format($price, 2),
                'currency' => '₺',
                'configuration' => [
                    'product_type' => $product_type,
                    'motor_type' => $motor_type
                ]
            ]);
        } catch (\Exception $e) {
            wp_send_json_error([
                'message' => __('Fiyat hesaplanırken hata oluştu', 'coolraf')
            ], 500);
        }
    }

    /**
     * Dinamik seçenekleri döndürür
     */
    public function get_options() {
        check_ajax_referer('coolraf-nonce', 'security');

        $product_type = sanitize_text_field($_POST['product_type'] ?? '');
        $html = '';

        switch ($product_type) {
            case 'cooling':
                $html = $this->render_cooling_options();
                break;
            
            case 'initial':
                $html = $this->render_initial_options();
                break;
        }

        wp_send_json_success(['html' => $html]);
    }

    /**
     * Soğutmalı ürün seçenekleri
     */
    private function render_cooling_options() {
        ob_start(); ?>
        <div class="coolraf-form-group">
            <label><?php _e('Motor Tipi:', 'coolraf'); ?></label>
            <select name="motor_type" class="coolraf-form-control">
                <option value="external"><?php _e('Dışarı Motorlu (Remonel)', 'coolraf'); ?></option>
                <option value="internal"><?php _e('İçten Motorlu (Pilagris)', 'coolraf'); ?></option>
            </select>
        </div>

        <div class="coolraf-form-group">
            <label><?php _e('Sıcaklık Derecesi:', 'coolraf'); ?></label>
            <select name="temperature" class="coolraf-form-control">
                <option value="positive"><?php _e('Pozitif (+4°C)', 'coolraf'); ?></option>
                <option value="negative"><?php _e('Negatif (-18°C)', 'coolraf'); ?></option>
            </select>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Fiyat hesaplama mantığı
     */
    private function calculate_product_price($product_type, $motor_type, $temperature) {
        $base_price = 1000.00; // Temel fiyat

        switch ($product_type) {
            case 'cooling':
                $base_price += 500.00;
                if ($motor_type === 'internal') $base_price += 300.00;
                if ($temperature === 'negative') $base_price += 400.00;
                break;
            
            case 'initial':
                $base_price += 200.00;
                break;
        }

        return apply_filters('coolraf_price_calculation', $base_price, [
            'product_type' => $product_type,
            'motor_type' => $motor_type,
            'temperature' => $temperature
        ]);
    }
}