<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceUservoice
{
	const SERVICE_NAME = 'Uservoice';


	public static function test( $domain, &$n_test, &$n_success )
	{
		$t_result = [];
		$n_test = $n_success = 0;
		/*
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.uservoice.com' );
		//curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		//curl_setopt( $c, CURLOPT_FOLLOWLOCATION, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		//var_dump($output);
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );

		if( $t_info['http_code'] == 200 || $t_info['http_code'] == 301 || $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'uservoice.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		if( preg_match('#This UserVoice subdomain is currently available#i',$output) ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}
		
		$t_result[] = [ 'uservoice.com', $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];
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

		if( stristr($output,'The page you have requested does not exist.') || stristr($output,'This UserVoice subdomain is currently available!') ) {
			$n_success++;
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ $url, $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];

		return $t_result;
	}
}
