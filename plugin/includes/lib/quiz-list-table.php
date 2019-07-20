<?php

require_once('class-wp-list-table.php');

class Quiz_List_Table extends WP_List_Table 
{
    function get_columns()
    {
        $columns = [
            'cb' => '<input type="checkbox" />',
            'title' => 'Title',
            'description' => 'Description',
            'summary' => 'Summary',
            'duration' => 'Duration'
        ];

        return $columns;
    }
    
    function get_sortable_columns() 
    {
        $sortable_columns = [
            'title'  => ['title', false]
        ];

        return $sortable_columns;
    }

    function prepare_items()
    {
        $this->process_action(); // Edit / delete
        $orderBy = isset($_GET['orderby']) ? filter_input(INPUT_GET, 'orderby', FILTER_SANITIZE_STRING) : 'title';
        $order = isset($_GET['order']) ? filter_input(INPUT_GET, 'order', FILTER_SANITIZE_STRING) : 'asc';
        $perPage = $this->get_items_per_page('quizes_per_page', 5);
        $currentPage = $this->get_pagenum();
        $search = filter_input(INPUT_POST, 's', FILTER_SANITIZE_STRING);
        
        $result = get_quizes($orderBy, $order, $perPage, $currentPage, $search);
        $quizes = $result['quizes'];
        $total_items = $result['count'];

        $this->_column_headers = $this->get_column_info();

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $perPage
        ]);

        $this->items = $quizes;
    }

    function column_default($item, $column_name)
    {
        switch($column_name) { 
            case 'title':
            case 'description':
            case 'summary':
            case 'duration':
                return $item[$column_name];
            default:
                return print_r($item, true);
        }
    }
    
    // Actions for single quiz
    // TODO: implement edit / delete $_GET['action'], $_GET['quiz']
    function column_title($item)
    {
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);
        $actions = [
            'edit' => sprintf(
                '<a href="?page=%s&action=%s&quiz=%s">Edit</a>', 
                $page, 'edit', $item['id']
            ),
            'delete' => sprintf(
                '<a href="?page=%s&action=%s&quiz=%s">Delete</a>', 
                $page, 'delete', $item['id']
            )
        ];

        return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
    }
    
    // Bulk actions
    // TODO: implement $_GET['action'], $_GET['quiz']
    function get_bulk_actions()
    {
        $actions = [
          'delete' => 'Delete'
        ];

        return $actions;
    }

    public function process_action() 
    {
        global $wpdb;

        if (isset($_POST['_wpnonce']) && !empty($_POST['_wpnonce'])) {
            $nonce  = filter_input(INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING);
            $action = 'bulk-' . $this->_args['plural'];

            if (!wp_verify_nonce($nonce, $action)) {
                wp_die('Security check failed.');
            }
        }

        $action = $this->current_action();

        switch ($action) {
            case 'delete':
                $table_name = $wpdb->prefix.'spq_quizes';
                $ids = isset($_GET['quiz']) ? $_GET['quiz'] : [];
                if (is_array($ids)) {
                    $ids = implode(',', $ids);
                }
                if (!empty($ids)) {
                    $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
                }
                break;            
            case 'edit':
                wp_die( 'Edit something' );
                break;
            default:
                return;
        }

        return;
    }

    // Checkbox for bulk actions
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="quiz[]" value="%s" />', $item['id']
        );
    }
    
    function no_items()
    {
        _e( 'No quizes found. Go on, add some' );
    }
}