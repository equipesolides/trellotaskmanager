<?php


if( ! function_exists( 'html_to_plain_text' ) ){
	function html_to_plain_text( $str ){
		# remove tags of a section text description and returns the section utf-8 encoded

	    $str = str_replace('&nbsp;', ' ', $str);
	    $str = html_entity_decode($str, ENT_QUOTES | ENT_COMPAT , 'UTF-8');
	    $str = html_entity_decode($str, ENT_HTML5, 'UTF-8');
	    $str = html_entity_decode($str);
	    $str = htmlspecialchars_decode($str);
	    $str = strip_tags($str);

	    return trim( $str );
	}
}

if( ! function_exists( 'setting_due' ) ){
	function setting_due( $date, $time_setting = '1:00:00' ){
		# got format of date pt-BR and returns american format handled with a desired time 
		# if you pass a post date
	    
	    $deadline = date( 'Y-m-d H:i', strtotime( str_replace( '/', '-', $date ) ) ).':00';
        $partdate = explode( ' ', $deadline );
        $hour_dt = gmdate('H:i:s', strtotime( $partdate[1] ) - strtotime( $time_setting ) ); # adjust the trello time difference to pt-BR
        $due = $partdate[0] . ' ' . $hour_dt;

	    return trim( $due );
	}
}

if( ! function_exists( 'set_type_labels' ) ){
	function set_type_labels( $type ){
		# returns id of label to app proceed with the request

		switch( $type ){
			case '':
					return '';
				break;
			case '':
					return '';
				break;
			case '':
					return '';
				break;
			default:
				break;
		}
	}
}