<?php

require '../vendor/autoload.php';
require '../src/auth.php';
require '../src/client.php';

$endpoint = "http://api.bcredi-stag.ateliware.com/";
$graphql_endpoint = "http://api.bcredi-stag.ateliware.com/graphql";

// get authenticated token
$authenticator = new \BCredi\Auth(
  new \GuzzleHttp\Client([
    'base_uri' => $endpoint
  ]),
  "APP_ID",
  "APPSECRET"
);

$client = new \BCredi\Client(
  new \EUAutomation\GraphQL\Client($graphql_endpoint),
  $authenticator->getToken()
);
