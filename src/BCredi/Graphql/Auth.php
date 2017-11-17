<?php

namespace BCredi\Graphql;

class Auth {
  const ENDPOINT = "/apps/auth";

  private $app_id;
  private $app_secret;
  private $client;

  public function __construct(\GuzzleHttp\Client $client, $app_id, $app_secret){
    $this->client = $client;
    $this->app_id = $app_id;
    $this->app_secret = $app_secret;
  }

  public function getToken(){
    $response = $this->requestToken($this->client);

    return $response['data']['token'];
  }

  private function requestToken(\GuzzleHttp\Client $client){
    $res = $client->request('POST', self::ENDPOINT, [
      'headers' => [
        'Accept'     => 'application/json',
      ], 'json' => [
        'app_id' => $this->app_id,
        'app_secret' => $this->app_secret
      ]
    ]);

    if($res->getStatusCode() != 200){
      throw new \RuntimeException("Unauthorized application credentials");
    }

    return $res->getBody();
  }
}
