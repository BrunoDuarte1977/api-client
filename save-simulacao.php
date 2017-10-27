<?php
require_once "vendor/autoload.php";
require_once "api_client/client.php";
require_once "api_client/create_opportunity.php";

use EUAutomation\GraphQL\Client;
use BCredi\ApiClient;
use BCredi\CreateOpportunityCommand;

    try { 
        if($_POST){

            /*** Mapeamento de atributos para envio no corpo da mensagem */
            $nomePretendente = $_POST['nomePretendente'];
            $telDDD = $_POST['telDDD'];
            $telCelular = $_POST['telCelular'];
            $idade = $_POST['idade'];
            $email = $_POST['email'];
            $tipoPessoa = $_POST['tipoPessoa'];
            $valorCredito = $_POST['valorCredito'];
            $valorImovel = $_POST['valorImovel'];
            $tipoCredito = $_POST['tipoCredito'];
            $tipoImovel = $_POST['tipoImovel'];
            $prazo = $_POST['prazo'];
            $valorTotalFinanciamento = $_POST['valorTotalFinanciamento'];
            $iof = $_POST['iof'];
            $taxaSeguroDanosFisicosImovel = $_POST['taxaSeguroDanosFisicosImovel'];
            $taxaSeguroMorteInvalidezPerm = $_POST['taxaSeguroMorteInvalidezPerm'];
            $taxaManutencaoMensal = $_POST['taxaManutencaoMensal'];
            $taxaEfetivaJuros = $_POST['taxaEfetivaJuros'];
            $valorTotalCustas = $_POST['valorTotalCustas'];
            $tipoAmortizacao = $_POST['tipoAmortizacao'];
            $uf = $_POST['uf'];
            $guid = $_POST['guid'];
            $tipoParcela = $_POST['tipoParcela'];
        
            $servername = "";
            $dbname = "";
            $username = "";
            $password = "";
                
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn->set_charset("utf8");
    
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            //comando para inserir na tabela de simulacao 
            $sqlInsert = "
                INSERT INTO simulacao
                (`nome`,
                `telefone`,
                `idade`,
                `tipoPessoa`,
                `email`,
                `tipoCredito`,
                `tipoImovel`,
                `valorCredito`,
                `taxaManutencaoMensal`,
                `valorImovel`,
                `taxaEfetivaJuros`,
                `prazo`,
                `totalCustas`,
                `valorTotalFinanciamento`,
                `percentualSeguroMorteInvalidez`,
                `iof`,
                `percentualSeguroDanosFisicosImovel`,
                `tipoAmortizacao`,
                `uf`,
                `guid`,
                `tipoParcela`)
                VALUES
                (
                    '$nomePretendente',
                    '($telDDD) $telCelular',        
                    $idade,
                    '$tipoPessoa',
                    '$email',     
                    '$tipoCredito',
                    '$tipoImovel',
                    $valorCredito,
                    $taxaManutencaoMensal, 
                    $valorImovel,
                    $taxaEfetivaJuros,
                    $prazo,  
                    $valorTotalCustas,
                    $valorTotalFinanciamento,
                    $taxaSeguroDanosFisicosImovel,
                    $iof,
                    $taxaSeguroMorteInvalidezPerm,
                    '$tipoAmortizacao',
                    '$uf',
                    upper('$guid'),
                    '$tipoParcela'           
                );        
            ";

            if ($conn->query($sqlInsert) === TRUE) {
                $last_id = $conn->insert_id;
                //echo "New record created successfully. Last inserted ID is: " . $last_id;
                echo $last_id;
            } else {
                echo "Error: " . $sqlInsert . "<br>" . $conn->error;
            }
        
            //Fechando a conexao
            $conn->close();

            // stores the new opportunity
        $bcrediClient = new ApiClient(
            new Client("http://api.bcredi-stag.ateliware.com/graphql")
        );

        $createOpportunityCommand = new CreateOpportunityCommand($bcrediClient);
        echo $createOpportunityCommand->execute($_POST)->data->create_contact->name;

        } 
    } catch (Exception $e) {        
        echo $e->getMessage();
    }
