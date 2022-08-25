<?php
/**
 * Gerencianet Validation Class.
 */


class GerencianetValidation {

	/**
	 * Validates name field
	 * @param string $data
	 * @return boolean
	 */
	public function _name($data) {
		$validation = preg_match("/^[ ]*(?:[^\\s]+[ ]+)+[^\\s]+[ ]*$/",$data);
		if (!$validation || strlen($data) < 2) {
			return false;
		}
		return true;
	}
	
	/**
	 * Validates corporate field
	 * @param string $data
	 * @return boolean
	 */
	public function _corporate($data) {
		$validation = preg_match("/^[ ]*(?:[^\\s]+[ ]+)+[^\\s]+[ ]*$/",$data);
		if (!$validation || strlen($data) < 2) {
			return false;
		}
		return true;
	}
	

	/**
	 * Validates email field
	 * @param string $data
	 * @return boolean
	 */
	public function _email($data) {
		$validation = preg_match("/^[A-Za-z0-9_\\-]+(?:[.][A-Za-z0-9_\\-]+)*@[A-Za-z0-9_]+(?:[-.][A-Za-z0-9_]+)*\\.[A-Za-z0-9_]+$/",$data);
		if (!$validation) {
			return false;
		}
		return true;
	}
	
	/**
	 * Validates birthdate fields
	 * @param string $data
	 * @return boolean
	 */
	public function _birthdate($data) {
		$birth = explode("-",$data);
		$birth = $birth[0]."-".$birth[1]."-".$birth[2];
		$validation = preg_match("/^[12][0-9]{3}-(?:0[1-9]|1[0-2])-(?:0[1-9]|[12][0-9]|3[01])$/",$birth);
		if (!$validation) {
			return false;
		}
		return true;
	}
	
	/**

	 * Validates birthdate fields
	 * @param string $data
	 * @return boolean
	 */
	public function _phone_number($data) {
		$phone = preg_replace('/[^0-9]/', '',$data);
		$validation = preg_match("/^[1-9]{2}9?[0-9]{8}$/", $phone);
		if (!$validation) {
			return false;
		}
		return true;
	}
	
