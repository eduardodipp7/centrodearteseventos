<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class Foto extends Model{

	public static function listAll(){

		$sql = new Sql();

		//Realizando um Join com a tabela pessoa
		return $sql->select("SELECT * FROM tb_fotos ORDER BY desfoto");
	}

	public static function checklist($list){
              
              //Verifica no getValues se a foto existe ou não pra se inserida no site 
              foreach ($list as &$row) {
              	
              	$f = new Foto();
              	$f->setData($row);
              	$row = $f->getValues();
              }
               
               //Retorna cada foto já formatado
              return $list;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_fotos_save(:idfoto, :desfoto)", array(

        ":idfoto"=>$this->getidfoto(),
        ":desfoto"=>$this->getdesfoto()

		));

		$this->setData($results[0]);

	}

	public function get($idfoto){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_fotos WHERE idfoto = :idfoto", [

			':idfoto'=>$idfoto

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
            DIRECTORY_SEPARATOR . "portfolio" .
            DIRECTORY_SEPARATOR . $this->getidfoto() . ".jpg")) {

            unlink($_SERVER["DOCUMENT_ROOT"] .
                DIRECTORY_SEPARATOR . "res" .
                DIRECTORY_SEPARATOR . "site" .
                DIRECTORY_SEPARATOR . "img" .
                DIRECTORY_SEPARATOR . "portfolio" .
                DIRECTORY_SEPARATOR . $this->getidfoto() . ".jpg");
        }
       // FIM DO DELETAR A IMAGEM DA PASTA

		$sql->query("DELETE FROM tb_fotos WHERE idfoto = :idfoto", [

			':idfoto'=>$this->getidfoto()

		]);
        
	}

	public function checkPhoto(){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"portfolio" . DIRECTORY_SEPARATOR . 
		    $this->getidfoto() . ".jpg"
		    )){
            //caso exista 
			$url = "/res/site/img/portfolio/" . $this->getidfoto() . ".jpg";
		}else{

			$url =  "/res/site/img/foto3.jpg";
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
			"portfolio" . DIRECTORY_SEPARATOR . 
		    $this->getidfoto() . ".jpg";

		    //$dir = $dist; //isso é um exemplo
            //mkdir($dir);
            //chmod($dir, 0777);

            $largura = 960;
            $altura = 648;
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