<?php if(qode_options()->getOptionValue('enable_social_share') === 'yes' && qode_options()->getOptionValue('post_types_names_post') === 'post') { ?>
    <div class="qode-blog-share">
        <h5 class="qode-share-title"><?php esc_html_e('Share:','qode-news') ?></h5>
        <?php echo do_shortcode('[social_share_list]'); ?>
    </div>
<?php } ?>