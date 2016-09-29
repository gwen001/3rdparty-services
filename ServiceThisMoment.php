<?php

/**
 * I don't believe in license
 * You can do want you want with this program
 * - gwen -
 */

class ServiceThisMoment
{
	const SERVICE_NAME = 'ThisMoment';


	public static function test( $domain )
	{
		$t_result = [];

		$c = curl_init();
		curl_setopt( $c, CURLOPT_URL, 'http://'.$domain.'.thismoment.com' );
		curl_setopt( $c, CURLOPT_NOBODY, true );
		curl_setopt( $c, CURLOPT_CONNECTTIMEOUT, 3 );
		curl_setopt( $c, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $c, CURLOPT_RETURNTRANSFER, true );
		curl_exec( $c );
		$t_info = curl_getinfo( $c );
		curl_close( $c );

		if( $t_info['http_code'] == 302 ) {
			$status = ThirdParty::SERVICE_STATUS_FOUND;
		} elseif( $t_info['http_code'] == 0 ) {
			$status = ThirdParty::SERVICE_STATUS_NOT_FOUND;
		} else {
			$status = ThirdParty::SERVICE_STATUS_UNKNOW;
		}

		$t_result['thismoment.com'] = $status;

		return $t_result;
	}
}
