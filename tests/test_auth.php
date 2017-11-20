<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../src/BCredi/Graphql/Client.php');
require_once(__DIR__ . '/../src/BCredi/Graphql/Auth.php');

$endpoint = "http://api.bcredi-stag.ateliware.com/";
$graphql_endpoint = "http://api.bcredi-stag.ateliware.com/graphql";

// get authenticated token
$authenticator = new \BCredi\Graphql\Auth(
  new \GuzzleHttp\Client([
    'base_uri' => $endpoint
  ]),
  "WEBSITE_BCREDI",
  "!kakaka@#$%^&(*&^&^%HAHAHAHA"
);

$client = new \BCredi\Graphql\Client(
  new \EUAutomation\GraphQL\Client($graphql_endpoint),
  $authenticator->getToken()
);
