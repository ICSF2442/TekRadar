<?php

use Functions\Utils;
use Objects\RequestResponse;

$request = new RequestResponse();

$json = Utils::getRequestBody();
if ($json == null) {
    echo "ERRO! JSON INVALIDO!";

} else {

}
