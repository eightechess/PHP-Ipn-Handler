<?php 
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
       header ( 'Location: index.php');
        exit();
    }

    $postFields = "";
    
   // Collect all values posted to ipn listener and store in $postFields
    foreach($_POST as $key => $value){
        $postFields .= "&$key=".urlencode($value);
    }

    $ch = curl_init();
    
    curl_setopt_array($ch,array(
        //Sandbox
        CURLOPT_URL => 'https://sandbox.tranzcore.com/process',
        //Live environment
        //CURLOPT_URL => 'https://secure.tranzcore.com/checkout',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postFields
    ));

   
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response =="VERIFIED") {
        //Update record here

    }
    else{
        //Response will be stored in file test.txt 
        //Check file for error message
        $handle = fopen("test.txt", "w");
        foreach ($_POST as $key => $value)
           fwrite($handle, "$key => $value \r\n");
           fclose($handle);

    }


?>