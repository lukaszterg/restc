<?php

use Lib\RestClient;

include_once('vendor/autoload.php');
$client = new RestClient();
$client->get('http://www.boredapi.com/api/activity');
  echo "<pre>";
  var_dump($client->returnResponse());
  echo "</pre>";
  $client->get('https://api.freegeoip.app/json/188.114.73.133',array('apikey'=>'f4eb0d10-784d-11ec-84d2-9f2cc9c67586'));
  echo "<pre>";
  var_dump($client->returnResponse());
  echo "</pre>";
$token = "a1b2060fc6aeaefbf5554944966d7b122936f1c9d0ea0c7909f972c2d673e2d0";
  $client->post('https://gorest.co.in/public/v1/users',array('name'=>'imie2','gender'=>'male','email'=>'l1ukas.x@poczta.fm','status'=>'active'),array('Authorization'=>'Bearer '.$token));
  echo "<pre>";
  var_dump($client->returnResponse());
  echo "</pre>";
$token = $client->getToken('https://allegro.pl.allegrosandbox.pl/auth/oauth/token', '509150d9ed9740bf9bf6f5ee66903ec2', '1NiQibjKin8IrWssQtktd8v8mJb7KEeFD8cKFZHc3eSKc1dNuk3buhOBsZuTqBKg', array('grant_type' => 'client_credentials'));
$client->get('https://api.allegro.pl.allegrosandbox.pl/offers/listing', array('seller.login' => 'Client:94610178'), array('Authorization' => 'Bearer ' . $token, 'Accept' => 'application/vnd.allegro.public.v1+json'));
echo "<pre>";
var_dump($client->returnResponse());
echo "</pre>";
?>