<div class="wrap">
    <?php echo "<h2>" . __( 'Quiz Plugin Settings', 'quiz-options-menu' ) . "</h2>" ?>
    <form name="form1" method="post" action="">
        <input type="hidden" name="mt_submit_hidden" value="Y">
        <p><?php _e("Favorite Color:", 'quiz-options-menu' ); ?> 
            <input type="text" name="mt_favorite_color" value="<?php echo get_option('mt_favorite_color') ?>" size="20">
        </p>
        <hr />
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>
    </form>
</div>
