<?php

namespace BCredi;

class Client {
  private $graphqlClient;
	private $token;

	public function __construct(\EUAutomation\GraphQL\Client $graphqlClient, $token){
		$this->graphqlClient = $graphqlClient;
    $this->token = $token;
	}

	public function execute($query, $variables = ""){
		$headers = $this->authenticate($this->token);

		return $this->graphqlClient->json($query, $variables, $headers);
	}

	/**
	* returns the HTTP authorization header
	* @return array $authorizationHeader
	*/
	private function authenticate($token){
		return ['Authorization' => "Bearer $token"];
	}
}