	/**
	 * Validates CPF data
	 * @param string $data
	 * @return boolean
	 */
	public function _cpf($data) {
		if(empty($data)) {
			return false;
		}

		$cpf = preg_replace('/[^0-9]/', '', $data);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		 
		if (strlen($cpf) != 11) {
			return false;
		} elseif ($cpf == '00000000000' ||
				$cpf == '11111111111' ||
				$cpf == '22222222222' ||
				$cpf == '33333333333' ||
				$cpf == '44444444444' ||
				$cpf == '55555555555' ||
				$cpf == '66666666666' ||
				$cpf == '77777777777' ||
				$cpf == '88888888888' ||
				$cpf == '99999999999') {
			return false;
		}else {
			for ($t = 9; $t < 11; $t++) {
				 
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf[$c] * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf[$c] != $d) {
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Validates CNPJ data
	 * @param string $data
	 * @return boolean
	 */
	public function _cnpj($cnpj) {
		if(empty($cnpj)) {
			return false;
		}
		
		$cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
		
		if (strlen($cnpj) != 14)
			return false;
		
		for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
			return false;
		
		for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
		{
			$soma += $cnpj[$i] * $j;
			$j = ($j == 2) ? 9 : $j - 1;
		}
		$resto = $soma % 11;
		return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
	}
	
	/**
	 * Validates zipcode fields
	 * @param string $data
	 * @return boolean
	 */
	public function _zipcode($data) {
	    $zipcode = preg_replace('/[^0-9]/', '',$data);
		if (strlen($zipcode) < 8) {
	        return false;
	    }
	    return true;
	}

	/**
	 * Validates street field
	 * @param string $data
	 * @return boolean
	 */
	public function _street($data) {
		if (strlen($data) < 2 || strlen($data) > 200) {
			return false;
		}
		return true;
	}

	/**
	 * Validates number field
	 * @param string $data
	 * @return boolean
	 */
	public function _number($data) {
		if (strlen($data) < 2 || strlen($data) > 55) {
			return false;
		}
		return true;
	}

	/**
	 * Validates neighborhood field
	 * @param string $data
	 * @return boolean
	 */
	public function _neighborhood($data) {
		if (strlen($data) < 1 || strlen($data) > 255) {
			return false;
		}
		return true;
	}

	/**
	 * Validates city field
	 * @param string $data
	 * @return boolean
	 */
	public function _city($data) {
		if (strlen($data) < 2 || strlen($data) > 255) {
			return false;
		}
		return true;
	}

	/**
	 * Validates state field
	 * @param string $data
	 * @return boolean
	 */
	public function _state($data) {
		$validation = preg_match("/^(?:A[CLPM]|BA|CE|DF|ES|GO|M[ATSG]|P[RBAEI]|R[JNSOR]|S[CEP]|TO)$/",$data);
		if (!$validation) {
			return false;
		}
		return true;
	}

	public function getErrorMessage($error_code) {
		$messageErrorDefault = 'Ocorreu um erro ao tentar realizar a sua requisição. Entre em contato com o proprietário do site.';
		$messageAdmin = [];
		switch($error_code) {
			case 3500000:
				$message[] = 'Erro interno do servidor.';
				break;
			case 3500001:
				$message[] = $messageErrorDefault;
				break;
			case 3500002:
				$message[] = $messageErrorDefault;
				break;
			case 3500007:
				$message[] = 'O tipo de pagamento informado não está disponível.';
				break;
			case 3500008:
				$message[] = 'Requisição não autorizada.';
				break;
			case 3500010:
				$message[] = $messageErrorDefault;
				break;
			case 3500016:
				$message[] = 'A transação deve possuir um cliente antes de ser paga.';
				break;	
			case 3500021:
				$message[] = 'Não é permitido parcelamento para assinaturas.';
				break;
			case 3500030:
				$message[] = 'Esta transação já possui uma forma de pagamento definida.';
				break;
			case 3500034:
					$message[] = $messageErrorDefault;
				break;
			case 3500036:
				$message[] = 'A forma de pagamento da transação não é boleto bancário.';
				break;
			case 3500042:
				$message[] = $messageErrorDefault;
				$messageAdmin = 'O parâmetro [data] deve ser um JSON.';
				break;
			case 3500044:
				$message[] = 'A transação não pode ser paga. Entre em contato com o vendedor.';
				break;
			case 4600002:
				$message[] = $messageErrorDefault;
				break;
			case 4600012:
				$message[] = 'Ocorreu um erro ao tentar realizar o pagamento' ;
				break;
			case 4600022:
				$message[] = $messageErrorDefault;
				break;
			case 4600026:
				$message[] = ' O cpf informado é inválido';
				break;
			case 4600029:
				$message[] = 'pedido já existe';
				break;
			case 4600032:
				$message[] = $messageErrorDefault;
				break;
			case 4600035:
				$message[] = 'Serviço indisponível para a conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600037:
				$message[] = 'O valor da emissão é superior ao limite operacional da conta. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600073:
				$message[] = 'O telefone informado não é válido.';
				break;
			case 4600111:
				$message[] = 'valor de cada parcela deve ser igual ou maior que R$5,00';
				break;
			case 4600142:
				$message[] = 'Transação não processada por conter incoerência nos dados cadastrais.';
				break;
			case 4600148:
				$message[] = 'já existe um pagamento cadastrado para este identificador.';
				break;
			case 4600196:
				$message[] = $messageErrorDefault;
				break;
			case 4600204:
				$message[] = 'cpf deve ter 11 dígitos';
				break;
			case 4600209:
				$message[] = 'Limite de emissões diárias excedido. Por favor, solicite que o recebedor entre em contato com o suporte Gerencianet.';
				break;
			case 4600210:
				$message[] = 'não é possível emitir três emissões idênticas. Por favor, entre em contato com nosso suporte para orientações sobre o uso correto dos serviços Gerencianet.';
				break;
			case 4600212:
				$message[] = 'Número de telefone já associado a outro CPF. Não é possível cadastrar o mesmo telefone para mais de um CPF.';
				break;
			case 4600222:
				$message[] = 'Recebedor e cliente não podem ser a mesma pessoa.';
				break;
			case 4600219:
				$message[] = 'Ocorreu um erro ao validar seus dados.';
				break;
			case 4600224:
				$message[] = $messageErrorDefault;
				break;
			case 4600254:
				$message[] = 'identificador da recorrência não foi encontrado';
				break;
			case 4600257:
				$message[] = 'pagamento recorrente já executado';
				break;
			case 4600329:
				$message[] = 'código de segurança deve ter três digitos';
				break;
			case 4699999:
				$message[] = 'falha inesperada';
				break;
			default:
				$message[] = $messageErrorDefault;
				break;
		}
		if($messageAdmin == null || $messageAdmin == '') 
			$messageAdmin = $message;
		return $message;
	}
	
	
}