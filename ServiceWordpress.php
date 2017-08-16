<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceWordpress
{
	const SERVICE_NAME = 'Wordpress';


	public static function test( $domain, &$n_test, &$n_success )
	{
		$t_result = [];
		$n_test = $n_success = 0;
		/*
		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://'.$domain.'.wordpress.com' );
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
		} elseif( $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result[] = [ 'wordpress.com', $status, ThirdParty::TEST_METHOD_HTTP_HEADER ];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'https://public-api.wordpress.com/rest/v1.1/domains/suggestions?http_envelope=1&query='.$domain.'&quantity=10&include_wordpressdotcom=true&vendor=domainsbot' );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		$output = curl_exec( $c );
		//var_dump( $output );
		$t_info = curl_getinfo( $c );
		//var_dump( $t_info );
		curl_close( $c );
		$t_json = json_decode( $output );

		$found = false;
		$w_domain = $domain.'.wordpress.com';
		foreach( $t_json->body as $obj ) {
			if( $obj->domain_name == $w_domain ) {
				$found = true;
				break;
			}
		}

		if( $found ) {
			// found in request result means available, so not found :)
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ 'wordpress.com', $status, ThirdParty::TEST_METHOD_API_CALL ];
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

		if( stristr($output,'but is not configured for an account on our platform.') ) {
			$n_success++;
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		}

		$t_result[] = [ $url, $status, ThirdParty::TEST_METHOD_WEB_CONTENT ];

		return $t_result;
	}
}
