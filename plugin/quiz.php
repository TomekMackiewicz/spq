<?php

/*
Plugin Name:  Quiz
Plugin URI:   https://example.com/plugins/the-basics/
Description:  Tompo Quiz Plugin
Version:      20160911
Author:       WordPress.org
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
require_once('includes/rest/enqueue_scripts.php');

register_activation_hook(__FILE__, 'install_quiz_tables');

add_action('admin_menu', 'quiz_plugin_menu');
add_action('admin_head', 'append_base_href');
//add_action('plugins_loaded', 'update_db_check');
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
        $opt_val = filter_input(INPUT_POST, 'mt_favorite_color');
        update_option('mt_favorite_color', $opt_val);
        
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

function install_quiz_tables()
{
    global $wpdb, $db_version;
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
   
    $table_name = $wpdb->prefix."quiz";   
    $charset_collate = $wpdb->get_charset_collate();

    if (get_option("db_version") != $db_version) {
        $sql = "CREATE TABLE $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
          name varchar(255) NOT NULL,
          description text NOT NULL,
          PRIMARY KEY (id)
        ) $charset_collate;";

        dbDelta($sql);

        update_option("db_version", $db_version);
        
        return;
    }    
    
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      name varchar(255) NOT NULL,
      description text NOT NULL,
      dupa boolean,
      PRIMARY KEY (id)
    ) $charset_collate;";

    //require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta($sql);
    
    add_option('db_version', $db_version);   
}

// remove hook drop

function update_db_check() 
{    
    global $db_version;
    
    if (get_option('db_version') != $db_version) {
        install_quiz_tables();
    }
}
