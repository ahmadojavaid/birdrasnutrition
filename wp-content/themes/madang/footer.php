<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Madang
 */

?>

<?php global $content_main; if ( $content_main ): ?>
        </div>
    </main>
<?php endif; ?>
</div>

    <div class="modal modal-search" tabindex="-1" role="dialog" aria-hidden="false" >
        <div class="container position-absolute position-center">
            <form class="modal-content position-relative form-search" action="<?php echo esc_url( home_url( '/' ) ) ?>" >
                <input type="text" class="form__input" name="s" placeholder="<?php esc_attr_e( 'New Search...', 'madang' ) ?>" />
                <input type="hidden" class="form__input" name="post_type" value="product" />
                <button type="submit" class="form__button position-absolute"><i class="flaticon flaticon-search"></i></button>
            </form>
        </div>
    </div>

    <div class="modal fade menu-pop-up" id="madangModal"> </div>
    <!-- ============== footer block starts ============== -->
    <footer>
        <div class="top-footer bgcolor">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 footer-logo">
                        <?php 
                        $imgurl = (get_theme_mod( 'madang_logo_footer', '' ));
                        if(empty($imgurl) || '' == $imgurl){

                            $imgurl = get_template_directory_uri() . '/images/madang-logo-white.svg';
                        } ?>
                        <figure>
                            <a class="img-responsive"  href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', '' ) ); ?>' rel='home'><img src='<?php echo esc_url( $imgurl ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', '' ) ); ?>'></a>
                        </figure>
                    </div>
                    <div class="col-xs-12 col-sm-2 footer-social-links footer-social-links-top pull-right">
                        <ul>
                            <?php if ( get_theme_mod( 'facebook' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'facebook' ) ). '"><i class="fa fa-facebook hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'twitter' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'twitter' ) ). '"><i class="fa fa-twitter hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'youtube' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'youtube' ) ). '"><i class="fa fa-youtube hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'linkedin' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'linkedin' ) ). '"><i class="fa fa-linkedin hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'pinterest' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'pinterest' ) ). '"><i class="fa fa-pinterest hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'google' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'google' ) ). '"><i class="fa fa-google hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'tumblr' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'tumblr' ) ). '"><i class="fa fa-tumblr hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'instagram' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'instagram' ) ). '"><i class="fa fa-instagram txcolor hvr-wobble-top" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'vimeo' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'vimeo' ) ). '"><i class="fa fa-vimeo hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'vk' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'vk' ) ). '"><i class="fa fa-vk hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'disqus' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'disqus' ) ). '"><i class="fa fa-disqus hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'kenzap' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'kenzap' ) ). '"><i class="fa fa-cloud hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-6 footer-menu">
                        <div class="row">
                            <?php if ( has_nav_menu( 'footer' ) ) {
                                    wp_nav_menu(array(
                                                      'theme_location' => 'footer',
                                                      'container'       => false,
                                                      'items_wrap'      => '%3$s',
                                                      'depth' => 2,
                                                      'walker' => new madang_footer_walker_nav_menu
                                                      ));
                            } ?>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 footer-social-links footer-social-links-bottom pull-right">
                        <ul>
                           <?php if ( get_theme_mod( 'facebook' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'facebook' ) ). '"><i class="fa fa-facebook hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'twitter' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'twitter' ) ). '"><i class="fa fa-twitter hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'youtube' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'youtube' ) ). '"><i class="fa fa-youtube hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'linkedin' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'linkedin' ) ). '"><i class="fa fa-linkedin hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'pinterest' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'pinterest' ) ). '"><i class="fa fa-pinterest hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'google' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'google' ) ). '"><i class="fa fa-google hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'tumblr' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'tumblr' ) ). '"><i class="fa fa-tumblr hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'instagram' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'instagram' ) ). '"><i class="fa fa-instagram hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'vimeo' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'vimeo' ) ). '"><i class="fa fa-vimeo hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'vk' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'vk' ) ). '"><i class="fa fa-vk hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'disqus' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'disqus' ) ). '"><i class="fa fa-disqus hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                            <?php if ( get_theme_mod( 'kenzap' ) ){ echo '<li><a href="' .esc_url( get_theme_mod( 'kenzap' ) ). '"><i class="fa fa-cloud hvr-wobble-top txcolor" aria-hidden="true"></i></a></li>'; } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="bottom-footer">
            <div class="container">
                <div class="copyright-text text-center"><?php echo esc_attr( get_theme_mod( 'madang_footnote',  '&copy; 2017-2019 Madang, Inc. ALL RIGHT RESERVED.' ) ); ?></div>
            </div>
        </div>
    </footer>
    <!-- ============== footer block starts ============== -->
<?php wp_footer(); ?>
</body>
</html>
