<?php
function madang_shortcode_menu_cont( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "show_header" => 'true',
        "select_program_ids" => '',
        "select_program_titles" => '',
    ), $atts );

    ob_start();
    ?> 
    <!-- ============== select menu block starts ============== -->
    <section class="block select-menu-block">
        <?php if ( 'true' == $atts['show_header'] ) : ?>
        <div class="container">
            <h3 class="wow fadeInUp text-center"><?php echo esc_attr( $atts['title'] ); ?></h3>
            <div class="text-center  wow flipInX">
                <select class="select-program">
                    <?php  
                    $select_program_ids_arr = explode(",", $atts['select_program_ids']);
                    $select_program_titles_arr = explode(",", $atts['select_program_titles']);
                    $index = 0;
                    foreach ($select_program_ids_arr as $program_id) {
                        echo '<option value="'.esc_attr( $select_program_ids_arr[$index] ).'">'.esc_attr( $select_program_titles_arr[$index] ).'</option>';
                        $index++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php endif;
        echo madang_fix_shortcode( $content ); ?>
    </section>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_menu($atts, $content = null) {
    $atts = shortcode_atts(array(
        "id" => '',
        "image" => '',
        "tags" => '',
        "title" => '',
        "class" => '',
        "subtitle" => '',
        "placeholder" => '',
        "button_text" => ''
    ), $atts);

    $program_slug = esc_attr( $atts['id'] ); 
    ob_start();
?>
<section class="<?php echo esc_attr( $atts['class'] )." ".$program_slug ; ?> program-box block select-menu-block">
    <!-- == menu tab part starts == -->
    <div class='food-tab wow fadeInUp'>
        <div class='container'>
            <ul class="nav nav-tabs" role="tablist">

                <?php 
                $args = array(
                'pagename'  => $atts['id'],
                'post_type' => 'menu',
                );
                $recentPosts = new WP_Query( $args );
                $firstLoop = 1;
                $meal_ids_arr = array();

                if ( $recentPosts->have_posts() ) :
                    while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); 

                        $entries = get_post_meta( get_the_ID(), 'madang_program_days_group', true );
                        foreach ( (array) $entries as $key => $entry ) {

                            $title = $meal_id = '';

                            if ( isset( $entry['title'] ) ) {
                                $title = esc_html( $entry['title'] );
                            }

                            if ( isset( $entry['meal_ids'] ) ) {
                                $meal_id = esc_html( $entry['meal_ids'] );
                                array_push( $meal_ids_arr, $meal_id );
                            }

                            if( $firstLoop ){

                                echo '<li role="presentation" '.(($firstLoop==1)?'class="active"':'').'><a href="#'.$program_slug.$firstLoop.'" role="tab" data-toggle="tab" class="txhcolor brhcolor">'.$title.'</a></li>';
                            }

                            // Do something with the data
                            $firstLoop++;
                        }
                    endwhile;
                endif; ?>
            </ul>
        </div>
    </div>
    <!-- == menu tab part ends == -->
    <!-- == Tab description starts == -->
    <div class='tab-description'>
        <div class="container">
            <div class="tab-content">
                <?php $firstLoop = 1; 
                foreach ( (array) $meal_ids_arr as $key => $val ) : 
                ?>
                <div role="tabpanel" class="tab-pane fade <?php echo (($firstLoop==1)?'in active':'');?> " id="<?php echo esc_html( $program_slug.$firstLoop ); ?>">
                    <!-- == food listing group starts == -->
                    <div class="food-listing-group">
                        <?php                
                        $args = array(
                        'p'  => $val,
                        'post_type' => 'meals',
                        );
                        $recentPosts = new WP_Query( $args );
                        $odd = 0;
                        if ( $recentPosts->have_posts() ) :
                            while ( $recentPosts->have_posts() ) : $recentPosts->the_post(); 

                                $entries = get_post_meta( get_the_ID(), 'madang_program_meals_group', true );
                                foreach ( (array) $entries as $key => $entry ) {

                                    $img = $title = $meal_ids = $tags = '';
                                    $image = '#';
                                    $odd++;
                                    if ( isset( $entry['title'] ) ) {
                                        $title = $entry['title'];
                                    }

                                    if ( isset( $entry['description'] ) ) {
                                        $description = $entry['description'];
                                        array_push( $meal_ids_arr, $description );
                                    }

                                    if ( isset( $entry['tags'] ) && $atts['tags'] != 'hide' ) {
                                        $tags = $entry['tags'];
                                    }

                                    if ( isset( $entry['image'] ) ) {
                                        $image = $entry['image'];
                                    }

                                    if ( isset( $entry['image_id'] ) ) {
                                        $img = wp_get_attachment_image( $entry['image_id'], 'madang-thumb', false, array(
                                            'class' => 'img-responsive',
                                        ) );
                                    }

                                    ?>
                                    <div class="food-listing-row ">
                                        <div class="food-image">
                                            <a data-toggle="lightbox" class="lightbox" href="<?php echo esc_url( $image ); ?>" >
                                                <figure> 
                                                    <?php if ( isset( $entry['image_id'] ) ) :
                                                    echo wp_get_attachment_image( $entry['image_id'], 'madang-thumb', false, array( 'class' => 'img-responsive', ) );
                                                    endif; ?>
                                                </figure></a>
                                        </div>
                                        <div class="food-type">
                                            <h5><a data-toggle="lightbox" class="lightbox <?php if (($odd % 2)){ echo 'txcolor'; }else{ echo 'txcolors'; } ?>" href="<?php echo esc_url( $image ); ?>"><?php echo esc_html( $title ); ?></a></h5>
                                        </div>
                                        <div class="food-ingredients">
                                            <?php echo wp_kses_post( $description ); ?>
                                        </div>
                                        <?php if ( $atts['tags'] != 'hide' ) : ?>
                                            <div class="food-category">
                                                <?php
                                                $pos = strpos($tags, ',');
                                                if( false !== strpos($tags, ',') ){
                                                    $tags_arr = explode(",", $tags);
                                                    $index = 0;
                                                    foreach ($tags_arr as $tag) {

                                                        $tag_link = '#';
                                                        if ($atts['tags'] == 'link' ){
                                                            $tag_link = get_site_url().'/product-tag/'.esc_attr( $tags_arr[$index] );
                                                        }
                                                        get_tag_link($tags_arr[$index]);
                                                        echo '<a href="'.$tag_link .'" class="btn bghcolor brhcolor ftag">'.esc_attr( $tags_arr[$index] ).'</a> ';
                                                        $index++;
                                                    }
                                                }else{

                                                    $tag_link = '#';
                                                    if ($atts['tags'] == 'link' ){
                                                        $tag_link = get_site_url().'/product-tag/'.esc_attr( $tags );
                                                    }
                                                    echo '<a href="'.$tag_link.'" class="btn bghcolor brhcolor ftag">'.esc_attr( $tags ).'</a> ';
                                                }
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <?php 
                                }
                            endwhile;
                        endif; ?>
                    </div>
                    <!-- == food listing group ends == -->
                </div>
                <?php $firstLoop++; endforeach; ?>
            </div>
        </div>
    </div>
    <!-- == Tab description ends == -->
</section>
<!-- ============== select menu block starts ============== -->

<?php

    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_menu_search($atts, $content = null) {
    $atts = shortcode_atts(array(
        "id" => '',
        "image" => '',
        "title" => '',
        "class" => '',
        "subtitle" => '',
        "relation" => '',
        "placeholder" => '',
        "button_text" => ''
    ), $atts);

    ob_start();

    $c1 = $c2 = $c3 = $rel = '';
    if( isset( $_GET['c1'] ) ){ $c1 = $_GET['c1']; };
    if( isset( $_GET['c2'] ) ){ $c2 = $_GET['c2']; };
    if( isset( $_GET['c3'] ) ){ $c3 = $_GET['c3']; };

    if( isset( $_GET['rel'] ) ){ $rel = sanitize_text_field( $_GET['rel'] ); }; 

    $relation = 'OR'; 
    if( $rel == '2' ){
        $relation = 'AND';
    }

    ?>
    <div id="main" class="container program_search" >

        <header class="page-header">
        <h1 class="page-title text-light"><?php echo esc_html__( 'Program Search Results for', 'madang' ); ?></h1>
        </header><!-- .page-header -->

        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        $args = array(
                    'post_status'     => 'publish',
                    'post_type'       => 'menu',
                    'posts_per_page'  => '10',                   
                    'tax_query' => array(
                        'relation'    => $relation,
                            array(
                                'taxonomy' => 'menu_category',// taxonomy name
                                'field' => 'slug',            // term_id, slug or name
                                'terms' => $c1,   // term id, term slug or term name
                            ),
                            array(
                                'taxonomy' => 'menu_category',// taxonomy name
                                'field' => 'slug',            // term_id, slug or name
                                'terms' => $c2,   // term id, term slug or term name
                            ),
                            array(
                                'taxonomy' => 'menu_category',// taxonomy name
                                'field' => 'slug',            // term_id, slug or name
                                'terms' => $c3,   // term id, term slug or term name
                            ),
                        )
                    );


        $tag_query = new WP_Query( $args );
        while ( $tag_query->have_posts() ) : $tag_query->the_post();

            get_template_part( 'template-parts/content', 'program-search' );

        endwhile;
            
        wp_reset_postdata();
        ?>
        <?php madang_pagination_blog(); ?>
    </div><!-- #main -->


<?php

    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_menu_row($atts, $content = null) {
    $atts = shortcode_atts(array(
     "id" => '',
    ), $atts);
    
    ob_start();
    ?>
    <div class="block-links">
        <div class="container">
            <div class="row">
                <?php echo madang_fix_shortcode($content); ?>
            </div>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_program_cont( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "show_header" => 'true',
        "select_program_ids" => '',
        "select_program_titles" => '',
    ), $atts );

    ob_start();
    ?> 
    <!-- ============== select menu block starts ============== -->
    <section class="block select-menu-block">
        <?php if ( 'true' == $atts['show_header'] ) : ?>
        <div class="container">
            <h3 class="wow fadeInUp text-center"><?php echo esc_attr( $atts['title'] ); ?></h3>
            <div class="text-center  wow flipInX">
                <select class="select-program">
                    <?php  
                    $select_program_ids_arr = explode(",", $atts['select_program_ids']);
                    $select_program_titles_arr = explode(",", $atts['select_program_titles']);
                    $index = 0;
                    foreach ($select_program_ids_arr as $program_id) {
                        echo '<option value="'.esc_attr( $select_program_ids_arr[$index] ).'">'.esc_attr( $select_program_titles_arr[$index] ).'</option>';
                        $index++;
                    }
                    ?>
                </select>
            </div>
        </div>
        <?php endif;
        echo madang_fix_shortcode( $content ); ?>
    </section>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programmenu_cont( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
    ), $atts );

    ob_start();
    ?> 
    <!-- == Tab description starts == -->
    <div class='tab-description'>
        <div class="container">
            <div class="tab-content">
                <?php echo madang_fix_shortcode( $content );  ?>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_program( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "class" => '',
    ), $atts );

    ob_start();
    ?> 
    <div class="program-box <?php echo esc_attr( $atts['class'] ); ?>">
        <?php echo madang_fix_shortcode( $content ); ?>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programday( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
    ), $atts );

    ob_start();
    ?> 
    <!-- == menu tab part starts == -->
    <div class='food-tab'>
        <div class='container'>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php echo madang_fix_shortcode( $content ); ?>
            </ul>
        </div>
    </div>
    <!-- == menu tab part ends == -->
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programday_item( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "class" => '',
        "title" => '',
        "day_id" => '',
    ), $atts );

    ob_start();

    ?> 

    <!-- == menu tab part starts == -->
    <li role="presentation" class="<?php echo esc_attr( $atts['class'] ); ?>"><a href="#<?php echo esc_attr( $atts['day_id'] ); ?>" role="tab" data-toggle="tab"><?php echo esc_attr( $atts['title'] ); ?></a></li>
    <!-- == menu tab part ends == -->

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programmenu( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "day_id" => '',
        "class" => '',
    ), $atts );

    ob_start();
    ?> 
    <div role="tabpanel" class="<?php echo esc_attr( $atts['class'] ); ?>" id="<?php echo esc_attr( $atts['day_id'] ); ?>">
        <div class="food-listing-group">
            <?php echo madang_fix_shortcode( $content ); ?>
        </div>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function madang_shortcode_programmenu_item( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "title" => '',
        "text" => '',
        "image" => '',
        "tags" => '', 
    ), $atts );

    ob_start();
    ?> 
    <div class="food-listing-row ">
        <div class="food-image">
            <a href='#'><figure><img class="img-responsive" src="<?php echo esc_url( $atts['image'] ); ?>" alt="<?php echo esc_attr( $atts['title'] ); ?>" /></figure></a>
        </div>
        <div class="food-type">
            <h5><a href="#"><?php echo esc_attr( $atts['title'] ); ?></a></h5>
        </div>
        <div class="food-ingredients">
            <?php echo esc_attr( $atts['text'] ); ?>
        </div>
        <div class="food-category">
            <?php
                $tags_arr = explode(",", $atts['tags']);
                $index = 0;
                foreach ($tags_arr as $tag) {

                    echo '<a href="#" class="btn border-btn-small">'.esc_attr( $tags_arr[$index] ).'</a> ';
                    $index++;
                }
            ?>
        </div>
    </div>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
