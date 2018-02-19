<?php
$title_tag = isset($quote_tag) ? $quote_tag : 'h2';
$quote_text_meta = get_post_meta(get_the_ID(), "quote_format", true );

$post_title = !empty($quote_text_meta) ? $quote_text_meta : get_the_title();
?>

<div class="qode-post-quote-holder">
    <div class="qode-post-quote-holder-inner">
        <<?php echo esc_attr($title_tag);?> itemprop="name" class="qode-quote-title qode-post-title">
        <?php if(qode_news_blog_item_has_link()) { ?>
            <a itemprop="url" href="<?php echo get_the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
        <?php } ?>
            <?php echo esc_html($post_title); ?>
        <?php if(qode_news_blog_item_has_link()) { ?>
            </a>
        <?php } ?>
        </<?php echo esc_attr($title_tag);?>>
    </div>
</div>