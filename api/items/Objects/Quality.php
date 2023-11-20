<?php

use Cassandra\Blob;
use Functions\Utils;
use Functions\Database;

class Quality{
    private ?int $id = null;

    private ?string $name = null;

    private  ?int $value = null;

    public function toArray(): array{

        $array = array("id" => $this->id,
            "name"=> $this->name,
            "value"=> $this->value);
        return $array;
    }

    public function store(): void{

        $fields = array("id","name","value");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("quality");

            $sql = "INSERT INTO quality ";
            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO quality ($columns) VALUES ($values);";

            Database::getConnection()->query($sql);
        }else{

            $values = "";
            $sql = "UPDATE quality ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);

            $sql = "UPDATE quality SET $values WHERE id = $this->id";

            Database::getConnection()->query($sql);
        }

    }

    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM quality WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }

    public static function find(int $id = null, string $name = null, int $value = null): int{
        $sql = "SELECT id FROM park WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($name != NULL){
            $sql .= " AND (name = '$name')";
        }
        if($value != NULL){
            $sql .= " AND (gmaps_link = '$value')";
        }

        $query = Database::getConnection()->query($sql);

        if ($query->num_rows > 0) {
            return 1;
        }else{
            return 0;
        }
    }

    public static function remover(int $id): void
    {
        if ($id != null){
            $sql = "DELETE FROM quality WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }

    public static function search(int $id = null, string $name = null, string $value = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM quality WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != null){
            $sql .= " and (id = $id)";
        }
        if($name != null){
            $sql .= " and (username = '$name')";
        }
        if($value != null){
            $sql .= " and (email = '$value')";
        }
        // cria o array de retorno
        $ret = array();
        // executa o comando sql dinamico
        $query = Database::getConnection()->query($sql);
        // echo $sql;
        if ($query->num_rows > 0) {
            // se o comando sql for maior que 0 irá percorrer o array de ids
            while($row = $query->fetch_array(MYSQLI_ASSOC)){
                // para cada id irá instanciar um objeto User através daquele id que, por sua vez, irá buscar os dados
                // necessários para construir o objeto
                $ret[] = new Quality($row["id"]);
            }
        }
        //var_dump($ret);

        // retorno o array com os objetos, caso haja objetos
        return $ret;

    }




    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     */
    public function setValue(?int $value): void
    {
        $this->value = $value;
    }


}