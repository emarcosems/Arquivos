<?php
    $url = ('http://****.sinapad.***.br:***/*****/op/authentication/login-ldap');
    
    $data = array(
     'username'=> '****.***',
     'password'=> '*****',
     'service'=> '*****',
     'uuid' => $uuid

    );
    $headers = array(
     #'Accept: application/xml'
      'Accept: application/json'
    );

    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($handle, CURLOPT_POST, true);
    curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
     
    $response = curl_exec($handle);
    $obj = json_decode ( $response );
    $b = $obj->{'uuid'}; 
    //echo $response;

 
 ?>

