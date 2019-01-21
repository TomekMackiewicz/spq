<?php

/*
Plugin Name:  Quiz
Plugin URI:   https://example.com/plugins/the-basics/
Description:  Tompo Quiz Plugin
Version:      1.0
Author:       Tompo
Author URI:   https://author.example.com/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wporg
Domain Path:  /languages

{Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
*/

defined('ABSPATH') or die('No script kiddies please!');

$db_version = '1.0';

require_once('includes/rest/rest.php');

require_once('includes/db/install_quizes_tables.php');
require_once('includes/db/install_questions_tables.php');
require_once('includes/db/install_answers_tables.php');
require_once('includes/db/install_marks_tables.php');
require_once('includes/db/install_marks_types_tables.php');
require_once('includes/db/drop_tables.php');

register_activation_hook('includes/db/install_quizes_tables.php', 'install_quizes_tables');
register_activation_hook('includes/db/install_questions_tables.php', 'install_questions_tables');
register_activation_hook('includes/db/install_answers_tables.php', 'install_answers_tables');
register_activation_hook('includes/db/install_marks_tables.php', 'install_marks_tables');
register_activation_hook('includes/db/install_marks_types_tables.php', 'install_marks_types_tables');
register_activation_hook(__FILE__, 'add_db_version_option');

register_uninstall_hook('includes/db/drop_tables.php', 'drop_tables');

add_action('admin_menu', 'quiz_plugin_menu');
add_action('admin_head', 'append_base_href');
add_action('plugins_loaded', 'update_db_check');
add_action('admin_enqueue_scripts', 'add_angular_scripts');

add_action('rest_api_init', function() {
  register_rest_route('quiz/v1', '/quiz/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'get_quiz',
  ));
  register_rest_route('quiz/v1', '/quiz/', array(
    'methods' => 'GET',
    'callback' => 'get_quizes',
  ));
  register_rest_route('quiz/v1', '/quiz/', array(
    'methods' => 'POST',
    'callback' => 'post_quiz',
  )); 
  register_rest_route('quiz/v1', '/quiz/', array(
    'methods' => 'PATCH',
    'callback' => 'patch_quiz',
  ));  
});

function add_angular_scripts($hook) {
//    if ('edit.php' != $hook) {
//        return;
//    }

    //wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
    //wp_enqueue_style('bootstrap');
    wp_register_style('spq-styles', plugin_dir_url(__FILE__).'dist/styles.css');
    wp_enqueue_style('spq-styles');    
    wp_register_style('font-awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css');
    wp_enqueue_style('font-awesome');
    
    wp_enqueue_script('runtime', plugin_dir_url(__FILE__).'dist/runtime.js', array(), null, true);
    wp_enqueue_script('polyfills', plugin_dir_url(__FILE__).'dist/polyfills.js', array(), null, true);
    wp_enqueue_script('main', plugin_dir_url(__FILE__).'dist/main.js', array(), null, true);
    
    //wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), null, true);
    //wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), null, true);
    //wp_enqueue_script('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array(), null, true);
}

function append_base_href()
{
    echo '<base href="/wp/wp-admin/admin.php?">';
}

function quiz_plugin_menu() {
    add_menu_page( 'Quiz Plugin', 'Quiz Plugin', 'manage_options', 'quiz-plugin', 'quiz_plugin_options');
    add_submenu_page( 'quiz-plugin', 'Quiz Plugin Options', 'Quiz Plugin Options', 'manage_options', 'quiz-plugin-options', 'quiz_plugin_options');
    add_submenu_page( 'quiz-plugin', 'New Quiz', 'New Quiz', 'manage_options', 'new-quiz', 'add_new_quiz');
    add_submenu_page( 'quiz-plugin', 'Quizes', 'Quizes', 'manage_options', 'quizes', 'list_of_quizes');
}

function quiz_plugin_options() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
 
    $mt_submit_hidden = filter_input(INPUT_POST, 'mt_submit_hidden');    

    if(isset($mt_submit_hidden) && $mt_submit_hidden == 'Y') {
        $opt_val = filter_input(INPUT_POST, 'spq_preserve_db_tables');
        update_option('spq_preserve_db_tables', $opt_val);
        
        require_once('includes/settings_alert.php');
    }

    require_once('includes/options_form.php');   
}

function add_new_quiz()
{
    if (!current_user_can( 'manage_options'))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }
    
    echo "<app-root></app-root>";
}

function list_of_quizes()
{
    if (!current_user_can( 'manage_options'))  {
        wp_die(__('You do not have sufficient permissions to access this page.'));
    }

    require_once('includes/quizes_list.php');
}

// remove hook drop if !get_option('spq_preserve_db_tables')

function update_db_check() 
{    
    global $db_version;
    
    if (get_option('db_version') != $db_version) {
        install_quizes_tables();
    }
}

function add_db_version_option()
{
    global $db_version;
    
    add_option('db_version', $db_version);
}