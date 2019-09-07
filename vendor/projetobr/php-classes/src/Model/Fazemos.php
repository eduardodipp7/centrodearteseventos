<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class Fazemos extends Model{

	public static function listAll(){

		$sql = new Sql();

		//Realizando um Join com a tabela pessoa
		return $sql->select("SELECT * FROM tb_fazemos ORDER BY destitulo");
	}

	public static function checklist($list){
              
              //Verifica no getValues se a foto existe ou não pra se inserida no site 
              foreach ($list as &$row) {
              	
              	$fa = new Fazemos();
              	$fa->setData($row);
              	$row = $fa->getValues();
              }
               
               //Retorna cada foto já formatado
              return $list;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_fazemos_save(:idfazemos, :destitulo, :destext)", array(

        ":idfazemos"=>$this->getidfazemos(),
        ":destitulo"=>$this->getdestitulo(),
        ":destext"=>$this->getdestext()

		));

		$this->setData($results[0]);

	}

	public function get($idfazemos){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_fazemos WHERE idfazemos = :idfazemos", [

			':idfazemos'=>$idfazemos

		]);

        $this->setData($results[0]);
	}

	public function delete(){


		$sql = new Sql();

		//DELETAR A IMAGEM DENTRO DA PASTA PORTFOLIO DICA USANDO UNLINK

        if (file_exists($_SERVER["DOCUMENT_ROOT"] .
            DIRECTORY_SEPARATOR . "res" .
            DIRECTORY_SEPARATOR . "site" .
            DIRECTORY_SEPARATOR . "img" .
            DIRECTORY_SEPARATOR . "fazemos" .
            DIRECTORY_SEPARATOR . $this->getidfazemos() . ".png")) {

            unlink($_SERVER["DOCUMENT_ROOT"] .
                DIRECTORY_SEPARATOR . "res" .
                DIRECTORY_SEPARATOR . "site" .
                DIRECTORY_SEPARATOR . "img" .
                DIRECTORY_SEPARATOR . "fazemos" .
                DIRECTORY_SEPARATOR . $this->getidfazemos() . ".png");
        }
       // FIM DO DELETAR A IMAGEM DA PASTA

		$sql->query("DELETE FROM tb_fazemos WHERE idfazemos = :idfazemos", [

			':idfazemos'=>$this->getidfazemos()

		]);
        
	}

	public function checkPhoto(){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"fazemos" . DIRECTORY_SEPARATOR . 
		    $this->getidfazemos() . ".png"
		    )){
            //caso exista 
			$url = "/res/site/img/fazemos/" . $this->getidfazemos() . ".png";
		}else{

			$url =  "/res/site/img/sem-foto.png";
		}

		return $this->setdesphoto($url);
	}

	public function getValues(){

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;
	}

	public function setPhoto($file){


		$extension = explode('.', $file['name']);
		$extension = end($extension);


		switch ($extension) {
			case 'jpg':
			case 'jpeg':
			    
				$image = imagecreatefromjpeg($file["tmp_name"]);
				
			
				break;

			case 'gif':
				$image = imagecreatefromgif($file["tmp_name"]);
				break;
			
			case 'png':
				$image = imagecreatefrompng($file["tmp_name"]);
				break;
		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"fazemos" . DIRECTORY_SEPARATOR . 
		    $this->getidfazemos() . ".png";

		    //$dir = $dist; //isso é um exemplo
            //mkdir($dir);
            //chmod($dir, 0777);

            $largura = 154;
            $altura = 155;
            $x = imagesx($image);//pega a largura original
            $y = imagesy($image);//pega a altura original
		    $nova = imagecreatetruecolor($largura, $altura);//redimensiona a imagem
			imagecopyresampled($nova, $image, 0, 0, 0, 0, $largura, $altura, $x, $y);
		    imagejpeg($nova, $dist); //cria a imagem 
		    imagedestroy($image);
		    imagedestroy($nova);
		   

		    $this->checkPhoto();
	}



}//fim da classe foto

?>