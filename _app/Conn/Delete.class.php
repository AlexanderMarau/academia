<?php

/**
 * <b>Delete.class</b>
 * Classe Responsável por realizar exclusões genéricas no banco de dados.
 */
class Delete {

    private $Tabela;
    private $Termos;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Delete;

    /** @var PDO */
    private $Conn;
    
    /* Obtém conexão do banco de dados Singleton */
    public function __construct() {
        $this->Conn = Conn::getConn();
    }

    /**
    * <b>ExeDelete:</b> É o método facilitador da classe. Ele executa uma exclusão simplificada no banco de dados.
    * 
    * @param STRING $tabela Digite aqui o nome de uma tabela no Banco para Excluir registros.
    * @param STRING $termos Digite aqui os termos ou condições para que seja feita a exclusão na tabela. Ex: "WHERE id = :id". 
    * @param STRING $parseString Digite aqui a parseString da condição SETADA anteriormente. Ex: "id=5";
    * 
    */
    public function ExeDelete($Tabela, $Termos, $ParseString) {
        $this->Tabela = (string) $Tabela;
        $this->Termos = (string) $Termos;

        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * <b>getResult</b> : Método responsável por retornar o resultado da execução da Query.
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>getRowCount</b> : Método responsável por retornar quantos resultados a execução da QUERY obteve.
     */
    public function getRowCount() {
        return $this->Delete->rowCount();
    }

    /**
     * <b>setPlaces</b> 
     * 
     */
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->getSyntax();
        $this->Execute();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        $this->Delete = $this->Conn->prepare($this->Delete);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        $this->Delete = "DELETE FROM {$this->Tabela} {$this->Termos}";
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->Delete->execute($this->Places);
            $this->Result = true;
        } catch (PDOException $e) {
            $this->Result = null;
            Erro("<b>Erro ao Deletar:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}
