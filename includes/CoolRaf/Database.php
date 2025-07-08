<?php
namespace CoolRaf;

class Database {
    public static function create_tables() {
        global $wpdb;
        
        $charset = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE {$wpdb->prefix}coolraf_configs (
            config_id BIGINT NOT NULL AUTO_INCREMENT,
            product_type VARCHAR(50) NOT NULL,
            motor_type VARCHAR(50) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            PRIMARY KEY (config_id)
        ) $charset;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }
}