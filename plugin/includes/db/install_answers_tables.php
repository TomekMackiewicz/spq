<?php

function install_answers_tables()
{
    global $wpdb, $db_version;
   
    $table_name = $wpdb->prefix."spq_answers";
    $questions_table_name = $wpdb->prefix."spq_questions";
    $charset_collate = $wpdb->get_charset_collate();

    if (get_option("db_version") != $db_version) {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          description text,
          type smallint,
          hint text,
          is_obligatory boolean,
          question_id mediumint,
          PRIMARY KEY  (id),
          FOREIGN KEY (quiz_id) REFERENCES $questions_table_name(id)
        ) $charset_collate;";       
    } else {
        $sql = "CREATE TABLE $table_name (
          id mediumint NOT NULL AUTO_INCREMENT,          
          label varchar(255) NOT NULL,
          description text,
          type smallint,
          hint text,
          is_obligatory boolean,
          question_id mediumint,
          PRIMARY KEY  (id),
          FOREIGN KEY (quiz_id) REFERENCES $questions_table_name(id)
        ) $charset_collate;";
    }

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);    
}
