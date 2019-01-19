<?php 
    $checked = get_option('spq_preserve_db_tables') ? "checked" : "";
?>

<div class="wrap">
    <?php echo "<h1>" . __( 'Quiz Plugin Settings', 'quiz-options-menu' ) . "</h1>" ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="mt_submit_hidden" value="Y">
            <input name="spq_preserve_db_tables" id="spq_preserve_db_tables" type="checkbox" <?php echo $checked ?>>
            <label for="spq_preserve_db_tables">Preserve db tables</label>
        <hr />
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>
    </form>
</div>
