<?php

namespace BCredi;

class ApiClient {
	const APP_ID = "MY_APP_ID";
	const APP_SECRET = "MY_APP_SECRET";
    const ENDPOINT = "http://api.bcredi-stag.ateliware.com/apps/auth";

	private $graphqlClient;
	private $token;

	public function __construct(\EUAutomation\GraphQL\Client $graphqlClient){
		$this->graphqlClient = $graphqlClient;
	}

	public function execute($query, $variables = ""){
		$headers = $this->authenticate(self::APP_ID, self::APP_SECRET);

		return $this->graphqlClient->json($query, $variables, $headers);
	}

	/**
	* returns the HTTP authorization header
	* @return array $authorizationHeader
	*/
	private function authenticate($app_id, $app_secret){
		if(empty($this->token)){
			$this->token = $this->getToken($app_id, $app_secret);
		}

		return ['Authorization' => "Bearer $this->token"];
	}

	/**
	* Make a request for API endpoint asking for new token
	* @return string $token
	*/
 	private function getToken($app_id, $app_secret){
        $response = $this->requestToken(new \GuzzleHttp\Client());

        return $response['data']['token'];
	}

    private function requestToken(\GuzzleHttp\Client $client){
        $res = $client->request('POST', self::ENDPOINT, ['headers' => [
            'Accept'     => 'application/json',
        ], 'json' => [
            'app_id' => self::APP_ID,
            'app_secret' => self::APP_SECRET]
        ]);

        if($res->getStatusCode()){
            throw new \RuntimeException("Unauthorized application credentials");
        }

        // 'application/json; charset=utf8'
        return $res->getBody();
    }
}