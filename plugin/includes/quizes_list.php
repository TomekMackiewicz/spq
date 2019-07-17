<?php

class My_List_Table extends WP_List_Table 
{
    function get_columns()
    {
        $columns = [
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
        $orderBy = filter_input(INPUT_GET, 'orderby');
        $order = filter_input(INPUT_GET, 'order');
        $quizes = get_quizes($orderBy, $order);
        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];
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
}

$myListTable = new My_List_Table();

?>

<div class="wrap">
<?php 
    
    echo "<h2>" . __('List of quizes', 'menu-test') . "</h2>";

    $myListTable->prepare_items(); 
    $myListTable->display(); 

?>
</div>