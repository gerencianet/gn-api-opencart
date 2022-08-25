<?php

if (version_compare(phpversion(), '5.4.0', '>=')) {
} else {
    echo "A versão do PHP instalado no servidor não é compatível com o módulo da Gerencianet. Por favor, verifique os requisitos do módulo.";
    die();
}

/**
 * Model para popular os dados do checkout
 */
class ModelCliente {
     private $nome;
     private $email;
     private $telefone;
     private $rua;
     private $numero;
     private $bairro;
     private $cep;
     private $cidade;

     function __construct($order_info)
     {
        $this->nome = $order_info['payment_firstname'] ." ".$order_info['payment_lastname'];
        $this->email = $order_info['email'];
        $this->rua = explode(",",$order_info['payment_address_1'])[0];
        $this->numero = count(explode(",",$order_info['payment_address_1'])) > 1 ? explode(",",$order_info['payment_address_1'])[1]:"";
        $this->bairro = strlen($order_info['payment_address_2']) > 0 ? $order_info['payment_address_2']:"";
        $this->cep = str_replace('-','',$order_info['payment_postcode']);
        $this->cidade = $order_info['payment_city'];
        $this->estado = $order_info['payment_zone'];
        $this->telefone = $order_info['telephone'];

     }
     /**
      * Get the value of nome
      */
     public function getNome()
     {
          return $this->nome;
     }

     /**
      * Get the value of email
      */
     public function getEmail()
     {
          return $this->email;
     }

     /**
      * Get the value of telefone
      */
     public function getTelefone()
     {
        $numformatado = '';
        $numformatado .= '(' . $this->telefone[0] . $this->telefone[1] . ')' . ' ' ;
        for ($index = 2; $index < 6; $index++) {
            $numformatado .= $this->telefone[$index];

        }
        $numformatado .= '-';
        for ($index = 6; $index < strlen($this->telefone); $index++) {
            $numformatado .= $this->telefone[$index];
    
        }
    
        return $numformatado;

     }

     /**
      * Get the value of rua
      */
     public function getRua()
     {
          return $this->rua;
     }

     /**
      * Get the value of numero
      */
     public function getNumero()
     {
          return $this->numero;
     }

     /**
      * Get the value of bairro
      */
     public function getBairro()
     {
          return $this->bairro;
     }

     /**
      * Get the value of cidade
      */
     public function getCidade()
     {
          return $this->cidade;
     }

  

     /**
      * Get the value of cep
      */
     public function getCep()
     {
         $cepFormatado = '';
        $cepFormatado .=$this->cep[0] . $this->cep[1] . '.';
    
        for ( $index = 2; $index < 5; $index++) {
            $cepFormatado .= $this->cep[$index];
        }
    
        $cepFormatado .= '-';
    
        for ( $index = 5; $index < 8; $index++) {
            $cepFormatado .= $this->cep[$index];
        }
    
    
        return $cepFormatado;
     }
}