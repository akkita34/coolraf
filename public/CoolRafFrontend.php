<?php
namespace CoolRaf;

class Frontend {
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_shortcode('coolraf_configurator', [$this, 'render_configurator']);
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'coolraf-frontend',
            COOLRAF_PLUGIN_URL . 'public/assets/css/frontend.css',
            [],
            COOLRAF_VERSION
        );
        
        wp_enqueue_script(
            'coolraf-frontend',
            COOLRAF_PLUGIN_URL . 'public/assets/js/frontend.js',
            ['jquery'],
            COOLRAF_VERSION,
            true
        );
    }

    public function render_configurator() {
        ob_start();
        include COOLRAF_PLUGIN_DIR . 'public/shortcodes/configurator.php';
        return ob_get_clean();
    }
}