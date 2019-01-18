<?php

function get_quiz($data) 
{
    global $wpdb;
    
    $table_name = $wpdb->prefix."quiz";    
    $quiz = $wpdb->get_results("SELECT * FROM $table_name WHERE id=".$data['id']);

    if (empty($quiz)) {
        return null;
    }
 
    return $quiz;
}

function get_quizes($data) 
{
    global $wpdb;
    
    $table_name = $wpdb->prefix."quiz";    
    $quizes = $wpdb->get_results("SELECT * FROM $table_name");

    if (empty($quizes)) {
        return null;
    }
 
    return $quizes;
}

function post_quiz($request)
{
    global $wpdb;
    
    $data = [
        'name'=>$request['quiz']['title'], 
        'description'=>$request['quiz']['description']
    ];
    
    $table_name = $wpdb->prefix."quiz";     
    $success = $wpdb->insert($table_name, $data);
    
    if ($success) {
        $response = ['id'=>$wpdb->insert_id, 'message'=>'Quiz saved'];
        return new WP_REST_Response($response);
    } else {        
        return new WP_REST_Response('Error during save! Server said: '.$wpdb->last_error);
    }
}

function patch_quiz($request)
{
    global $wpdb;
    
    $data = [
        'id'=>$request['quiz']['id'],
        'name'=>$request['quiz']['title'], 
        'description'=>$request['quiz']['description']
    ];
    
    $table_name = $wpdb->prefix."quiz";
    $success = $wpdb->update($table_name, $data, ['id'=>$data['id']]);
    
    if ($success) {
        return new WP_REST_Response('Quiz updated');
    } else {
        return new WP_REST_Response('Error during update! Server said: '.$wpdb->last_error);
    }    
}