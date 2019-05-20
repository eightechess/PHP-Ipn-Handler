<?php 
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
       header ( 'Location: index.php');
        exit();
    }

    $postFields = "";
    //Sandbox
    $url   = "https://sandbox.tranzcore.com/verify";
      //  $url       ="http://httpbin.org/post";
    //Live environment
    //$url      = "https://secure.tranzcore.com/verify",
   // Collect all values posted to ipn listener and store in $postFields
    foreach($_POST as $key => $value){
        $postFields .= "&$key=".urlencode($value);
    }

    $options = array(
        'http' =>
            array(
                'method'  => 'POST', //We are using the POST HTTP method.
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'header'  => 'Accept: */*',
                'header'  => 'Cache-Control: no-cache',
                'header'  => 'charset: utf-8',
                'content' => $postFields //Our URL-encoded query string.
            )
    );


    //Pass our $options array into stream_context_create.
    //This will return a stream context resource.
    $streamContext  = stream_context_create($options);
    //Use PHP's file_get_contents function to carry out the request.
    //We pass the $streamContext variable in as a third parameter.
    $result = file_get_contents($url, false, $streamContext);
    //If $result is FALSE, then the request has failed.
    
    if($result === false){
        //If the request failed, throw an Exception containing
        //the error.
        $error = error_get_last();
        throw new Exception('POST request failed: ' . $error['message']);
    }
    
    // Live Environment
    // if ($result =="VERIFIED") {
    //     //Update record here

    // }
    
    // Sandbox
    if ($result =="SANDBOX") {
        //Update record here

    }
    exit();
?>