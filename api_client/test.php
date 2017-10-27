<?php

require_once "../vendor/autoload.php";
require_once "client.php";

use EUAutomation\GraphQL\Client;
use BCredi\ApiClient;

$bcrediClient = new ApiClient(
	new Client("http://api.bcredi-stag.ateliware.com/graphql")
);

$query = 'mutation CreateContact {
	create_contact(
	  address: {
		street: "Rua Cap Leônidas Marques", city: "Curitiba", state: "PR"
	  }, 
	  name: "kkkk", 
	  email: "brunoduarte1977@gmail.com", 
	  phone: "41 998 451 054", 
	  birthdate: "1977-12-17") 
	  {
	  id
	  name
	  address {
			   street
			   city
			  }
	   }
   }';

try {
	$response = $bcrediClient->execute($query);
	$data = $response->data;
	$name = $data->create_contact->name;

	echo "name of contact: ". $name;
} catch(GuzzleHttp\Exception\ClientException $e){
	echo $e->getMessage();
}