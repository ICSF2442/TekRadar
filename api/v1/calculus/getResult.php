<?php

use Functions\Utils;
use Objects\RequestResponse;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if ($json == null) {
    echo "ERRO! JSON INVALIDO!";
///formato json (nome das variaveis)(array tamanho 9):
//(por ordem)
//aluguerCusto = x /0
//infApoio = x /1
//salasReuniao = x /2
//parqueEstc = x /3
//bar = x /4
//wifi = x /5
//redeTransportes = x /6
//armazem = x /7
//dist = x /8
} else {
    $valoresUser = null;

    if($json["valoresUser"]!= null){
        $valoresUser = $json["valoresUser"];

        $parkIdeal = Utils::calcularParkIdeal($valoresUser);

        echo($request->setResult($parkIdeal->toArray())->response(false));


    }else{
        $request->setError("ERRO!");
        $request->setIsError(true);
        echo($request->response(false));
    }


}
