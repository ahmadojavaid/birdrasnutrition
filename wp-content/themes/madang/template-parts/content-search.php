<?php
/**
 * Template part for displaying results in search pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( get_the_title() ) : ?>
    <h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
    <div class="post__meta">
        <ul class="post__meta-list post__meta-list_inline">
            <li class="post__meta-item post__meta-date"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo esc_html( get_the_date() ); ?></li>
            <li class="post__meta-item post__meta-author"><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e('By:', 'madang' ); ?> <?php echo esc_html( get_the_author() ); ?></li>
            <?php if( get_the_category() ) : ?>
            <li class="post__meta-item post__meta-category"><i class="fa fa-tag" aria-hidden="true"></i><?php esc_html_e('Category:', 'madang' ); ?> <?php echo wp_kses( get_the_category_list(', '), array( 'a' => array( 'href' => array(), 'rel' => array() ) ) ); ?></li>
            <?php endif; ?>
            <li class="post__meta-item post__meta-comments"><i class="fa fa-comments" aria-hidden="true"></i><?php esc_html_e('Comments', 'madang' ); ?>: <?php comments_number( '0', '1' , '%' ); ?></li>
        </ul>
    </div>
    <?php endif; ?>
</article>