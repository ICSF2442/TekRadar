<?php
require_once('./../../settings.php');


// Importando classes ou funções necessárias
use Functions\Utils;
use Objects\RequestResponse;
use Functions\ParkSelector;

// Criando uma instância da classe RequestResponse
$request = new RequestResponse();

// Obtendo o corpo da requisição em formato JSON
$json = Utils::getRequestBody();

// Verificando se o JSON recebido é válido
if ($json == null) {
    echo "ERRO! JSON INVÁLIDO!";
    // Se o JSON for inválido, emite uma mensagem de erro

} else {
    $valoresUser = null;
    //valoresUser é um array com os valores.
    // Verificando se o campo "valoresUser" está presente no JSON
    if ($json["valoresUser"] != null) {
        // Se presente, atribui os valores à variável $valoresUser
        $valoresUser = $json["valoresUser"];

        // Calcula o parque ideal com base nos valores do utilizador usando a função calcularParkIdeal() da classe Utils
        $parkIdeal = ParkSelector::calcularParkIdeal($valoresUser);
        if ($parkIdeal == null){
            $request->setError("Não foi possível obter o resultado!");
            $request->setIsError(true);
            // Emite a resposta de erro em formato JSON
            echo($request->response(false));
        }else{
            echo($request->setResult($parkIdeal->toArray ())->response (false));
        }

        // Define o resultado obtido no objeto $request e emite a resposta em formato JSON
    } else {
        // Se o campo "valoresUser" estiver ausente no JSON, configura uma mensagem de erro no objeto $request
        $request->setError("ERRO!");
        $request->setIsError(true);
        // Emite a resposta de erro em formato JSON
        echo($request->response(false));
    }
}
