<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceHelpScout
{
	const SERVICE_NAME = 'HelpScout';


	public static function test( $domain, &$n_test, &$n_success )
	{
		$t_result = [];
		$n_test = $n_success = 0;
		/*
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.helpscoutdocs.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_exec( $c );
		$t_info = curl_getinfo( $c );
		curl_close( $c );

		if( $t_info['http_code'] == 301 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 404 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = ['helpscoutdocs.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];
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

		if( stristr($output,'No settings were found for this company') ) {
			$n_success++;
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ $url, $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];

		return $t_result;
	}
}
