<?php

/**
 * Classe que gerencia o BD
 */
class ModelExtensionPaymentGerencianet extends Model {
	
    /**
     * Método responsável em mostrar a opção de pagamento no Checkout
     * @param mixed $address
     * @param mixed $total
     * @return array
     */
    public function getMethod($address, $total) {
		$this->load->language('extension/payment/gerencianet');

        $title_show = '<div style="background-image: url(https://s3-sa-east-1.amazonaws.com/acervo.gerencianet.com.br/imagens/marca-gerencianet.svg); position: relative; background-repeat: no-repeat; width:100px; height:20px; margin:0 0 -5px 10px; padding:0 0 0 0; display: inline-block;"></div>';
        $method_data = array(
            'code'       => 'gerencianet',
            'title'      => $title_show,
            'terms'      => '',
            'sort_order' => ''
        );

		return $method_data;
	}
    
    /**
     * Salva os dados do pedido com a cobrança gerada
     * @param mixed $data
     */
    public function insert($data){

        $this->db->query("INSERT INTO `{$this->getTableWithPrefix('gerencianet')}` 
                (`order_id`,`tx_id`,`loc_id`,`status`)
                VALUES 
                ({$data['order_id']}, '{$data['tx_id']}', '{$data['loc_id']}',  '{$data['status']}')"    
            );
    }

    /**
     * Atualiza os dados do pedido
     * @param string $column
     * @param string $vaule
     */
    public function update($conditions, $dataToUpdate){

        $querySET = $this->getQueryformatted($dataToUpdate);
        $queryWHERE = $this->getQueryformatted($conditions);

        $this->db->query("UPDATE `{$this->getTableWithPrefix('gerencianet')}` 
                SET $querySET WHERE $queryWHERE");
    }

    /**
     * Faz um SELECT no banco, recebendo a coluna e valor a ser comparado
     * @param string $column
     * @param string $value
     * @return mixed
     */
    public function find($column, $value){
        // Retorna um objeto stdClass       
        $arrayReturn = $this->db->query("SELECT * FROM `{$this->getTableWithPrefix('gerencianet')}` WHERE `{$column}` = '{$value}'");
        // Retorno apenas o array 'row'
        return $arrayReturn->row;
    }
    
    /**
     * Concatenado o nome da tabela com o Prefix padrão 
     * @param string $table_name
     * @return string
     */
    private function getTableWithPrefix($table_name){
		return DB_PREFIX . $table_name;
	}

    /**
     * Concatena os dados para ser usado na query
     * @param array $data
     * @return string
     */
    private function getQueryformatted($data){
        $query = '';
        foreach ($data as $key => $value) {
            $query .= "`{$key}` = '$value' ,";
        }

        // Remove a última vírgula da query
        return substr($query, 0, -1);
    }
}
