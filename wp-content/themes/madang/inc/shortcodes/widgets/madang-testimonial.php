<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$image_url = '';
		if ( $item['author_image'] != '' ){
		    $image_url = wp_get_attachment_image_src($item['author_image'], "full", false);
		}
		
		if ( 'compact' == $instance['type'] ){
			$output .= '[madang_testimonial_compact author="'.$item['author'].'" author_image="'.$image_url[0].'" text=\''.$item['text'].'\'  ]';
		}else{
			$output .= '[madang_testimonial_item class="col-xs-12 col-sm-4 choose wow fadeInLeft" author="'.$item['author'].'" author_image="'.$image_url[0].'" title="'.$item['title'].'" text="'.$item['text'].'"  ]';
		}
	}
}

$image_url = '';
if ( $instance['image'] != '' ){
    $image_url = wp_get_attachment_image_src($instance['image'], "full", false);
}

echo do_shortcode( '[madang_testimonial type="'.$instance['type'].'" title="'.$instance['title'].'" text="'.$instance['text'].'" image="'.$image_url[0].'" ]'.$output.'[/madang_testimonial]' );