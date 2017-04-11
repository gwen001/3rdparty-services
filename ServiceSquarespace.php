<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceSquarespace
{
	const SERVICE_NAME = 'Squarespace';


	public static function test( $domain )
	{
		$t_result = [];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.squarespace.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:49.0) Gecko/20100101 Firefox/49.0' );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 200 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 404 ) {
			if( $t_info['header_size'] > 250 ) {
				$status = ThirdParty::SERVICE_STATUS_DISABLE;
			} else {
				$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
			}
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'squarespace.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		return $t_result;
	}
}
