PHP REST Client
===============
https://github.com/lukaszterg/restc 
(c) 2024 <lukaszjarosinski@gmail.com>  

Installation
-----------
``` sh
$ php composer.phar require lukaszterg/restc
```


Basic Usage
-----------
``` php
$client = new Client();
$headers = array("Content-Type" => "application/x-www-form-urlencoded"); //example headers, unnecessary
$parameters = array('name'=>'Name','gender'=>'male','email'=>'email@email.com','status'=>'active'); //example parameters, unnecessary
$client->get('http://www.boredapi.com/api/activity'); //url
  echo "<pre>";
  var_dump($client->returnResponse());
  echo "</pre>";
```


Configurable Options
--------------------
`headers` - An associative array of HTTP headers and values to be included in every request.  
`parameters` - An associative array of URL or body parameters to be included in every request.  
`user_agent` - User agent string to use in requests.  
`username` - Username to use for HTTP basic authentication. Requires `password`.  
`password` - Password to use for HTTP basic authentication. Requires `username`.  



Supported methods
--------------
The tool supports methods GET, POST, PATCH, DELETE.
Examples:

``` php
$client->get('http://www.boredapi.com/api/activity');
$client->post('https://gorest.co.in/public/v1/users',array('name'=>'Name','gender'=>'male','email'=>'email@email.com','status'=>'active'),array('Authorization'=>'Bearer '.$token));
```