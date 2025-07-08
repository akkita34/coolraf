<?php
namespace CoolRaf;

class Admin {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'CoolRaf Ayarları',
            'CoolRaf',
            'manage_options',
            'coolraf-settings',
            [$this, 'render_settings_page'],
            'dashicons-admin-generic',
            80
        );
    }
    
    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>CoolRaf Ayarları</h1>
            <p>Ticari soğutma sistemleri konfigüratör ayarları</p>
        </div>
        <?php
    }
}