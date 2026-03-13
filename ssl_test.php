<?php
$caBundle = 'C:/php-8.2/cacert.pem';
putenv("CURL_CA_BUNDLE=$caBundle");
$ch = curl_init('https://api.cloudinary.com');
curl_setopt($ch, CURLOPT_CAINFO, $caBundle);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
curl_exec($ch);
$err = curl_error($ch);
echo $err ? "ERROR: $err" : "SSL OK";
