<?php

/*
Plugin Name:  S.P.Q
Plugin URI:   https://example.com/plugins/the-basics/
Description:  Survey Poll Quiz Plugin
Version:      1.0
Author:       Tomasz Mackiewicz
Author URI:   https://author.example.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:  spq
Domain Path:  /languages

S.P.Q is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.
S.P.Q is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with S.P.Q. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

defined('ABSPATH') or die('No script kiddies please!');

global $db_version;
$db_version = '1.0';

require_once('includes/rest/rest.php');
require_once('includes/db/install_tables.php');
require_once('includes/db/drop_tables.php');

register_activation_hook(__FILE__, 'install_tables');

//register_uninstall_hook('includes/db/drop_tables.php', 'drop_tables');
register_deactivation_hook(__FILE__, 'drop_tables');

add_action('admin_menu', 'quiz_plugin_menu');
add_action('admin_enqueue_scripts', 'add_scripts');

add_action('rest_api_init', function() {
    register_rest_route('quiz/v1', '/quiz/(?P<id>\d+)', [
        'methods' => 'GET',
        'callback' => 'get_quiz',
    ]);
    register_rest_route('quiz/v1', '/quiz/', [
        'methods' => 'GET',
        'callback' => 'get_quizes',
    ]);
    register_rest_route('quiz/v1', '/quiz/', [
        'methods' => 'POST',
        'callback' => 'post_quiz',
    ]); 
    register_rest_route('quiz/v1', '/quiz/(?P<id>\d+)', [
        'methods' => 'PATCH',
        'callback' => 'patch_quiz',
    ]);  
});

add_filter('set-screen-option', 'quiz_table_set_option', 10, 3);

function spq_shortcode($atts) {
    add_action( 'wp_head', 'append_href' );
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js', [], null, true);
    wp_enqueue_script('spq', plugin_dir_url(__FILE__).'includes/scripts/spq.js', [], null, true);
    
    $keys = array_keys($atts);
    if (count($keys) !== 1) {
        wp_die(__('Invalid number of shortcode attributes.'));
    }
    if ($keys[0] !== 'id') {
        wp_die(__('Invalid shortcode attribute name.'));
    }
    if (!is_numeric($atts['id'])) {
        wp_die(__('Only numeric values are allowed.'));
    }
    
    $quiz = get_quiz($atts['id']);
    
    if (!$quiz) {
        return __('No quiz for given ID.');
    }

    require_once('includes/lib/QuizForm.php');
    require_once('includes/quiz_front.php');
}

function add_scripts($hook) 
{
    wp_register_style('spq-styles', plugin_dir_url(__FILE__).'includes/css/styles.css');
    wp_enqueue_style('spq-styles');    
    wp_register_style('font-awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css');
    wp_enqueue_style('font-awesome');
    wp_enqueue_script('scripts', plugin_dir_url(__FILE__).'includes/js/scripts.js', [], null, true);
}

function quiz_plugin_menu() 
{
    add_menu_page( 'Quiz Plugin', 'Quiz Plugin', 'manage_options', 'quiz-plugin', 'quiz_plugin_options');
    add_submenu_page( 'quiz-plugin', 'Quiz Plugin Options', 'Quiz Plugin Options', 'manage_options', 'quiz-plugin-options', 'quiz_plugin_options');
    add_submenu_page( 'quiz-plugin', 'New Quiz', 'New Quiz', 'manage_options', 'new-quiz', 'add_new_quiz');
    $hook = add_submenu_page( 'quiz-plugin', 'Quizes', 'Quizes', 'manage_options', 'quizes', 'list_of_quizes');
    add_action( "load-$hook", 'add_options' );
}

function quiz_plugin_options() 
{
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
 
    $mt_submit_hidden = filter_input(INPUT_POST, 'mt_submit_hidden', FILTER_SANITIZE_STRING);    

    if(isset($mt_submit_hidden) && $mt_submit_hidden == 'Y') {
        $opt_val = filter_input(INPUT_POST, 'spq_preserve_db_tables', FILTER_SANITIZE_STRING);
        update_option('spq_preserve_db_tables', $opt_val);
        
        require_once('includes/settings_alert.php');
    }

    require_once('includes/options_form.php');   
}

function add_new_quiz()
{
    if (!current_user_can('manage_options'))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    } 
    
    require_once('includes/new_quiz.php');
}

function list_of_quizes()
{
    global $quizListTable;

    if (!current_user_can('manage_options'))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    if (!class_exists('Quiz_List_Table')) {
        require_once('includes/lib/quiz-list-table.php');
    }
    $quizListTable->prepare_items();
    require_once('includes/quizes_list.php');
}

function add_options() 
{
    global $quizListTable;
    
    if (!class_exists('Quiz_List_Table')) {
        require_once('includes/lib/quiz-list-table.php');
    }

    $option = 'per_page';
    $args = array(
           'label' => 'Quizes',
           'default' => 10,
           'option' => 'quizes_per_page'
           );
    add_screen_option( $option, $args );

    $quizListTable = new Quiz_List_Table;
}

function quiz_table_set_option($status, $option, $value) {
    return $value;
}