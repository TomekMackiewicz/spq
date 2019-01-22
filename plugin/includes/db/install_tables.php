<?php

function install_tables()
{
    global $wpdb, $db_version;
        
    $sql = [];
    $quizes_table_name = $wpdb->prefix."spq_quizes";
    $marks_types_table_name = $wpdb->prefix."spq_marks_types";
    $marks_table_name = $wpdb->prefix."spq_marks";
    $charset_collate = $wpdb->get_charset_collate();

    if ($wpdb->get_var("show tables like '".$quizes_table_name."'") !== $quizes_table_name) {
        $sql[] = "CREATE TABLE $quizes_table_name (
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
          shuffle_questions boolean,
          shuffle_answers boolean,
          immediate_answers boolean,
          restrict_submissions boolean,
          allowed_submissions tinyint,
          questions text,
          date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";
    } elseif (get_option("spq_db_version") != $db_version) {
        // ALTER TABLE...
    } 

    if ($wpdb->get_var("show tables like '".$marks_types_table_name."'") !== $marks_types_table_name) {
        $sql[] = "CREATE TABLE $marks_types_table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";       
    } elseif (get_option("spq_db_version") != $db_version) {
        // ALTER TABLE...
    } 

    if ($wpdb->get_var("show tables like '".$marks_table_name."'") !== $marks_table_name) {
        $sql[] = "CREATE TABLE $marks_table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          percentage tinyint(2),
          mark_type_id mediumint,
          PRIMARY KEY  (id),
          FOREIGN KEY  (mark_type_id) REFERENCES $marks_types_table_name(id)
        ) $charset_collate;";       
    } elseif (get_option("spq_db_version") != $db_version) {
        // ALTER TABLE...
    } 
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);

    update_option('spq_db_version', $db_version);
    update_option('spq_preserve_db_tables', true);    
}
