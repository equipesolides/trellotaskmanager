<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trello_lib{

	public function request_api( $type, $target, $args = false ){
		if( ! $args ) {
			$args = array();
		}elseif( ! is_array( $args ) ){
			$args = array( $args );
		}

		$url = 'https://api.trello.com/1/' . $target . '?key=' . TRELLO_KEY . '&token=' . TRELLO_TOKEN;

		$c = curl_init();
		curl_setopt( $c, CURLOPT_HEADER, 0 );
		curl_setopt( $c, CURLOPT_VERBOSE, 0 );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $c, CURLOPT_URL, $url );
		if( count( $args ) ){
			curl_setopt( $c, CURLOPT_POSTFIELDS , http_build_query( $args ) );
		}

		switch( $type ){
			case 'POST':
					curl_setopt( $c, CURLOPT_POST, 1 );
				break;
			case 'GET':
					curl_setopt( $c, CURLOPT_HTTPGET, 1 );
				break;
			default:
					curl_setopt( $c, CURLOPT_CUSTOMREQUEST, $type );
				break;
		}

		$data = curl_exec( $c );
		curl_close( $c );

		return json_decode( $data , TRUE );
	}

	public function add_due_date( $str_date, $days_to_sum = 0, $time_setting = '1:00:00' ){
		# math automatic sum of days between the date provided and the desired due 
		# got a date in format d/m/Y H:i:s

	    $str_date = substr( $str_date, 0, 10 );
	    if ( preg_match( "@/@", $str_date ) == 1 ){
	        $str_date = implode( "-", array_reverse( explode( "/", $str_date ) ) );
	    }
	    $arr = explode( '-', $str_date );
	    $count_days = 0;
	    $int_qtd_dias_uteis = 0;
	    while( $int_qtd_dias_uteis < $days_to_sum ){
	        $count_days++;
	        if( ( $dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', mktime(0, 0, 0, $arr[1], $arr[2], $arr[0]))) ) != '0' && $dias_da_semana != '6' ){

	           		$int_qtd_dias_uteis++;
	        }
	    }
	    $deadline = gmdate( 'Y-m-d H:i', strtotime( '+' . $count_days . ' day', strtotime( $str_date ) ) ).'00';
	    $partdate = explode( ' ', $deadline );
        $hour_dt = gmdate('H:i:s', strtotime( $partdate[1] ) - strtotime( $time_setting ) ); # adjust the trello time difference to pt-BR
        $due = $partdate[0] . ' ' . $hour_dt;

	    return trim( $due );
	}

}