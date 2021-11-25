<?php 

$output = '';
$hidden = 'wow fadeInLeft';
$madang_pricingtable = '';
$i = 0;
foreach( $instance['a_repeater'] as $item ){

	//visibility
	if ( $item['visibility'] == '' ){

		$i++;
		$select_class = preg_replace('/\s+/', '_', $item['title']);
		$madang_pricingtable .= ' sort'.$i.'_class="'.$select_class.'" sort'.$i.'_title="'.$item['title'].'" ';

		$output .= '[madang_pricingtable_item class="'.$select_class.' col-xs-12 col-sm-4 pricing-box '.$hidden.' '.(($item['popular1']!='')?"popular":"").'" title="'.$item['title1'].'" price="'.$item['price1'].'" price_period="'.$item['price_period1'].'" text1="'.$item['text11'].'" text2="'.$item['text12'].'" text3="'.$item['text13'].'" button_text="'.$item['button_text1'].'" button_url="'.$item['button_url1'].'" /]';
		$output .= '[madang_pricingtable_item class="'.$select_class.' col-xs-12 col-sm-4 pricing-box '.$hidden.' '.(($item['popular2']!='')?"popular":"").'" title="'.$item['title2'].'" price="'.$item['price2'].'" price_period="'.$item['price_period2'].'" text1="'.$item['text21'].'" text2="'.$item['text22'].'" text3="'.$item['text23'].'" button_text="'.$item['button_text2'].'" button_url="'.$item['button_url2'].'" /]';
		$output .= '[madang_pricingtable_item class="'.$select_class.' col-xs-12 col-sm-4 pricing-box '.$hidden.' '.(($item['popular3']!='')?"popular":"").'" title="'.$item['title3'].'" price="'.$item['price3'].'" price_period="'.$item['price_period3'].'" text1="'.$item['text31'].'" text2="'.$item['text32'].'" text3="'.$item['text33'].'" button_text="'.$item['button_text3'].'" button_url="'.$item['button_url3'].'" /]';
		$hidden = 'hidden';
	}
}

if ( 'banner' == $instance['type'] ) { 

	$image_url = "";
	if ( $instance['image'] != '' ){
	    $image_url = wp_get_attachment_image_src($instance['image'],"full",false);
	}
	echo do_shortcode( '[madang_banner type="pricing" class="'.$instance['class'].'" image="'.$image_url[0].'" ][madang_pricingtable type="banner" '.$madang_pricingtable.']'.$output.'[/madang_pricingtable][/madang_banner]' );
}else if( 'normal' == $instance['type'] ) { 

	if ( $instance['show_header'] != '' ){
		$instance['show_header'] = 'true';
	}
	echo do_shortcode( '[madang_pricingtable show_header="'.$instance['show_header'].'" title="'.$instance['title'].'" subtitle="'.$instance['subtitle'].'" type="normal" '.$madang_pricingtable.']'.$output.'[/madang_pricingtable]' );
}