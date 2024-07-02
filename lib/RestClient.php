<?php

namespace Lib;

class RestClient {

    public $options;
    public $handler;
    public $response;

    public function __construct($options = []) {
        $default_options = [
            'headers' => [],
            'params' => [],
            'useragent' => "REST Client 0.1",
            'username' => NULL,
            'password' => NULL,
            'connecttimeout' => 20,
            'followlocation' => TRUE
        ];

        $this->options = array_merge($default_options, $options);
    }

    public function init($url) {
        $this->handler = curl_init($url);
    }

    public function get($url, $params = [], $headers = []) {
        $this->exe($url, 'GET', $params, $headers); 
    }

    public function post($url, $params = [], $headers = []) {
        $this->exe($url, 'POST', $params, $headers);
    }

    public function patch($url, $params = [], $headers = []) {
        $this->exe($url, 'PATCH', $params, $headers);
    }

    public function delete($url, $params = [], $headers = []) {
        $this->exe($url, 'DELETE', $params, $headers);
    }

    public function getToken($url, $client_id, $client_secret, $params) {
        $authorization = base64_encode($client_id . ':' . $client_secret);
        $headers = array("Authorization" => "Basic " . $authorization, "Content-Type" => "application/x-www-form-urlencoded");
        $this->exe($url, 'POST', $params, $headers);
        $tokenResult = $this->returnResponse();
        return json_decode($tokenResult)->access_token;
    }

    public function exe($url, $method = 'GET', $params = [], $headers = []) {
        $this->init($url);
        curl_setopt($this->handler, CURLOPT_URL, $url);
        curl_setopt($this->handler, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->handler, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->handler, CURLOPT_RETURNTRANSFER, 1);
        if ($this->options['connecttimeout']) {
            curl_setopt($this->handler, CURLOPT_CONNECTTIMEOUT, $this->options['connecttimeout']);
            curl_setopt($this->handler, CURLOPT_TIMEOUT, $this->options['connecttimeout']);
        }
        if ($this->options['followlocation'])
            curl_setopt($this->handler, CURLOPT_FOLLOWLOCATION, true);
        if ($this->options['useragent'])
            curl_setopt($this->handler, CURLOPT_USERAGENT, $this->options['useragent']);
        if ($this->options['username'] && $this->options['password']) {
            curl_setopt($this->handler, CURLOPT_USERPWD, sprintf("%s:%s", $this->options['username'], $this->options['password']));
        }
        if (count($this->options['headers']) || count($headers)) {
            $headers = array_merge($this->options['headers'], $headers);
            foreach ($headers as $key => $values) {
                foreach (is_array($values) ? $values : [$values] as $value) {
                    $headers_array[] = sprintf("%s: %s", $key, $value);
                }
            }
            curl_setopt($this->handler, CURLOPT_HTTPHEADER, $headers_array);
        }
        if (is_array($params)) {
            $params = array_merge($this->options['params'], $params);
            $params_str = http_build_query($params);
        } else
            $params_str = (string) $params;
        if (strtoupper($method) == 'POST') {
            curl_setopt($this->handler, CURLOPT_POST, true);
            curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $params_str);
        } elseif (strtoupper($method) != 'GET') {
            curl_setopt($this->handler, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($this->handler, CURLOPT_POSTFIELDS, $params_str);
        } elseif ($params_str) {
            $urlend = strpos($url, '?') ? '&' : '?';
            curl_setopt($this->handler, CURLOPT_URL, $url . $urlend . $params_str);
        }
        //debbuging curl
        /* curl_setopt($this->handler, CURLOPT_VERBOSE, true);
          $fp = fopen(dirname(__FILE__).'/errorlog.txt', 'w');
          curl_setopt($this->handler, CURLOPT_STDERR, $fp); */
        $resp = curl_exec($this->handler);
        $inf = curl_getinfo($this->handler);

        $this->response = array('response' => $resp, 'info' => (object) curl_getinfo($this->handler), 'error' => curl_error($this->handler));

        curl_close($this->handler);
        return $this->response;
    }

    public function returnInfos() {
        return $this->response['info'];
    }

    public function returnErrors() {
        return $this->response['error'];
    }

    public function returnResponse() {
        return $this->response['response'];
    }

}
