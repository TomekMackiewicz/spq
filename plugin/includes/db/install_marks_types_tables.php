<?php

function install_marks_types_tables()
{
    global $wpdb, $db_version;
   
    $table_name = $wpdb->prefix."spq_marks_types";
    $charset_collate = $wpdb->get_charset_collate();

    if (get_option("db_version") != $db_version) {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";       
    } else {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
    }

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);   
}