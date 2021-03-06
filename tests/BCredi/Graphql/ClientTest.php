<?php

require_once(__DIR__ . '/../../../src/BCredi/Graphql/Client.php');
require_once(__DIR__ . '/../../../src/BCredi/Graphql/Auth.php');

use \PHPUnit\Framework\TestCase;

class ClientTest extends TestCase {
  public function testExecuteQueryWithValidTokenAndReturnOk(){
    $data = '{"data":{"One":{"id":"1","name":"One Name","translations":[{"id":"1","code":"sv","name":"Ett Namn"},' .
      '{"id":"2","code":"fr","name":"Un Nom"}]},"Two":{"id":"2","name":"Two Name"}}}';
    $data = json_decode($data);

    $mock = \Mockery::mock('\\EUAutomation\\GraphQL\\Client');
    $mock->shouldReceive([
      'json' => new \EUAutomation\GraphQL\Response($data)
    ]);
    $client = new \BCredi\Graphql\Client($mock, "valid_token");

    $this->assertEquals($client->execute("query"), $data);
  }
}
