<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class Post extends Model{

	public static function listAll(){

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_posts ORDER BY desnome");
	}

	public static function checklist($list){
              
              //Verifica no getValues se a foto existe ou não pra se inserida no site 
              foreach ($list as &$row) {
              	
              	$p = new Post();
              	$p->setData($row);
              	$row = $p->getValues();
              }
               
               //Retorna cada foto já formatado
              return $list;
	}

	public function save(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_posts_save(:idpost, :desnome, :destexto)", array(

        ":idpost"=>$this->getidpost(),
        ":desnome"=>$this->getdesnome(),
        ":destexto"=>$this->getdestexto()

		));

		$this->setData($results[0]);

	}

	public function get($idpost){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_posts WHERE idpost = :idpost", [

			':idpost'=>$idpost

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
            DIRECTORY_SEPARATOR . "depoimentos" .
            DIRECTORY_SEPARATOR . $this->getidpost() . ".jpg")) {

            unlink($_SERVER["DOCUMENT_ROOT"] .
                DIRECTORY_SEPARATOR . "res" .
                DIRECTORY_SEPARATOR . "site" .
                DIRECTORY_SEPARATOR . "img" .
                DIRECTORY_SEPARATOR . "depoimentos" .
                DIRECTORY_SEPARATOR . $this->getidpost() . ".jpg");
        }
       // FIM DO DELETAR A IMAGEM DA PASTA

		$sql->query("DELETE FROM tb_posts WHERE idpost = :idpost", [

			':idpost'=>$this->getidpost()

		]);
        
	}

	public function checkPhoto(){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"depoimentos" . DIRECTORY_SEPARATOR . 
		    $this->getidpost() . ".jpg"
		    )){
            //caso exista 
			$url = "/res/site/img/depoimentos/" . $this->getidpost() . ".jpg";
		}else{

			$url =  "/res/site/img/depoimentos/post-sem.jpg";
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
			"depoimentos" . DIRECTORY_SEPARATOR . 
		    $this->getidpost() . ".jpg";

		    //$dir = $dist; //isso é um exemplo
            //mkdir($dir);
            //chmod($dir, 0777);

            $largura = 127;
            $altura = 127;
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