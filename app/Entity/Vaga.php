<?php

namespace App\Entity;

use \App\Db\Database;
use \PDO;

class Vaga {
    /**
     * Identificador unico da vaga
     * @var iteger
     */
    public $id;

    /**
     * Titulo da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descriçao da vaga
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga esta Ativa
     * @var string(s/n)
     */
    public $ativo;

    /**
     * Data da vaga
     * @var string
     */
    public $data;

    /**
     * Metodo responsavel por cadastrar uma nova vaga.
     * @return boolean
     */
    public function cadastrar(){
        //Definir a data.
        $this->data = date('Y-m-d H:i:s');
       
        //Inserir a vaga no banco.
        $obDatabase = new Database('vagas');
       
        //Atribuir o id da vaga na instância.
        $this->id = $obDatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        //Retornar sucesso.
        return true;
    }

    /**
     * Metodo responsavel por atualizar a vaga.
     * @return boolean
     */
    public function atualizar() {
        return (new Database('vagas'))->update('id = '.$this->id,[
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'ativo' => $this->ativo,
                'data' => $this->data
        ]);
    }

    /**
     * Metotodo responsavel por excluir a vaga do banco.
     * @return boolean
     */
    public function excluir() {
        return (new Database('vagas'))->delete('id = '.$this->id);
    }

    /**
     * Metodo responsavel por obter as vagas do banco de dados.
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array
     */
    public static function getVagas($where = null, $order = null, $limit = null) {
        return (new Database('vagas'))
            ->select($where,$order,$limit)
            ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Metodo responsavel por buscar uma vaga com base no seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id) {
        return (new Database('vagas'))
            ->select('id = '.$id)
            ->fetchObject(self::class);
    }
}