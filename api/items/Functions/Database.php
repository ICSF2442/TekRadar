<?php

// Namespace 'Functions' para encapsular as classes e funções relacionadas
namespace Functions;

use DateTime; // Importa a classe DateTime para lidar com datas
use mysqli; // Importa a classe mysqli para interagir com o MySQL
use mysqli_sql_exception; // Importa a classe mysqli_sql_exception para lidar com exceções do MySQL

class Database
{
    // Constantes para formatos de data e hora
    public const DateFormat = "Y-m-d H:i:s"; // Formato de data e hora
    public const DateFormatSimplified = "Y-m-d"; // Formato de data simplificado
    public const TimeFormat = "H:i:s"; // Formato de hora

    // Configurações do banco de dados
    private static array $database_settings = array(
        "address" => "localhost", // Endereço do banco de dados
        "port" => 3306, // Porta do banco de dados
        "username" => "root", // Nome de utilizador do banco de dados
        "password" => "", // Senha do banco de dados
        "database" => "bdd_SAD", // Nome do banco de dados
        "charset" => "utf8" // Conjunto de caracteres utilizado
    );

    private static ?Mysqli $database = null; // Instância de conexão com o banco de dados

    /**
     * Obtém a conexão com o banco de dados
     * @throws IOException se houver um problema de conexão
     */
    public static function getConnection(): Mysqli
    {
        // Verifica se não há conexão ou se a conexão está inativa
        if (self::$database == null || !self::$database->stat()) {
            try {
                // Cria uma conexão mysqli
                self::$database = new mysqli(
                    hostname: self::$database_settings["address"],
                    username: self::$database_settings["username"],
                    password: self::$database_settings["password"],
                    port: self::$database_settings["port"]
                );
                // Verifica se há erro de conexão
                if (self::$database->connect_error) {
                    // Lança uma exceção IOException se houver erro de conexão
                    throw new IOException(address: self::$database_settings["address"], port: self::$database_settings["port"]);
                } else {
                    // Seleciona o banco de dados e define o conjunto de caracteres
                    self::$database->select_db(self::$database_settings["database"]);
                    self::$database->set_charset(self::$database_settings["charset"]);
                }
            } catch (mysqli_sql_exception $e) {
                // Lança uma exceção IOException se houver um erro do tipo mysqli_sql_exception
                throw new IOException(address: self::$database_settings["address"], port: self::$database_settings["port"]);
            }
        }
        // Retorna a conexão com o banco de dados
        return self::$database;
    }

    /**
     * Obtém o próximo incremento para uma tabela específica
     * @param string $table Nome da tabela
     * @param bool $commit Flag para confirmar a transação
     * @return int Próximo incremento da tabela ou -1 em caso de erro
     */
    public static function getNextIncrement($table, $commit = false): int
    {
        try {
            // Executa uma consulta para obter o próximo incremento da tabela
            $value = self::getConnection()->query("SELECT auto_increment as 'val' FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '$table'")->fetch_array()["val"];
            if ($value === null) {
                // Se o valor for nulo, retorna 1
                return 1;
            } else {
                // Retorna o valor obtido
                return $value;
            }
        } catch (IOException $e) {
            // Em caso de exceção IOException, exibe a rastreabilidade do erro e retorna -1
            echo $e->getTraceAsString();
            return -1;
        }
    }
}

