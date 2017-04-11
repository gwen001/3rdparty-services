<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceAmazon
{
	const SERVICE_NAME = 'Amazon';


	public static function test( $domain )
	{
		$t_result = [];

		$c = curl_init();
		//curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.s3.amazonaws.com' );
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.amazonaws.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_exec( $c );
		$t_info = curl_getinfo( $c );
		curl_close( $c );

		if( $t_info['http_code'] == 200 || $t_info['http_code'] == 301 || $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 403 ) {
			$status = ThirdParty::SERVICE_STATUS_DISABLE;
		} elseif( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'amazonaws.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		return $t_result;
	}
}
