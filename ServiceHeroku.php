<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceHeroku
{
	const SERVICE_NAME = 'Heroku';


	public static function test( $domain )
	{
		//https://api.heroku.com/organizations/apps
		// {"name":"swisscom-hackathon","region":"us"}

		$t_result = [];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://'.$domain.'.herokuapp.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 200 || $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 502 ) {
			$status = ThirdParty::SERVICE_STATUS_DISABLE;
		} elseif( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'herokuapp.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://api.heroku.com/apps/'.$domain );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 200 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'herokuapp.com', $status, ThirdParty::TEST_METHOD_API_CALL ];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.herokussl.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 0 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'herokussl.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		ob_start();
		system( 'ping -c 1 '.$domain.'.herokussl.com 2>&1 &' );
		$output = ob_get_contents();
		//var_dump( $output );
		ob_end_clean();

		if( stristr($output,'unknown host') ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ 'herokussl.com', $status, ThirdParty::TEST_METHOD_PING ];

		return $t_result;
	}
}
