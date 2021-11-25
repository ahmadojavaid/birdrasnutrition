<section class="block menu-single-block">
    <div class="container">
        <div class="row">
            <!-- == single menu left content starts == -->
            <div class="col-xs-12 col-sm-7 col-md-8 menu-single-left">
                <article>
                	<?php echo madang_output_html( $instance['text'] ) ?>
       			</article>
                <div class="ingredients">
					<h5 class="text-uppercase"><strong><?php echo esc_html( $instance['title'] ) ?></strong></h5>
					<ul>
					<?php 
					if ( strpos( $instance['ingredients'], "," ) != -1 ){

 						$temp = explode( ",", $instance['ingredients']);
 						foreach ( $temp as $item){

 							echo '<li>'.esc_html( $item ).'</li>';
 						}
					}
					?>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-4 menu-single-right">
				<?php echo do_shortcode( '[madang_nutrition_table id="'.$instance['table_id'].'"]' ); ?>
			</div>
        </div>
    </div>
</section>
<!-- =============== menu single block ends ================== -->