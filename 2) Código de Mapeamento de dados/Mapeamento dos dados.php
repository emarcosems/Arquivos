<?php 

    $url1 = ('http://****.sinapad.****.br:****/*****/op/application/list');
    include 'LoginLDAP.php';
    include 'ConexãoBanco.php';
    include 'DownloadLDAP.php';
    
    $dataN = array(
      'service'=> 'CSGrid',
      'uuid' => $b
    );

    $headersN = array(
      #'Accept: application/xml'
       'Accept: application/json'
     );
 
     $handleN = curl_init();
     curl_setopt($handleN, CURLOPT_URL, $url1);
     curl_setopt($handleN, CURLOPT_HTTPHEADER, $headersN);
     curl_setopt($handleN, CURLOPT_RETURNTRANSFER, true);
     curl_setopt($handleN, CURLOPT_SSL_VERIFYHOST, false);
     curl_setopt($handleN, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($handleN, CURLOPT_POST, true);
     curl_setopt($handleN, CURLOPT_POSTFIELDS, http_build_query($dataN));
     
    $responseN = curl_exec($handleN);
    $objN = json_decode($responseN, true);  
    //print_r($objN);


    foreach ($objN["elements"]["element"] as $valor){
      echo 'Name: '.$valor["name"] . "\n";
      $banconom=$valor["name"];
      pg_query($conn, "INSERT INTO teste.applications (name) VALUES ('$banconom')");
      foreach ( $valor["versions"]["version"] as $j){
      echo 'Version: '. $j["version"] . "\n";
      $bancovers=$j["version"];
      donwloadLDAP($banconom, $bancovers);
      pg_query($conn, "INSERT INTO teste.versions (version_name) VALUES ('$bancovers')"); 
      $f=pg_query($conn, "SELECT id FROM teste.applications WHERE name = '$banconom';");
      $w=pg_query($conn, "SELECT id FROM teste.versions WHERE version_name = '$bancovers';");
      $de=pg_fetch_row($f);
      $di=pg_fetch_row($w);
      pg_query($conn, "INSERT INTO teste.apps_versions (id_app, id_version) VALUES ($de[0], $di[0])");
    foreach ($j["queues"] as $chave){
      preg_match_all("/(.*)-(.*)-(.*)-(.*)-(.*)-(.*)$/U", $chave, $out, PREG_PATTERN_ORDER);
      if ($out[3][0] != 'none' && $out[3][0] !=''){ // Caso o escalonador ou o cluster apresente 'none', não amostra valores.
        echo "Plataform: ", $out [5][0] . "\n";
        $bancoplat=$out[0][0];
        $bancoinst=$out[2][0];
        $bancosh=$out[3][0];
        $bancoclu=$out[4][0];
        $bancoque=$out[6][0];
        $bancogate=$out[5][0];
        pg_query($conn, "INSERT INTO teste.institution (name) VALUES ('$bancoinst')");
        pg_query($conn, "INSERT INTO teste.scheduler (name) VALUES ('$bancosh')");
        $b=pg_query($conn, "SELECT id FROM teste.scheduler WHERE name = '$bancosh';");
        $c=pg_query($conn, "SELECT id FROM teste.institution WHERE name = '$bancoinst';");
        $b=pg_fetch_row($b);
        $c=pg_fetch_row($c);
        pg_query($conn, "INSERT INTO teste.clusters (name, scheduler_id, intitution_id) VALUES ('$bancoclu', $b[0], $c[0])");
        pg_query($conn, "INSERT INTO teste.gateway (name) VALUES ('$bancogate')");
        $a=pg_query($conn, "SELECT id FROM teste.clusters WHERE name = '$bancoclu';");
        $a=pg_fetch_row($a);
        pg_query($conn, "INSERT INTO teste.queues (name, cluster_id) VALUES ('$bancoque', $a[0])"); 
        $c=pg_query($conn, "SELECT max(id) FROM teste.queues WHERE name = '$bancoque';");
        $c=pg_fetch_row($c);
        pg_query($conn, "INSERT INTO teste.platforms (name, queue_id) VALUES ('$bancoplat', $c[0])");
        $q=pg_query($conn, "SELECT id FROM teste.platforms WHERE name = '$bancoplat';");
        $k=pg_query($conn, "SELECT teste.apps_versions.id FROM teste.apps_versions LEFT JOIN teste.versions on teste.versions.id = teste.apps_versions.id_version 
        LEFT JOIN teste.applications on teste.applications.id = teste.apps_versions.id_app WHERE teste.versions.version_name = '$bancovers' and  teste.applications.name = '$banconom';");
        $qe=pg_fetch_row($q);
        $ki=pg_fetch_row($k);
        pg_query($conn, "INSERT INTO teste.apps_versions_platforms (apps_versions_id, platform_id) VALUES ($ki[0],$qe[0])");   
        $gatq=pg_query($conn, "SELECT id FROM teste.gateway WHERE name = '$bancogate';");
        $gatk=pg_query($conn, "SELECT teste.apps_versions.id FROM teste.apps_versions LEFT JOIN teste.versions on teste.versions.id = teste.apps_versions.id_version 
        LEFT JOIN teste.applications on teste.applications.id = teste.apps_versions.id_app WHERE teste.versions.version_name = '$bancovers' and  teste.applications.name = '$banconom';");
        $kkk=pg_fetch_row($gatk);
        $qqq=pg_fetch_row($gatq);
        pg_query($conn, "INSERT INTO teste.apps_versions_gateway (apps_versions_id, gateway_id) VALUES ($kkk[0],$qqq[0])"); 
      }}}
      echo PHP_EOL;} 


