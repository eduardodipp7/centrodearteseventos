<?php 

namespace Projeto\Model;
use \Projeto\Model;
use \Projeto\DB\Sql;
use \Projeto\Mailer;

class User extends Model{

	const SESSION = "User";
	const FOTO = "foto";
	const SECRET = "HcodePhp7_Secret";
	const SECRET_IV = "HcodePhp7_Secret_IV";
	const ERROR = "UserError";
	const ERROR_REGISTER = "UserErrorRegister";
	const SUCCESS = "UserSucess";

	public static function getFromSession(){

		$user = new User();

		if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0){

			$user->setData($_SESSION[User::SESSION]);
		}

		return $user;
	}

	public static function getFromSessionFoto(){

		$user = new User();

		if(isset($_SESSION[User::FOTO])){

			$user->setData($_SESSION[User::FOTO]);
		}

		return $user;
	}





	public static function checkLogin($inadmin = true){

		if(

            !isset($_SESSION[User::SESSION]) 
            || 
            !$_SESSION[User::SESSION] 
            || 
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 
		)
		{
              //Não está logado
			return false;
		}else{

			if($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true){

				return true;
			}else if ($inadmin === false){
				return true;
			}else{

				return false;
			}
		}
	}

	public static function login($login, $password){

		//vamos pegar no banco e verificar se esse login e senha existe realmente. A senha vamos comparar pelo hash

		$sql =  new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b ON a.idperson = b.idperson WHERE a.deslogin = :LOGIN", array(

                ":LOGIN"=>$login

		));

		if(count($results) === 0){
			//coloca o barra em Expetion pra pegar da raiz
			//throw new \Exception("Usuário inexistente ou senha inválida");
			header("Location: /admin/login/erro");
			exit;
		}
         
        //caso passe pela validação acima armazena a informação na variavel data
		$data = $results[0];
	    
	    //Verificar a senha do usuario

	    if(password_verify($password, $data["despassword"]) === true) 
	    {
	    	$user = new User();

	    	$data['desperson'] = utf8_encode($data['desperson']);

	    	$user->setData($data);

            //recebe os dados de user dentro da sessão em forma de array e loga no admin após a verificação da senha acima
	    	$_SESSION[User::SESSION] = $user->getValues();

	    	//Criada a sessão da foto e recebe os dados de user 
	    	$_SESSION[User::FOTO] = $user->getValues();



	    	return $user;


	    }else{

	    	//throw new \Exception("Usuário inexistente ou senha inválida");
			header("Location: /admin/login/erro");
			exit;
	    }//fim do else


	}//fim do metodo statico login

	public static function verifyLogin($inadmin = true){

		if(!User::checkLogin($inadmin)){

			if($inadmin){

			header("Location: /admin/login/");
		}else{
          header("Location: /login/");
			
		}
         exit;
		}
	}//fim do metodo verifyLogin

	public static function logout(){

		$_SESSION[User::SESSION] = NULL;
	}

	public static function listAll(){

		$sql = new Sql();

		//Realizando um Join com a tabela pessoa
		return $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) ORDER BY b.desperson");
	}

	 public static function checklist($list){
              
              //Verifica no getValues se a foto existe ou não pra se inserida no site 
              foreach ($list as &$row) {
              	
              	$u = new User();
              	$u->setData($row);
              	$row = $u->getValues();
              }
               
               //Retorna cada foto já formatado
              return $list;
	}


	public function save(){

		$sql = new Sql();

		/*
		pdesperson VARCHAR(64), 
        pdeslogin VARCHAR(64), 
        pdespassword VARCHAR(256), 
        pdesemail VARCHAR(128), 
        pnrphone BIGINT, 
        pinadmin TINYINT
		*/

		$results = $sql->select("CALL sp_users_save(:desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", array(

        ":desperson"=>utf8_encode($this->getdesperson()),
        ":deslogin"=>$this->getdeslogin(),
        ":despassword"=>User::getPasswordHash($this->getdespassword()), //aqui criptografa a senha pra ir no banco
        ":desemail"=>$this->getdesemail(),
        ":nrphone"=>$this->getnrphone(),
        ":inadmin"=>$this->getinadmin()

		));

		$this->setData($results[0]);
	}

	public function get($iduser){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING (idperson) WHERE a.iduser = :iduser", array(

          ":iduser"=>$iduser

		));

		$data = $results[0];

		$data['desperson'] = utf8_encode($data['desperson']);

		$this->setData($results[0]);
	}

	public function update(){

		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save(:iduser, :desperson, :deslogin, :despassword, :desemail, :nrphone, :inadmin)", 
		array(
		":iduser"=>$this->getiduser(),
        ":desperson"=>utf8_encode($this->getdesperson()),
        ":deslogin"=>$this->getdeslogin(),
        ":despassword"=>$this->getdespassword(),//criptograda a senha quando realiza um update da senha
        ":desemail"=>$this->getdesemail(),
        ":nrphone"=>$this->getnrphone(),
        ":inadmin"=>$this->getinadmin()

		));

		$this->setData($results[0]);

	}

	public function delete(){

		$sql = new Sql();

		$sql->query("CALL sp_users_delete(:iduser)", array(

			":iduser"=>$this->getiduser()
		));
	}

	public static function getForgot($email, $inadmin = true){

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_persons a INNER JOIN tb_users b USING(idperson) WHERE a.desemail = :email", array(
          ":email"=>$email

		));

		if(count($results) === 0)
		{
			throw new \Exception("Não foi possivel recuperar a senha");
			
		}else{

            $data = $results[0];
			$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create(:iduser, :desip)", array(
           ":iduser"=>$data["iduser"],
           ":desip"=>$_SERVER["REMOTE_ADDR"]

			));

			if(count($results2) === 0){

				throw new \Exception("Não foi possivel recuperar a senha");
				
			}else{

				$dataRecovery = $results2[0];

				$code = openssl_encrypt($dataRecovery['idrecovery'], 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));
				$code = base64_encode($code);

				if ($inadmin === true) {
					$link = "http://www.grasi.com.br/admin/forgot/reset?code=$code";
				} else {
					$link = "http://www.grasi.com.br/forgot/reset?code=$code";
					
				}	

				$mailer = new Mailer($data['desemail'], $data['desperson'], "Redefinir senha", "forgot", array(
					"name"=>$data['desperson'],
					"link"=>$link
				));				
				$mailer->send();
				return $link;		
			}
		}

	}

	public static function validForgotDecrypt($code){

		$code = base64_decode($code);
		$idrecovery = openssl_decrypt($code, 'AES-128-CBC', pack("a16", User::SECRET), 0, pack("a16", User::SECRET_IV));
		$sql = new Sql();
		$results = $sql->select("
			SELECT *
			FROM tb_userspasswordsrecoveries a
			INNER JOIN tb_users b USING(iduser)
			INNER JOIN tb_persons c USING(idperson)
			WHERE
				a.idrecovery = :idrecovery
				AND
				a.dtrecovery IS NULL
				AND
				DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
		", array(
			":idrecovery"=>$idrecovery
		));
		if (count($results) === 0)
		{
			throw new \Exception("Não foi possível recuperar a senha.");
		}
		else
		{
			return $results[0];
		}

	}

	public static function setForgotUsed($idrecovery){

		$sql = new Sql();

		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(

        ":idrecovery"=>$idrecovery

		));
	}


	public function setPassword($password){

		$sql = new Sql();

		$sql->query("UPDATE tb_users SET despassword = :password WHERE iduser = :iduser", array(
        ":password"=>$password,
        ":iduser"=>$this->getiduser()
		));
	}

	public static function setError($msg){

		$_SESSION[User::ERROR] = $msg;
	}

	public static function getError(){

		$msg = (isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR]) ? $_SESSION[User::ERROR] : '';

		User::clearError();

		return $msg;
	}

	public static function clearError(){

		$_SESSION[User::ERROR] = NULL;
	}

	public static function setErrorRegister($msg){

		$_SESSION[User::ERROR_REGISTER] = $msg;
	}

	public static function getErrorRegister(){

		$msg = (isset($SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER]) ? $_SESSION[User::ERROR_REGISTER] : '';

		User::clearErrorRegister();

       return $msg;

	}

	public static function clearErrorRegister(){

		$_SESSION[User::ERROR_REGISTER] = NULL;
	}

	public static function checkLoginExist($login){

		  $sql = new Sql();

		  $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :deslogin", [

              ':deslogin'=>$login
		  ]);

		  return (count($results) > 0);
	}



	public static function getPasswordHash($password){

		return password_hash($password, PASSWORD_DEFAULT, [
			'cost'=>12
		]);
	}

	public static function setSuccess($msg){

		$_SESSION[User::SUCCESS] = $msg;
	}

	public static function getSuccess(){

		$msg = (isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS]) ? $_SESSION[User::SUCCESS] : '';

		User::clearSuccess();

		return $msg;
	}

	public static function clearSuccess(){

		$_SESSION[User::SUCCESS] = NULL;
	}

	public function getOrders(){

		$sql = new Sql();

		$results = $sql->select("

			SELECT *
			FROM tb_orders a 
			INNER JOIN tb_ordersstatus b USING(idstatus)
			INNER JOIN tb_carts c USING(idcart)
			INNER JOIN tb_users d ON d.iduser = a.iduser
			INNER JOIN tb_addresses e USING(idaddress)
			INNER JOIN tb_persons f ON f.idperson = d.idperson
			WHERE a.iduser = :iduser
			",[
             
             ':iduser'=>$this->getiduser()

			]);

		return $results;
	}

	public static function getPage($page = 1, $itemsPerPage = 10){

		$start = ($page -1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select(" 
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_users a 
			INNER JOIN tb_persons b USING(idperson) 
			ORDER BY b.desperson
			LIMIT $start, $itemsPerPage;

			");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [

			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];
	}

	public static function getPageSearch($search, $page = 1, $itemsPerPage = 10){

		$start = ($page -1) * $itemsPerPage;

		$sql = new Sql();

		$results = $sql->select(" 
			SELECT SQL_CALC_FOUND_ROWS *
			FROM tb_users a 
			INNER JOIN tb_persons b USING(idperson) 
			WHERE b.desperson LIKE :search OR b.desemail = :search OR a.deslogin LIKE :search
			ORDER BY b.desperson
			LIMIT $start, $itemsPerPage;
         ", [
               ':search'=>'%'.$search.'%'

         ]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [

			'data'=>$results,
			'total'=>(int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsPerPage)
		];
	}


	//--------------------------------------------------------------------------------------------------------

	public function checkPhoto(){

		if(file_exists($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"res" . DIRECTORY_SEPARATOR . 
			"site" . DIRECTORY_SEPARATOR . 
			"img" . DIRECTORY_SEPARATOR . 
			"usuarios" . DIRECTORY_SEPARATOR . 
		    $this->getiduser() . ".jpg"
		    )){
            //caso exista 
			$url = "/res/site/img/usuarios/" . $this->getiduser() . ".jpg";
		}else{

			$url =  "/res/site/img/usuario_indefinido.jpg";
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
			"usuarios" . DIRECTORY_SEPARATOR . 
		    $this->getiduser() . ".jpg";

		    //$dir = $dist; //isso é um exemplo
            //mkdir($dir);
            //chmod($dir, 0777);

            $largura = 200;
            $altura = 200;
            $x = imagesx($image);//pega a largura original
            $y = imagesy($image);//pega a altura original
		    $nova = imagecreatetruecolor($largura, $altura);//redimensiona a imagem
			imagecopyresampled($nova, $image, 0, 0, 0, 0, $largura, $altura, $x, $y);
		    imagejpeg($nova, $dist); //cria a imagem 
		    imagedestroy($image);
		    imagedestroy($nova);
		   

		    $this->checkPhoto();
	}

	//----------------------------------------------------------FIM METODO FOTO --------------------------------------------------


     
	
 
}//fim da classe User

?>