<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$image_url = "";
		if ( $item['image'] != '' ){
		    $image_url = wp_get_attachment_image_src($item['image'],"madang-product-small",false);
		}
		if ( 'enlarge' == $instance['action'] ){
			$temp = wp_get_attachment_image_src($item['image'],"full",false);
			$item['button_url'] = $temp[0];
		}
		$output .= '[madang_samplemenu_item type="madang_simple" action="'.$instance['action'].'" title="'.$item['title'].'" text="'.$item['text'].'" image="'.$image_url[0].'" url="'.$item['button_url'].'" ]';
	}
}
echo do_shortcode( '[madang_samplemenu class="block" title="'.$instance['title'].'" text="'.$instance['text'].'" ]'.$output.'[/madang_samplemenu]' ); ?>