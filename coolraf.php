<?php
/**
 * Plugin Name: CoolRaf
 * Description: Ticari soğutma sistemleri için akıllı teklif konfigüratörü
 * Version: 1.0.0
 * Author: Uğur KÖSEOĞLU
 */

defined('ABSPATH') || exit;

// Sabitler
define('COOLRAF_VERSION', '1.0.0');
define('COOLRAF_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('COOLRAF_PLUGIN_URL', plugin_dir_url(__FILE__));

// Otomatik Yükleme
spl_autoload_register(function ($class) {
    if (strpos($class, 'CoolRaf\\') === 0) {
        $file = COOLRAF_PLUGIN_DIR . str_replace('\\', '/', substr($class, 8)) . '.php';
        if (file_exists($file)) require $file;
    }
});

// Çekirdek Sistem
new CoolRaf\Core();

// AJAX İşlemleri
if (defined('DOING_AJAX') && DOING_AJAX) {
    new CoolRaf\Ajax();
}

// Admin Arayüzü
if (is_admin()) {
    new CoolRaf\Admin();
}

// Frontend
new CoolRaf\Frontend();