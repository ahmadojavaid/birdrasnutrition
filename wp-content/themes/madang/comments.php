<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Madang
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>
    <div id="comments" class="comments">
        <div class="box-comments">
            <span class="note-comments text-regular">
                <?php printf( // WPCS: XSS OK.
                        esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s comments found', get_comments_number(), 'comments title', 'madang' ) ),
                        number_format_i18n( get_comments_number() ),
                        '<span>' . get_the_title() . '</span>'
                ); ?>
            </span>
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'madang' ); ?></h2>
                <div class="clearfix" ></div>
                <div class="nav-links">
                    <div class="nav-previous"><?php previous_comments_link( esc_html__( '← Older Comments', 'madang' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments →', 'madang' ) ); ?></div>
                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-above -->
            <?php endif; // Check for comment navigation. ?>
            <ol class="list-comments">
                <?php
                    wp_list_comments( array( 'callback' => 'madang_comment' ) );
                ?>
            </ol><!-- .comment-list -->
            <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
            <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'madang' ); ?></h2>
                <div class="clearfix" ></div>
                <div class="nav-links">
                    <div class="nav-previous"><?php previous_comments_link( esc_html__( '← Older Comments', 'madang' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments →', 'madang' ) ); ?></div>
                </div><!-- .nav-links -->
            </nav><!-- #comment-nav-below -->
            <?php endif; ?>
        </div>
    </div>
<?php endif; // Check for have_comments(). ?>

<div class="comments-area write-comments">
    <div class="box-comments">
        <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'madang' ); ?></p>
        <?php endif;
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        
        $fields =  array(
                         
             'author' =>
             '<p class="comment-form-author">' .
             ( $req ? '<span class="required"></span>' : '' ) .
             '<input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'madang' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
             '" size="30"' . $aria_req . ' /></p>',
             
             'email' =>
             '<p class="comment-form-email">' .
             ( $req ? '<span class="required"></span>' : '' ) .
             '<input id="email" name="email" type="text" placeholder="' . esc_html__( 'Email', 'madang' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) .
             '" size="30"' . $aria_req . ' /></p>',
             
             'url' =>
             '<p class="comment-form-url">' .
             '<input id="url" name="url" type="text" placeholder="' . esc_html__( 'Website', 'madang' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
             '" size="30" /></p>',
             );
     
        $args = array(
              'fields' => apply_filters('comment_form_default_fields', $fields),
              'class_submit' => 'bnt bnt-theme text-regular text-uppercase',
              'comment_field' => '<p class="comment-form-comment">' . '<textarea id="comment" name="comment" placeholder="'.esc_html__( 'Comment', 'madang' ).'" cols="45" rows="8" aria-required="true"></textarea>' . '</p>',
              'comment_notes_after' => '',
              'title_reply' => esc_html__( 'Write Comment', 'madang' )
              );
            
        comment_form( $args ); ?>
        <div class="clear"></div>
    </div>
</div><!-- #comments -->
