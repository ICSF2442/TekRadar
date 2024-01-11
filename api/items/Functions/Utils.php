<?php
namespace Functions;

use Exception;
use Objects\Park;

class Utils {

    // Verifica se uma string é um JSON válido
    public static function isJson(string $json): bool {
        json_decode($json);
        return json_last_error() === JSON_ERROR_NONE;
    }

    // Obtém o corpo da requisição como um array associativo se for JSON
    public static function getRequestBody() {
        $body = file_get_contents('php://input');
        if(self::isJson($body)) {
            return json_decode($body, true);
        }
        return null;
    }
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

    // Calcula o parque ideal com base em valores fornecidos
    public static function calcularParkIdeal($valoresArray): ?Park {
        $arrayA = self::obterDivisor($valoresArray);
        $parks = self::obterParks();
        $parkIdeal = null;
        $valor = 0;
        foreach ($parks as $park) {
            $id = $park->getId();
            $valoresDoPark = self::obterValoresDoPark($id);
            $soma = 0;
            for ($i = 0; $i < count($arrayA); $i++) {
                $resultado = $valoresDoPark[$i] / $arrayA[$i];
                $soma += $resultado;
            }
            if ($soma >= $valor) {
                $valor = $soma;
                $parkIdeal = new Park($id);
            }
        }
        return $parkIdeal;
    }

    // Obtém os valores associados a um parque específico
    public static function obterValoresDoPark($parkID): array {
        $ret = array();
        $sql = "SELECT value FROM park_quality WHERE park_fk = '$parkID'";
        $query = Database::getConnection()->query($sql);
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $ret[] = $row["value"];
            }
        }
        return $ret;
    }

    // Obtém os parques disponíveis
    public static function obterParks(): array {
        $ret = array();
        $sql = "SELECT id FROM park";
        $query = Database::getConnection()->query($sql);
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_array(MYSQLI_ASSOC)) {
                $ret[] = new Park($row["id"]);
            }
        }
        return $ret;
    }
    /// formula:
///  0.1 + (x-5)(1-0.1)/(1-5)
///
/// 1º x-5
/// 2º 1-0.1=0.9
/// 3º resultado do 1º * res da 2º
/// 4º 1-5=4
/// 5º 3º / 4ª
/// 6º 0.1 + 5º
///

    // Calcula o divisor baseado numa fórmula específica
    public static function obterDivisor($arrayValoresUser): array {
        $ret = array();
        foreach ($arrayValoresUser as $valor) {
            $a = ($valor - 5) * 0.9;
            $b = $a / 4;
            $c = 0.1 + $b;
            $ret[] = $c;
        }
        return $ret;
    }

    public static function debug_to_console($data) : void
    {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);

        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }
}






