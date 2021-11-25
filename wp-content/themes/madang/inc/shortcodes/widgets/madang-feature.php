<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$output .= '[madang_feature_item title="'.$item['title'].'" text="'.$item['text'].'" icon="'.$item['icon'].'" button_text="'.$item['button_text'].'" button_url="'.$item['button_url'].'"   ]';
	}
}
echo do_shortcode( '[madang_feature text="'.$instance['text'].'" ]'.$output.'[/madang_feature]' ); ?>