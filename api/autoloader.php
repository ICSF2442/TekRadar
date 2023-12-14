<?php

class AutoLoader
{
// Variável estática que controla se o autoloader está registrado
    private static bool $registered = false;

// Array que armazena os diretórios a serem verificados para carregar as classes
    private static array $directories;

// Método para registrar o autoloader
    public static function register ()
    {
// Verifica se o autoloader já está registrado
        if ( ! static ::$registered ) {
            static ::$registered = true;

// Registra a função de autoload usando spl_autoload_register
            spl_autoload_register ( function ( $class ) {
                $debug = false;

// Define os diretórios a serem verificados para carregar as classes
                self ::$directories = array (
// NOTA: Este deve ser o diretório sem o namespace e quando a classe for importada,
// o namespace será adicionado a partir deste diretório.
                    ( dirname ( __FILE__ ) ) ,
                    ( dirname ( __FILE__ ) . "\\items\\" ) ,
                    ( __DIR__ . "\\..\\..\\" )
                );

// Itera sobre os diretórios para carregar a classe
                foreach ( self ::$directories as $directory ) {
// Se $debug for true, exibe informações de debug
                    if ( $debug ) {
                        echo "diretório: " . $directory . "\n";
                        print_r ( scandir ( $directory ) );
                    }

// Verifica se o arquivo da classe existe no diretório atual
                    if ( file_exists ( $directory . $class . '.php' ) ) {
// Se existir, requer o arquivo da classe
                        require_once ( $directory . ( str_replace ( '\\' , DIRECTORY_SEPARATOR , $class ) ) . '.php' );
                        return true;
                    }
                }
                return false; // Se não encontrar o arquivo da classe em nenhum diretório
            } );
        }
    }

// Método para obter os diretórios usados para carregar as classes
    public static function getDirectories () : array
    {
        return self ::$directories;
    }
}