<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceStatusPage
{
	const SERVICE_NAME = 'StatusPage';


	public static function test( $domain )
	{
		$t_result = [];

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
		return $t_result;
	}
}
