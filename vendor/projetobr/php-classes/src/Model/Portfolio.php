<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class Portfolio extends Model{

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_portfolios ORDER BY destitulo");
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_portfolios_save(:idport, :destitulo, :destexto)", array(

        ":idport"=>$this->getidport(),
        ":destitulo"=>$this->getdestitulo(),
        ":destexto"=>$this->getdestexto()

		));

		$this->setData($results[0]);

	}

	public function get($idport){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_portfolios WHERE idport = :idport", [

			':idport'=>$idport

		]);

        $this->setData($results[0]);
	}

	public function delete(){


		$sql = new Sql();


		$sql->query("DELETE FROM tb_portfolios WHERE idport = :idport", [

			':idport'=>$this->getidport()

		]);
        
	}

 

}//fim da classe Portfolio

?>