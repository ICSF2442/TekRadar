<?php
namespace Objects;
use Cassandra\Blob;
use Functions\Utils;
use Functions\Database;

class Park{
    private ?int $id = null;

    private  ?string $logo = null;

    private ?string $name = null;

    private ?string $description = null;

    private ?string $gmaps_link = null;

    // O construtor da classe Park. Se fornecido um ID, ele busca as informações do parque na base de dados.
    public function __construct(int $id = null)
    {
        if ($id != null && Database::getConnection() != null) {
            $database = Database::getConnection();
            $query = $database->query("SELECT * FROM park WHERE id = ".$id);

            if ($query->num_rows > 0) {
                $row = $query->fetch_array(MYSQLI_ASSOC);
                $this->id = $row["id"];
                $this->logo = $row["logo"];
                $this->name = $row["name"];
                $this->description = $row["description"];
                $this->gmaps_link = $row["gmaps_link"];
            }
        }
    }
    // Converte os dados do objeto Park para um array associativo
    public function toArray(): array{

        $array = array("id" => $this->id,
            "name"=> $this->name,
            "description"=> $this->description,
            "gmaps_link"=>$this->gmaps_link);
        return $array;

    }

    // Armazena ou atualiza os dados do parque na base de dados
    public function store(): void{

        $fields = array("id","logo","name","description","gmaps_link");

        if ($this->id == null) {

            $this->id = Database::getNextIncrement("park");

            $sql = "INSERT INTO PARK ";
            $columns = "";
            $values = "";
            foreach ($fields as $field){
                $columns .= ", " . $field;
                $values .= ", " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $columns = substr($columns, 2);
            $values = substr($values, 2);
            $sql = "INSERT INTO PARK ($columns) VALUES ($values);";

            Database::getConnection()->query($sql);
        }else{

            $values = "";
            $sql = "UPDATE PARK ";
            foreach ($fields as $field){
                $values .= ",".$field." = " . ($this->{$field} != null ? "'" . $this->{$field} . "'" : "NULL");
            }

            $values = substr($values, 1);

            $sql = "UPDATE park SET $values WHERE id = $this->id";

            Database::getConnection()->query($sql);
        }

    }
    public function remove(): void
    {
        if ($this->id != null){
            $sql = "DELETE FROM park WHERE id = $this->id";
            Database::getConnection()->query($sql);
        }
    }
///        $fields = array("id","logo","name","description","gmaps_link");
///     Metodo para verificar se existe o parque na base de dados
    public static function find(int $id = null, string $logo = null, string $name = null, string $description = null, string $gmaps_link = null): int{
        $sql = "SELECT id FROM park WHERE 1=1";
        if($id != NULL){
            $sql .= " AND (id = $id)";
        }
        if($logo != NULL){
            $sql .= " AND (logo = '$logo')";
        }
        if($name != NULL){
            $sql .= " AND (name = '$name')";
        }
        if($gmaps_link != NULL){
            $sql .= " AND (gmaps_link = '$gmaps_link')";
        }
        if($description != NULL){
            $sql .= " AND (gmaps_link = '$description')";
        }

        $query = Database::getConnection()->query($sql);

        if ($query->num_rows > 0) {
            return 1;
        }else{
            return 0;
        }
    }
    //Metodo para remover um parque da base de dados dando o seu id.
    public static function remover(int $id): void
    {
        if ($id != null){
            $sql = "DELETE FROM park WHERE id = $id";
            Database::getConnection()->query($sql);
        }
    }
    //Metodo para obter um ou mais parques especificos na base de dados.
    public static function search(int $id = null, string $logo = null, string $name = null, string $description = null, string $gmaps_link = null): array{
        // crias o comando sql principal
        $sql = "SELECT id FROM park WHERE 1=1";
        // se passar um dado "id" então vai adicionar ao SQL uma parte dinamica: verificar se o id é igual ao id
        if($id != null){
            $sql .= " and (id = $id)";
        }
        if($logo != null){
            $sql .= " and (username = '$logo')";
        }
        if($name != null){
            $sql .= " and (email = '$name')";
        }
        if($description != null){
            $sql .= " and (password = '$description')";
        }
        if($gmaps_link != null){
            $sql .= " and (user_number = $gmaps_link)";
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
                $ret[] = new Park($row["id"]);
            }
        }
        //var_dump($ret);

        // retorno o array com os objetos, caso haja objetos
        return $ret;

    }

    //Getters e Setters para as propriedades da classe

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
     * @return Blob|null
     */
    public function getLogo(): ?Blob
    {
        return $this->logo;
    }

    /**
     * @param Blob|null $logo
     */
    public function setLogo(?Blob $logo): void
    {
        $this->logo = $logo;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getGmapsLink(): ?string
    {
        return $this->gmaps_link;
    }

    /**
     * @param string|null $gmaps_link
     */
    public function setGmapsLink(?string $gmaps_link): void
    {
        $this->gmaps_link = $gmaps_link;
    }


}