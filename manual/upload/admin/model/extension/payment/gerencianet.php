<?php

/**
 * Classe responsável em modelar os dados e persisti-los no BD
 */
class ModelExtensionPaymentGerencianet extends Model {

    /**
     * Cria tabela que relaciona o pedido com o pagamento via Pix
     */
    public function createTable() {
		$this->db->query("
            CREATE TABLE IF NOT EXISTS `{$this->getTableWithPrefix('gerencianet')}` (
                `order_id` integer PRIMARY KEY NOT NULL,
                `tx_id` varchar(50),
                `loc_id` varchar(250),
                `e2e_id` text,
                `status` text NOT NULL
            )"
        );
    }

    /**
     * Concatenado o nome da tabela com o Prefix padrão 
     * @param string $table_name
     * @return string
     */
    private function getTableWithPrefix($table_name) {
		return DB_PREFIX . $table_name;
	}

}
