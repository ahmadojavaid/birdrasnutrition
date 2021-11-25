<?php

function madang_shortcode_nutrition_table( $atts, $content=null ) {

    $atts = shortcode_atts( array(
        "type" => '',
        "image" => '',
        "title" => '',
        "id"  => '',
        "text" => ''
    ), $atts );

    ob_start();
    ?> 

    <!-- =============== menu single block starts ================== -->
    <div class="facts-wrap">
        <div class="title-block">
            <?php echo '<h1>'.esc_attr( get_post_meta( esc_attr( $atts['id'] ), 'madang_title', true ) ).'</h1>'; 
            echo madang_output_text( get_post_meta( esc_attr( $atts['id'] ), 'madang_subtitle', true ) );
            ?>
        </div>
        <?php
            //amount per serving
            $entries = get_post_meta( esc_attr( $atts['id'] ), 'madang_program_nutrition_group1', true );
            $contents = '';
            foreach ( (array) $entries as $key => $entry ) {

                $title = $classes = '';

                if ( isset( $entry['classes'] ) ) {
                    $classes = $entry['classes'];
                }

                if ( isset( $entry['contents'] ) ) {

                    if ( $classes == 'sub-amount' ){

                        $contents .= '<div class="'.$classes.'"><div>'.$entry['contents'].'</div></div>';
                    }else{
                        $contents .= '<div class="'.$classes.'">'.$entry['contents'].'</div>';
                    }
                }
            }
            if(strlen($contents)>5){ echo '<div class="amount-per-serving">'.madang_output_html( $contents ).'</div>'; }

            //vitamins
            $entries = get_post_meta( esc_attr( $atts['id'] ), 'madang_program_nutrition_group2', true );
            $contents = '';
            foreach ( (array) $entries as $key => $entry ) {

                $title = $classes = '';

                if ( isset( $entry['classes'] ) ) {
                    $classes = $entry['classes'];
                }

                if ( isset( $entry['contents'] ) ) {

                    if ( $classes == 'sub-amount' ){

                        $contents .= '<div class="'.$classes.'"><div>'.$entry['contents'].'</div></div>';
                    }else{
                        $contents .= '<div class="'.$classes.'">'.$entry['contents'].'</div>';
                    }
                }
            }
            if(strlen($contents)>5){ echo '<div class="vitamin">'.madang_output_html( $contents ).'</div>'; }

            //hint
            $entries = get_post_meta( esc_attr( $atts['id'] ), 'madang_program_nutrition_group3', true );
            $contents = '';
            foreach ( (array) $entries as $key => $entry ) {

                $title = $classes = '';

                if ( isset( $entry['classes'] ) ) {
                    $classes = $entry['classes'];
                }
                
                if ( isset( $entry['contents'] ) ) {

                    if ( $classes == 'sub-amount' ){

                        $contents .= '<div class="'.$classes.'">'.$entry['contents'].'</div>';
                    }else{
                        $contents .= '<span class="'.$classes.'">'.$entry['contents'].'</span>';
                    }
                }
                // Do something with the data
                $firstLoop++;
            }
            if(strlen($contents)>5){ echo '<div class="hints">'.madang_output_html( $contents ).'</div>'; }

            //sumup
            $entries = get_post_meta( esc_attr( $atts['id'] ), 'madang_program_nutrition_group4', true );
            $contents = '';
            foreach ( (array) $entries as $key => $entry ) {

                $title = $classes = '';

                if ( isset( $entry['classes'] ) ) {
                    $classes = $entry['classes'];
                }
                
                if ( isset( $entry['table_contents'] ) ) {

                    $contents .= '<tr>';
                    foreach ( (array) $entry['table_contents'] as $key => $entry ) {

                        if ( $classes == 'header' ){

                            $contents .= '<th>'.$entry.'</th>';
                        }else{
                            $contents .= '<td>'.$entry.'</td>';
                        }
                    }
                    $contents .= '</tr>';
                }
            }
            if( strlen($contents)>5 ){ echo '<div class="calorie-table"><table>'.madang_output_html( $contents ).'</table></div>'; }  
            ?>
        <!-- == nutrition facts ends == -->
    </div>
    <!-- =============== menu single block ends ================== -->

    <?php

    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}
