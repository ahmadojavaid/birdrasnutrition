<?php 
$image_url = "";
if ( $instance['img1'] != '' ){
    $image_url1 = wp_get_attachment_image_src($instance['img1'],"madang-aboutus-small",false);
}
if ( $instance['img1'] != '' ){
    $image_url1_full = wp_get_attachment_image_src($instance['img1'],"full",false);
}
if ( $instance['img2'] != '' ){
    $image_url2 = wp_get_attachment_image_src($instance['img2'],"madang-aboutus-small",false);
}
if ( $instance['img2'] != '' ){
    $image_url2_full = wp_get_attachment_image_src($instance['img2'],"full",false);
}
if ( $instance['img3'] != '' ){
    $image_url3 = wp_get_attachment_image_src($instance['img3'],"madang-aboutus-small",false);
}
if ( $instance['img3'] != '' ){
    $image_url3_full = wp_get_attachment_image_src($instance['img3'],"full",false);
}
if ( $instance['img4'] != '' ){
    $image_url4 = wp_get_attachment_image_src($instance['img4'],"madang-aboutus-small",false);
}
if ( $instance['img4'] != '' ){
    $image_url4_full = wp_get_attachment_image_src($instance['img4'],"full",false);
}
if ( $instance['img5'] != '' ){
    $image_url5 = wp_get_attachment_image_src($instance['img5'],"madang-aboutus-large",false);
}
if ( $instance['img5'] != '' ){
    $image_url5_full = wp_get_attachment_image_src($instance['img5'],"full",false);
}

?>
<!-- ============== About us starts ============== -->
<section class="block about-us-block">
    <div class="container">
        <!-- == whole about us content wrap starts == -->
        <div class="about-us-content">
            <div class="text-center top-description wow fadeInUp">
                <h2 class="text-sp text-lt"><?php echo madang_output_html( $instance['title'] ); ?></h2>
                <p><?php echo madang_output_html( $instance['text'] ); ?></p>
            </div>

            <!-- About us image grid block starts -->
            <div class="row image-grid-row">
                <div class="col-xs-12 col-sm-7 small-image-group wow fadeInLeft">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 small-image-wrap wow fadeInUp">
                            <figure><a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image_url1_full[0] ); ?>" ><img class="img-responsive" src="<?php echo esc_url( $image_url1[0] ); ?>" alt="About Image 1" /></a></figure>
                        </div>
                        <div class="col-xs-6 col-sm-6 small-image-wrap wow fadeInUp">
                            <figure><a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image_url2_full[0] ); ?>" ><img class="img-responsive" src="<?php echo esc_url( $image_url2[0] ); ?>" alt="About Image 2" /></a></figure>
                        </div>
                        <div class="col-xs-6 col-sm-6 small-image-wrap wow fadeInUp">
                            <figure><a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image_url3_full[0]); ?>" ><img class="img-responsive" src="<?php echo esc_url( $image_url3[0] ); ?>" alt="About Image 3" /></a></figure>
                        </div>
                        <div class="col-xs-6 col-sm-6 small-image-wrap wow fadeInUp">
                            <figure><a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image_url4_full[0] ); ?>" ><img class="img-responsive" src="<?php echo esc_url( $image_url4[0] ); ?>" alt="About Image 4" /></a></figure>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 big-image wow fadeInRight">
                    <figure><a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image_url5_full[0] ); ?>" ><img class="img-responsive" src="<?php echo esc_url( $image_url5[0] ); ?>" alt="About image" /></a></figure>
                </div>
            </div>
            <!-- About us image gallery block ends -->

            <!-- 2 columns paragraph starts -->
            <article class="wow fadeInUp">
                <p><?php echo madang_output_html( $instance['text_left'] ); ?></p>
                <p><?php echo madang_output_html( $instance['text_right'] ); ?></p>
            </article>

            <div class="text-center center-btn wow flipInX">
                <a href="<?php echo esc_url( $instance['button_url'] ); ?>" class="btn border-btn-x-big hvr-wobble-horizontal brcolor bghcolor brhcolor"><?php echo esc_attr( $instance['button_text'] ); ?></a>
            </div>
            <!-- 2 columns paragraph ends -->

        </div>
        <!-- == whole about us content wrap starts == -->
    </div>

    <?php echo madang_fix_shortcode( $content ); ?>

</section>