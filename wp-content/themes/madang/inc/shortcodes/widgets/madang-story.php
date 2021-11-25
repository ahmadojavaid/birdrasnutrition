<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$image_url = '';
		if ( $item['image'] != '' ){
		    $image_url = wp_get_attachment_image_src($item['image'], "full", false);
		}
		$output .= '[madang_story_item title="'.$item['title'].'" subtitle="'.$item['subtitle'].'" text="'.$item['text'].'" before="'.$item['before'].'" before_postfix="'.$item['before_postfix'].'" after="'.$item['after'].'" after_postfix="'.$item['after_postfix'].'" button_text="'.$item['button_text'].'" button_url="'.$item['button_url'].'" image="'.$image_url[0].'"  ]';
	}
}
echo do_shortcode( '[madang_story  ]'.$output.'[/madang_story]' ); ?>