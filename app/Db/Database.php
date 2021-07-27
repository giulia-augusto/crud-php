<?php

namespace App\Db;

use \PDO;

class Database{
    /**
    * HOST de conexão com o banco de dados.
    * @var string
    */
    const HOST = 'localhost';

    /**
    * NOME do banco de dados.
    * @var string
    */
    const NAME = 'wdev_vagas';

    /**
    * Usuario do banco de dados.
    * @var string
    */
    const USER = 'root';

    /**
    * Senha de acesso ao banco de dados.
    * @var string
    */
    const PASS = '';

    /**
    * Nome da tabela a ser manipulada.
    * @var string
    */
    private $table;

    /**
    * Instância de conexão com o banco de dados.
    * @var PDO
    */
    private $connection;

    /**
    * Definir a tabela e a instancia a conexão
    * @param string $table
    */
    public  function __construct($table = null){
        $this->table =$table;
        $this->setConnection();
    }

    /**
    * Metodo responsavel por criar uma conexão com o banco de dados.
    */
    private function setConnection() {
        try {
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('ERROR: '.$e->getMessage());
        }
    }  
    
    /** 
     * Metodo responsavel por executar queries dentro do banco de dados.
     * @param string $query
     * @return PDOStatement
     */
    public function execute($query, $params = []) {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch(PDOExeption $e) {
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
    * Metodo responsavel por inserir dados no banco de dados.
    * @param array $values [ field => value]
    * @return integer RETORNA O ID INSERIDO.
    */
    public function insert($values) {
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds = array_pad([],count($fields), '?');

        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';

        //EXECUTA O ID.
        $this->execute($query,array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
    }

    /**
     * Metodo responsavel por executar uma consulta no banco.
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement 
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*') {
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';
        
        // Monta a query
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }

    /**
     * Metodo responsavel por executar atualização no banco de dados.
     * @param string $where
     * @param array $values [ field => value]
     * @return boolean
     */
    public function update($where,$values) {
        //Dados da query
        $fields = array_keys($values);
        
        //Monta a query
        $query = 'UPDATE '.$this->table.' SET '.implode('=?, ',$fields).'=? WHERE '.$where;

        //Executa aquery.
        $this->execute($query,array_values($values));
        
        //Retorna sucesso
        return true;
    }
   
    /**
    * Metodo responsavel por excluir dados do banco
    * @param string $where
    * @return boolean
    */
    public function delete($where) {
        //Monta a query
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        //Executa a query
        $this->execute($query);

        //Retorna sucesso
        return true;
    }
}