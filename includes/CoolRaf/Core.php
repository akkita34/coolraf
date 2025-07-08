<?php
namespace CoolRaf;

class Core {
    public function __construct() {
        register_activation_hook(__FILE__, [$this, 'activate']);
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function activate() {
        Database::create_tables();
    }

    public function init() {
        // Çoklu dil desteği
        load_plugin_textdomain('coolraf', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
	
	    }

    public function apply_discounts($price, $args) {
        if ($args['product_type'] === 'cooling') {
            return $price * 0.95; // %5 indirim
        }
        return $price;
    }
}