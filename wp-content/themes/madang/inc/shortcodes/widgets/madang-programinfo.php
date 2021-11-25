<?php 

$output = '';
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$output .= '[madang_programinfo_feature feature_name="'.$item['feature_name'].'" feature_text="'.$item['feature_text'].'" ]';
	}
}
echo do_shortcode( '[madang_programinfo title="'.$instance['title'].'" icon="'.$instance['icon'].'" text="'.$instance['text'].'" ]'.$output.'[/madang_programinfo]' ); ?>