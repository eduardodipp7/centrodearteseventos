<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class Category extends Model{

	public static function listAll(){

		$sql = new Sql();

		//Realizando um Join com a tabela pessoa
		return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(

        ":idcategory"=>$this->getidcategory(),
        ":descategory"=>$this->getdescategory()

		));

		$this->setData($results[0]);

		//Chamada da função pra alteração do menu categories dinamico
		Category::updateFile();

	}

	public function get($idcategory){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [

			':idcategory'=>$idcategory

		]);

        $this->setData($results[0]);
	}

	public function delete(){


		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [

			':idcategory'=>$this->getidcategory()

		]);
        
        //Chamada da função pra alteração do menu categories dinamico
		Category::updateFile();
	}

		public static function updateFile(){

        //Traz todas as categorias que tem no banco de dados pelo metodo listAll
		$categories = Category::listAll();

		/*<li><a href="#">Categoria Um</a></li>
         Repetir esse trecho dacima la no arquivo html de categories-menu
		*/

         $html = [];// array vazio, necessário para o array_push no primeiro parametro não emitir aviso que é necessário um array.

         foreach ($categories as $row) {
         	//adiciona elementos no final do array, primeiro parametro adiciona array de entrada, segundo paramentro valor a ser add no final do array
         	/*array_push($html, '<li><a class="menu-principal__item menu-principal__item--atual" href="/'.lcfirst($row['descategory']).'">'.ucfirst($row['descategory']).'</a></li>')*/

         	array_push($html, '<li><a class="menu-principal__item menu-principal__item--atual" href="/'.strtolower($row['descategory']).'">'.ucfirst(strtolower(($row['descategory']).'</a></li>')));
         }

         //Preciso gravar os dados no arquivo e salvar usando a função abaixo igualzito fopen, variavel html é um array precisa converter pra string usando implode pra gravar os dados no arquivo
         file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html));


         //Após isso fazer a chamada da função nas outras funções acima, save e delete que alteram as categorias
	}




}//fim da classe Category

?>