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
        $orderBy = $_GET['orderby'] ? filter_input(INPUT_GET, 'orderby') : 'title';
        $order = $_GET['order'] ? filter_input(INPUT_GET, 'order') : 'asc';
        $perPage = $this->get_items_per_page('quizes_per_page', 5);
        $currentPage = $this->get_pagenum();
        $search = filter_input(INPUT_POST, 's');
        
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
                return print_r($item, true) ; //Show the whole array for troubleshooting purposes
        }
    }
    
    // Actions for single quiz
    // TODO: implement edit / delete $_GET['action'], $_GET['quiz']
    function column_title($item)
    {
        $actions = [
            'edit' => sprintf('<a href="?page=%s&action=%s&quiz=%s">Edit</a>', $_REQUEST['page'], 'edit', $item['id']),
            'delete' => sprintf('<a href="?page=%s&action=%s&quiz=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
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

    // Checkbox for bulk actions
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="quiz[]" value="%s" />', $item['id']
        );
    }
}