<?php
class ModelPaymentGerencianet extends Model {
	public function getMethod($address, $total) {
		$this->load->language('payment/gerencianet');

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('gerencianet_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

		if ($this->config->get('gerencianet_total') > 0 && $this->config->get('gerencianet_total') > $total) {
			$status = false;
		} elseif (!$this->config->get('gerencianet_geo_zone_id')) {
			$status = true;
		} elseif ($query->num_rows) {
			$status = true;
		} else {
			$status = false;
		}

		$method_data = array();

		if ($status) {
			if ($this->config->get('gerencianet_payment_option_billet') && !$this->config->get('gerencianet_payment_option_card')) {
				$title_show = 'Boleto Bancário';
			} else if ($this->config->get('gerencianet_payment_option_card') && !$this->config->get('gerencianet_payment_option_billet')) {
				$title_show = "Cartão de Crédito";
			} else {
				$title_show = $this->language->get('text_title');
			}

			$title_show .= '<div style="background-image: url(https://s3-sa-east-1.amazonaws.com/acervo.gerencianet.com.br/imagens/marca-gerencianet.svg); position: relative; background-repeat: no-repeat; width:100px; height:20px; margin:0 0 -5px 10px; padding:0 0 0 0; display: inline-block;"></div>';
			$method_data = array(
				'code'       => 'gerencianet',
				'title'      => $title_show,
				'terms'      => '',
				'sort_order' => $this->config->get('gerencianet_sort_order')
			);
		}

		return $method_data;
	}
}
