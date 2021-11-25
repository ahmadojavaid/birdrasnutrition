<?php

function madang_shortcode_contact( $atts, $content=null ) {

    shortcode_atts( array(
        "type"  => '',
        "title" => '',
        "address_part1" => '',
        "address_part2" => '',
        "text" => '',
        "icon_row1" => '',
        "icon_row2" => '',
        "form_id" => '',
        "email" => '',
        "phone" => '',
        "phone_nice" => '',
    ), $atts );

    ob_start();

    $icon_row1 = '';
    if( '' != $atts['icon_row1'] ){
        $icon_row1 = get_template_directory_uri() .'/images/'.$atts['icon_row1'];
    }

    $icon_row2 = '';
    if( '' != $atts['icon_row2'] ){
        $icon_row2 = get_template_directory_uri() .'/images/'.$atts['icon_row2'];
    }
    ?> 

    <!-- ============== Contact form block starts ============== -->
    <section class="block contact-form">
        <div class="container">
            <h2 class="wow fadeInUp"><?php echo esc_attr( $atts['title'] ); ?></h2>
            <div class="row">
                <div class="col-xs-12 col-sm-7 contact-left-text wow fadeInLeft">
                    <p><?php echo esc_attr( $atts['text'] ); ?></p>
                    <?php echo madang_fix_shortcode($content); ?>

                    <div class="location">
                        <img src="<?php echo esc_url( $icon_row1 ); ?>" alt="Map icon" /> <?php echo esc_attr( $atts['address_part1'] ); ?><br /><?php echo esc_attr( $atts['address_part2'] ); ?>
                    </div>
                    <div class="phone">
                        <img src="<?php echo esc_url( $icon_row2 ); ?>" alt="Phone icon" /> <?php esc_html_e('TEL :', 'madang'); ?> <a class="tel-link" href="tel:<?php echo esc_attr( $atts['phone'] ); ?>"><?php echo esc_attr( $atts['phone_nice'] ); ?></a><br /><a class="mailto-link" href="mailto:<?php echo esc_attr( $atts['email'] ); ?>" target="_top"><?php echo esc_attr( $atts['email'] ); ?></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 contact-right-form wow fadeInRight">
                    <?php echo do_shortcode( '[contact-form-7 id="'. esc_attr( $atts['form_id'] ) .'" title="'.esc_html__('Contact us form', 'madang').'"]' ); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- ============== Contact form block ends ============== -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}