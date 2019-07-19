<div class="wrap">
    <h2><?php echo __('List of quizes', 'menu-test') ?></h2>
    <form method="post">
        <input type="hidden" name="page" value="<?php echo filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?>" />
        <?php $quizListTable->search_box('search', 'search_id'); ?>
    </form>
    <form id="events-filter" method="get">
        <input type="hidden" name="page" value="<?php echo filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?>" />
        <?php $quizListTable->display(); ?>
    </form>
</div>
