<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");	
	class ListagemDeEmpresas{
		public function __construct(){
			$con = Connection::getConn();			
			$ferramentas = new Ferramentas;				
			if(session_status() === PHP_SESSION_NONE){ session_start(); }
			if(isset($_POST['comando']) && $_SESSION['login'] == "sim"){
				$this->listagem($con, $ferramentas);
			}
		}	
		private function listagem($con, $ferramentas){
			$comando = $ferramentas->filtrando($_POST['comando']);
			$parametro = $ferramentas->filtrando($_POST['parametro']);
			if($comando == 'Carregar'){
				$sql = "SELECT * FROM empresas WHERE 1=1 ORDER BY id DESC LIMIT :limite";
				$sql = $con->prepare($sql);
				$sql->bindValue(':limite', (int) $parametro, PDO::PARAM_INT);	
			}else{
				$sql = "SELECT * FROM empresas WHERE nome LIKE :nome ORDER BY id DESC";
				$sql = $con->prepare($sql);
				$parametro = "%".$parametro."%";
				$sql->bindParam(':nome', $parametro);
			}
			if($sql->execute()){
				$result = $sql->fetchAll(PDO::FETCH_ASSOC);
				$retornado = array();
				$contador=0;
				foreach($result as $retorno){ 
					$retornado[$contador]["id"]		= $retorno["id"];
					$retornado[$contador]["nome"]	= $retorno["nome"];
					$retornado[$contador]["estado"]	= $retorno["estado"];
					$retornado[$contador]["cidade"]	= $retorno["cidade"];
					$retornado[$contador]["cnpj"]	= $retorno["cnpj"];
					$retornado[$contador]["data"] 	= $retorno["data"];
					$contador++;
				}
				echo json_encode($retornado);
			}else{
				echo json_encode("Erro ao Listar Empresas!");
			}
		}	
	}
	$listagemDeEmpresas = new ListagemDeEmpresas();
?>