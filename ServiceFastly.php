<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceFastly
{
	const SERVICE_NAME = 'Fastly';

	const F_LOGIN = '';

	const F_PASSWORD = '';

	const F_API_KEY = '';

	const F_SERVICE_ID = '';

	const F_SERVICE_VERSION = 0;


	public static function test( $domain, &$n_test, &$n_success )
	{
		$t_result = [];
		$n_test = $n_success = 0;
		/*
		$cookie_file = '/tmp/'.uniqid();
		
		$n_test++;
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://'.$domain );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		//var_dump( $output );
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

		$t_result[] = [ $domain, $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		$n_test++;
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://api.fastly.com/login' );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_POST, true );
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $c, CURLOPT_POSTFIELDS, 'user='.self::F_LOGIN.'&password='.self::F_PASSWORD );
		curl_setopt( $c, CURLOPT_COOKIEJAR, $cookie_file );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		$n_test++;
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://api.fastly.com/service/'.self::F_SERVICE_ID.'/version/'.self::F_SERVICE_VERSION.'/deactivate' );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_POST, true );
		curl_setopt( $c, CURLOPT_POSTFIELDS, 'name='.$domain );
		curl_setopt( $c, CURLOPT_HTTPHEADER, ['Fastly-Key: '.self::F_API_KEY] );
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $c, CURLOPT_COOKIEJAR, $cookie_file );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		$n_test++;
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://api.fastly.com/service/'.self::F_SERVICE_ID.'/version/'.self::F_SERVICE_VERSION.'/domain' );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $c, CURLOPT_POST, true );
		curl_setopt( $c, CURLOPT_POSTFIELDS, 'name='.$domain );
		curl_setopt( $c, CURLOPT_HTTPHEADER, ['Fastly-Key: '.self::F_API_KEY] );
		curl_setopt( $c, CURLOPT_FOLLOWLOCATION, true );
		curl_setopt( $c, CURLOPT_COOKIEJAR, $cookie_file );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( stristr($output,'is already taken') ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( stristr($output,'service_id":"'.self::F_SERVICE_ID) ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ $domain, $status, ThirdParty::TEST_METHOD_API_CALL ];

		return $t_result;
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

		if( stristr($output,'Fastly error: unknown domain') ) {
			$n_success++;
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ $url, $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];
		
		return $t_result;
	}
}
