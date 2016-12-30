<?php

/**
* HCP Connet PHP Library
* https://github.com/subhransusekhar/hcp-connect
* (c) 2016 Subhransu Sekhar <subhransu.sm@gmail.com>
*/
class HCPConnectException extends Exception {}

class HCPConnect {

  public $options;

  public function __construct($options=[]){
    $default_options = [
      'base_url' => NULL,
      'username' => NULL,
      'password' => NULL
    ];
    $this->options = array_merge($default_options, $options);
  }
  public function set($file_name, $path) {
    $endpoint = "rest/$file_name";
    $data = file_get_contents($path);
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->buffer($data);
    $URL = $this->options['base_url'] . "/" . $endpoint;
    $auth_key = 'HCP ' . base64_encode($this->options['username']) . ":" . md5($this->options['password']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: $type","Authorization: $auth_key"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Make the REST call, returning the result
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpcode;
  }
  public function get($file) {
    $endpoint = "rest/$file_name";
    $URL = $this->options['base_url'] . "/" . $endpoint;
    $auth_key = 'HCP ' . base64_encode($this->options['username']) . ":" . md5($this->options['password']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: $type","Authorization: $auth_key"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    // Make the REST call, returning the result
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    $httpcode['response'] = $response;
    curl_close($ch);
    return $httpcode;
  }
  public function get_url($file) {
    $endpoint = "rest/$file";
    $URL = $this->options['base_url'] . "/" . $endpoint;
    return $URL;
  }
  public function delete($file) {
    $endpoint = "rest/$file_name";
    $URL = $this->options['base_url'] . "/" . $endpoint;
    $auth_key = 'HCP ' . base64_encode($this->options['username']) . ":" . md5($this->options['password']);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$URL);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); //timeout after 30 seconds
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: $auth_key"));
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    // Make the REST call, returning the result
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $httpcode;
  }

}
