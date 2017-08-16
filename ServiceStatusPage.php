<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceStatusPage
{
	const SERVICE_NAME = 'StatusPage';


	public static function test( $domain, &$n_test, &$n_success )
	{
		$t_result = [];
		$n_test = $n_success = 0;
		$t_result = [];
		/*
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://'.$domain.'.statuspage.io' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 200 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 302 ) {
			if( isset($t_info['redirect_url']) && stristr($t_info['redirect_url'],'inactive') ) {
				$status = ThirdParty::SERVICE_STATUS_DISABLE;
			} else {
				$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
			}
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'statuspage.io', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];
		*/
		/*
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.statuspagessl.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'statuspagessl.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];
		*/
		$n_test++;
		$url = 'http://'.$domain;
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, $url );
		//curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		//curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( stristr($output,'<title>Hosted Status Pages for Your Company</title>') ) {
			$n_success++;
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ $url, $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];
		
		return $t_result;
	}
}
