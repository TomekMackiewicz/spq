<?php

function install_quizes_tables()
{
    global $wpdb, $db_version;
   
    $table_name = $wpdb->prefix."spq_quizes";   
    $charset_collate = $wpdb->get_charset_collate();

    if (get_option("db_version") != $db_version) {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          title varchar(255) NOT NULL,
          description text,
          summary text,
          duration int,
          next_submission_after int,
          time_active int,
          paginated boolean,
          per_page tinyint,
          marks_type tinyint,
          random_questions boolean,
          random_answers boolean,
          immediate_answers boolean,
          restrict_submissions boolean,
          allowed_submissions tinyint,
          created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
    } else {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          title varchar(255) NOT NULL,
          description text,
          summary text,
          duration int,
          next_submission_after int,
          time_active int,
          paginated boolean,
          per_page tinyint,
          marks_type tinyint,
          random_questions boolean,
          random_answers boolean,
          immediate_answers boolean,
          restrict_submissions boolean,
          allowed_submissions tinyint,
          created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
    }
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);    
}
