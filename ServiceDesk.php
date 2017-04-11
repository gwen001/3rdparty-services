<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceDesk
{
	const SERVICE_NAME = 'Desk';


	public static function test( $domain )
	{
		$t_result = [];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://'.$domain.'.desk.com' );
		//curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		//curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 302 && stristr($t_info['redirect_url'],'site_not_found') ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} elseif( $t_info['http_code'] == 200 && stristr($t_info['url'],$domain) ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'desk.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://reg.desk.com/users/check_sitename.json?sitename='.$domain );
		//curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_USERAGENT, ThirdParty::USER_AGENT );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 5 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		//curl_setopt( $c, CURLOPT_HEADER, true );
		//curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( stristr($output,'success') ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} elseif( stristr($output,'failure') ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'desk.com', $status, ThirdParty::TEST_METHOD_API_CALL ];

		return $t_result;
	}
}
