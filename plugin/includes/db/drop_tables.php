<?php

function drop_tables()
{
    global $wpdb;
  
    $tables = $wpdb->prefix.'spq_quizes';
    $tables .= $wpdb->prefix.'spq_questions';
    $tables .= $wpdb->prefix.'spq_answers';
    $tables .= $wpdb->prefix.'spq_marks';
    $tables .= $wpdb->prefix.'spq_marks_types';
var_dump($sql);    
    $sql = "DROP TABLE IF EXISTS $tables";
    $wpdb->query($sql);
    
    delete_option('spq_db_version');     
}