<?php

function drop_tables()
{
    global $wpdb;
    
    // remove hook drop if !get_option('spq_preserve_db_tables')
  
    $tables = $wpdb->prefix.'spq_quizes,';
    $tables .= $wpdb->prefix.'spq_questions,';
    $tables .= $wpdb->prefix.'spq_answers,';
    $tables .= $wpdb->prefix.'spq_marks,';
    $tables .= $wpdb->prefix.'spq_marks_types';
    
    $sql = "DROP TABLE IF EXISTS $tables";
    
    $wpdb->query($sql);
    
    delete_option('spq_db_version');
    delete_option('spq_preserve_db_tables');
}