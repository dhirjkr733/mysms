<?php

$etext = $_GET['mysmstoken'];

echo "<br>\n This is the content direct from the query string:<br>\n $etext <br>\n";

$crypttext = base64_decode($etext);

echo "<br>\n This is the content after base64 decoding:<br>\n $crypttext <br>\n";




$pub_key = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA5rGf5fJR3YfNEabqBZ/E
OJ2tRexpe916Cfmzbep51XVaD0g96BBMjCx4gG1EePpLN1rcrRKP1TANho8v99GU
VB/r3Vyl6WUAJSXXr6TIlZelRR1BzmVHu/bhff8uBjN/OF4kubRzR1W/2UX9bKlf
Ci8F+iuRObtvp7MhHHvp4j7Bp9eGeu6CQzrqFgtFzvemj4eFQ/MBoIeY082rSH8m
4LLqoNFalVEcjQLkb0JTm0BIct2GAE0tkyQvjuUvLFER9QIF5c8kKNpaLIiX6Etb
nmE9jlvtEHsHT/Eg8bilqfk39KWJbikEcI+njaYkuoHk9mZkmri0zxKleJvDzcN9
gwIDAQAB
-----END PUBLIC KEY-----';

openssl_get_publickey($pub_key);

openssl_public_decrypt($crypttext,$newsource,$pub_key); 
echo "<br>\n<br>\nRaw Decrypted String (view source to see):<br>\n $newsource  <br>\n";

echo "<br>\n<br>\nDecrypted string formatted for browser:<br>\n";

print htmlentities($newsource);



print_r($GLOBALS);

?>