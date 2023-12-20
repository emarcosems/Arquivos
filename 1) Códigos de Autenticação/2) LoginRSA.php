<?php

 $url = "http://*****.sinapad.****.br:****/****/op/authentication/login-rsa";
        $data = array (
                        'service' => "****",
                        'username' => "****",
                        'file' => new CurlFile("/Users/marcoantonio/BioInfoDiscoveryServices.key", 'multipart/form-data')
        );
        $headers = array (
                        'Accept: application/json'
        );
        $handle = curl_init ();

        curl_setopt ( $handle, CURLOPT_URL, $url );
        curl_setopt ( $handle, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $handle, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt ( $handle, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $handle, CURLOPT_CONNECTTIMEOUT, 120 );
        curl_setopt ( $handle, CURLOPT_TIMEOUT, 600 );
        curl_setopt ( $handle, CURLOPT_POST, true );
        curl_setopt ( $handle, CURLOPT_POSTFIELDS, $data );
        curl_setopt ( $handle, CURLINFO_HEADER_OUT, true);

        $response = curl_exec ( $handle );

	$obj = json_decode ( $response );
    $b = $obj->{'uuid'}; 

	echo $response;

    //echo $obj->{'code'};
    //echo $obj->{'uuid'};

    
    
?>