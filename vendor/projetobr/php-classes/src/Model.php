<?php

namespace Projeto;

class Model{//Classe responsavel por gerar os getter e setters

	private $values = [];//recebe os valores dos atributos

    //tem que saber toda vez que um metodo for chamado 
	public function __call($name, $args){ //quando instacia alguma classe ex User na hora de chamar algum metodo
		                                  //ex: $user->setiduser($data["iduser"]); o metodo magico call é invocado

		$method = substr($name, 0, 3);//verifica se é um metodo get ou set 
		$fieldName = substr($name, 3, strlen($name)); //verifica o nome do campo que foi chamado ex getIdsusuario


		switch ($method) {

			case 'get':
				return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
				break;

			case 'set':
				$this->values[$fieldName] = $args[0];
				break;
			
			
		}


	}

	public function setData($data = array()){

		foreach ($data as $key => $value) {
			
			$this->{"set".$key}($value);
		}
	}

	public function getValues(){

		return $this->values;
	}
}

?>