<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$image_url = '';
		if ( $item['image'] != '' ){
		    $image_url = wp_get_attachment_image_src($item['image'], "full", false);
		}
	
		$output .= '[madang_team_item name="'.$item['name'].'" link="'.$item['link'].'" position="'.$item['position'].'" facebook="'.$item['facebook'].'" linkedin="'.$item['linkedin'].'" googleplus="'.$item['googleplus'].'" twitter="'.$item['twitter'].'" instagram="'.$item['instagram'].'" image="'.$image_url[0].'" ]';
	}
}

echo do_shortcode( '[madang_team class="block" title="'.$instance['title'].'" text="'.$instance['text'].'"  ]'.$output.'[/madang_team]' );