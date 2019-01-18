<?php

function add_angular_scripts($hook) {
//    if ('edit.php' != $hook) {
//        return;
//    }

    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');
    wp_register_style('font-awesome', 'https://use.fontawesome.com/releases/v5.6.1/css/all.css');
    wp_enqueue_style('font-awesome');
    
    wp_enqueue_script('runtime', plugin_dir_url(__FILE__).'dist/runtime.js', array(), null, true);
    wp_enqueue_script('polyfills', plugin_dir_url(__FILE__).'dist/polyfills.js', array(), null, true);
    wp_enqueue_script('main', plugin_dir_url(__FILE__).'dist/main.js', array(), null, true);
    
    wp_enqueue_script('jquery', plugin_dir_url(__FILE__).'https://code.jquery.com/jquery-3.3.1.slim.min.js', array(), null, true);
    wp_enqueue_script('popper', plugin_dir_url(__FILE__).'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array(), null, true);
    wp_enqueue_script('bootstrap', plugin_dir_url(__FILE__).'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', array(), null, true);
}

function append_base_href()
{
    echo '<base href="/wp/wp-admin/admin.php?">';
}