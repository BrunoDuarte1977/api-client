<?php

namespace BCredi;

class CreateOpportunityCommand {
    private $client;

    public function __construct(ApiClient $client){
        $this->client = $client;
    }

    public function execute(array $params = []){
        $sanitized_params = $this->sanitize_params($params);
        
        return $this->client->execute(
            $this->query($sanitized_params)
        );
    }

    private function query(array $params){
        return 'mutation CreateContact {
            create_contact(
              address: {
                street: "'. $params['street'] .'", city: "'. $params['city'] .'", state: "'. $params['state'] .'"
              }, 
              name: "'. $params['name'] .'", 
              email: "'. $params['email'] .'", 
              phone: "'. $params['phone'] .'", 
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
    }

    private function sanitize_params(array $params){
        $ddd = $params['telDDD'];
        $phone = $params['telCelular'];
        
        return [
            'street' => 'rua test',
            'city' => 'asd',
            'state' => $params['uf'],
            'name' => $params['nomePretendente'],
            'email' => $params['email'],
            'phone' => "$ddd $phone"
        ];
    }
}