<?php

/**
 * <b>Read.class:</b>
 * Classe responsável por leituras genéricas no banco de dados!
 */
class Read {

    private $Select;
    private $Places;
    private $Result;

    /** @var PDOStatement */
    private $Read;

    /** @var PDO */
    private $Conn;
    
    /* Obtém conexão do banco de dados Singleton */
    public function __construct() {
        $this->Conn = Conn::getConn();
    }

    /**
     * <b>Exe Read:</b> Executa uma leitura simplificada com Prepared Statments. Basta informar o nome da tabela,
     * os termos da seleção e uma analize em cadeia (ParseString) para executar.
     * @param STRING $Tabela = Nome da tabela
     * @param STRING $Termos = WHERE | ORDER | LIMIT :limit | OFFSET :offset
     * @param STRING $ParseString = link={$link}&link2={$link2}
     */
    public function ExeRead($Tabela, $Termos = null, $ParseString = null) {
        if (!empty($ParseString)):
            parse_str($ParseString, $this->Places);
        endif;

        $this->Select = "SELECT * FROM {$Tabela} {$Termos}";
        $this->Execute();
    }

    /**
     * <b>Obter resultado:</b> Retorna um array com todos os resultados obtidos. Envelope primário númérico. Para obter
     * um resultado chame o índice getResult()[0]!
     * @return ARRAY $this = Array ResultSet
     */
    public function getResult() {
        return $this->Result;
    }

    /**
     * <b>Obter relacionados:</b> Obtém resultados relacionados de outra tabela por meio de coluna e valor associado!
     * @param STRING $Tabela Nome da tabela onde buscar os dados!
     * @param STRING $Coluna Nome da coluna relacionada a sua leitura atual!
     * @param INT $Valor Valor relacionado, geralmente o ID que se associa a outra tabela!
     * @param STRING $Campos Nome das colunas que deseja ler separadas por vírgula.
     * @return ARRAY $this = Array ResultSet
     */
    public function LinkResult($Tabela, $Coluna, $Valor, $Campos = null) {
        if ($Campos):
            $this->FullRead("SELECT {$Campos} FROM  {$Tabela} WHERE {$Coluna} = :value", "value={$Valor}");
        else:
            $this->ExeRead($Tabela, "WHERE {$Coluna} = :value", "value={$Valor}");
        endif;

        if ($this->getResult()):
            return $this->getResult()[0];
        else:
            return false;
        endif;
    }

    /**
     * <b>Contar Registros: </b> Retorna o número de registros encontrados pelo select!
     * @return INT $Var = Quantidade de registros encontrados
     */
    public function getRowCount() {
        return $this->Read->rowCount();
    }

    /**
     * <b>FullRead</b> = É para caso queira passar uma QUERY manualmente (querys mais avançadas, com inner joins por exemplo).
     * @param STRING $query Digite a Query Avançada aqui. Se desejar usar binds pode, exemplo: 'WHERE id >= :id AND name == :name'
     * @param STRING $parseString Se você SETOU um bind na $query, vai precisar preencher aqui o parseString, exemplo: "id=5&name=matheus"
     */
    public function FullRead($query, $parseString = null) {
        
        $this->Select = (string) $query;
        
        if(!empty($parseString)):
            parse_str($parseString, $this->Places);
        endif;
        
        $this->Execute();
    }

    /**
     * <b>setPlaces</b> 
     * Este método vai alterar as condições de consultas no banco de dados, pois é passado uma nova parsestring por parametro
     * alterando assim o resultado das pesquisas.
     * OU SEJA, faz a reexecução sem precisar alterar a QUERY novamente.
     * @param STRING $parseString Exemplo = "visitas=50&saldo=899".
     */
    public function setPlaces($ParseString) {
        parse_str($ParseString, $this->Places);
        $this->Execute();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Obtém o PDO e Prepara a query
    private function Connect() {
        
        $this->Read = $this->Conn->prepare($this->Select);
        $this->Read->setFetchMode(PDO::FETCH_ASSOC);
    }

    //Cria a sintaxe da query para Prepared Statements
    private function getSyntax() {
        if ($this->Places):
            foreach ($this->Places as $Vinculo => $Valor):
                if ($Vinculo == 'limit' || $Vinculo == 'offset'):
                    $Valor = (int) $Valor;
                endif;
                $this->Read->bindValue(":{$Vinculo}", $Valor, ( is_int($Valor) ? PDO::PARAM_INT : PDO::PARAM_STR));
            endforeach;
        endif;
    }

    //Obtém a Conexão e a Syntax, executa a query!
    private function Execute() {
        $this->Connect();
        try {
            $this->getSyntax();
            $this->Read->execute();
            $this->Result = $this->Read->fetchAll();
        } catch (PDOException $e) {
            $this->Result = null;
            Erro("<b>Erro ao Ler:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}
