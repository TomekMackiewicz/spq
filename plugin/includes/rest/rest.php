<?php

function get_quiz($id) 
{
    global $wpdb;
    
    $table_name = $wpdb->prefix."spq_quizes";    
    $quiz = $wpdb->get_row("SELECT * FROM $table_name WHERE id=".$id);

    if (empty($quiz)) {
        return null;
    }
    
    $quiz->questions = unserialize($quiz->questions);
 
    return $quiz;
}

function get_quizes($orderBy, $order, $perPage, $currentPage, $search) 
{
    global $wpdb;

    $table_name = $wpdb->prefix."spq_quizes";
    
    if (!empty($search)) {
        $where = "WHERE title LIKE '%$search%'";
        $currentPage = 1;
    } else {
        $where = '';
    }
    $offset = ($currentPage-1) * $perPage;
    $count = $wpdb->get_row("SELECT COUNT(id) AS count FROM $table_name $where", ARRAY_N);
    $quizes = $wpdb->get_results("SELECT * FROM $table_name $where ORDER BY $orderBy $order LIMIT $perPage OFFSET $offset", ARRAY_A);
    
    if (empty($quizes)) {
        return null;
    }
 
    return ['quizes' => $quizes, 'count' => $count[0]];
}

function post_quiz($request)
{
    global $wpdb;
   
    $data = [
        'title'=>$request['quiz']['title'], 
        'description'=>$request['quiz']['description'],
        'summary'=>$request['quiz']['summary'],
        'duration'=>$request['quiz']['duration'],
        'next_submission_after'=>$request['quiz']['nextSubmissionAfter'],
        'time_active'=>$request['quiz']['timeActive'],
        'paginated'=>$request['quiz']['paginated'],
        'per_page'=>$request['quiz']['perPage'],
        //'marks_type'=>$request['quiz']['marks_type'],
        'shuffle_questions'=>$request['quiz']['shuffleQuestions'],
        'shuffle_answers'=>$request['quiz']['shuffleAnswers'],
        'immediate_answers'=>$request['quiz']['immediateAnswers'],
        'restrict_submissions'=>$request['quiz']['restrictSubmissions'],
        'allowed_submissions'=>$request['quiz']['allowedSubmissions'],
        'questions' => serialize($request['quiz']['questions']),
        'date_created' => date('Y-m-d H:i:s', time())
    ];
    
    //$table_name = $wpdb->prefix."spq_quizes";     
    $success = $wpdb->insert($wpdb->prefix."spq_quizes", $data);

    if (!$success) {
        return new WP_REST_Response('Error during save! Server said: '.$wpdb->last_error);       
    }
    
    return new WP_REST_Response(['id'=>$wpdb->insert_id, 'message'=>'Quiz saved']);    
}

function patch_quiz($request)
{
    global $wpdb;
    
    $data = [
        'id'=>$request['quiz']['id'],
        'title'=>$request['quiz']['title'], 
        'description'=>$request['quiz']['description'],
        'summary'=>$request['quiz']['summary'],
        'duration'=>$request['quiz']['duration'],
        'next_submission_after'=>$request['quiz']['nextSubmissionAfter'],
        'time_active'=>$request['quiz']['timeActive'],
        'paginated'=>$request['quiz']['paginated'],
        'per_page'=>$request['quiz']['perPage'],
        //'marks_type'=>$request['quiz']['marks_type'],
        'shuffle_questions'=>$request['quiz']['shuffleQuestions'],
        'shuffle_answers'=>$request['quiz']['shuffleAnswers'],
        'immediate_answers'=>$request['quiz']['immediateAnswers'],
        'restrict_submissions'=>$request['quiz']['restrictSubmissions'],
        'allowed_submissions'=>$request['quiz']['allowedSubmissions'],
        'questions' => serialize($request['quiz']['questions'])
        //'date_created' => date('Y-m-d H:i:s', time())
    ];
    
    $table_name = $wpdb->prefix."spq_quizes";
    $success = $wpdb->update($table_name, $data, ['id'=>$data['id']]);
    
    if (!$success) {
        return new WP_REST_Response('Error during update! Server said: '.$wpdb->last_error);        
    }

    return new WP_REST_Response('Quiz updated');    
}
