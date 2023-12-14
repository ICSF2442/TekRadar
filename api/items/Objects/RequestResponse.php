<?php

namespace Objects;

class RequestResponse
{
    // Variável para armazenar o resultado da requisição
    private mixed $result = null;

    // Variável para indicar se há um erro na resposta (true = erro, false = sem erro)
    private ?bool $isError = false;

    // Mensagem de erro, caso haja algum
    private ?string $error = null;

    /**
     * Obtém o resultado da requisição
     * @return mixed - Pode ser de qualquer tipo
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * Define o resultado da requisição
     * @param mixed $result - Pode ser de qualquer tipo
     * @return RequestResponse - A própria instância para permitir encadeamento de métodos
     */
    public function setResult(mixed $result): RequestResponse
    {
        $this->result = $result;
        return $this;
    }

    /**
     * Obtém o status de erro da requisição
     * @return bool|null - True se houver erro, false se não houver, null se não estiver definido
     */
    public function getIsError(): ?bool
    {
        return $this->isError;
    }

    /**
     * Define o status de erro da requisição
     * @param bool|null $isError - True se houver erro, false se não houver, null para não definido
     * @return RequestResponse - A própria instância para permitir encadeamento de métodos
     */
    public function setIsError(?bool $isError): RequestResponse
    {
        $this->isError = $isError;
        // Se não houver erro, define a mensagem de erro como nula
        if (!$isError) {
            $this->error = null;
        }
        return $this;
    }

    /**
     * Obtém a mensagem de erro
     * @return string|null - A mensagem de erro, se houver, ou null se não houver erro
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * Define a mensagem de erro
     * @param string|null $error - A mensagem de erro ou null para limpar a mensagem atual
     * @return RequestResponse - A própria instância para permitir encadeamento de métodos
     */
    public function setError(?string $error): RequestResponse
    {
        $this->error = $error;
        // Se não houver erro, define a mensagem de erro como nula
        if (!$error) {
            $this->error = null;
        }
        return $this;
    }

    /**
     * Retorna a representação da resposta em formato JSON
     * @param bool $print - Indica se deve imprimir a resposta ou apenas retornar como string
     * @return string|bool - Se $print for true, imprime a resposta e retorna JSON, caso contrário, retorna o JSON como string
     */
    public function response(bool $print = true): string|bool
    {
        $json = json_encode(array(
            "result" => $this->result,
            "isError" => $this->isError,
            "error" => $this->error
        ));
        // Se $print for true, imprime o JSON
        if ($print) {
            echo $json;
        }
        return $json; // Retorna o JSON como string
    }
}
