<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");
	class ListagemDeFornecedores{	
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
			switch($comando){
				case "Carregar":
					$sql = "SELECT * FROM fornecedores WHERE 1=1 ORDER BY id DESC LIMIT :limite";
					$sql = $con->prepare($sql);
					$sql->bindValue(':limite', (int) $parametro, PDO::PARAM_INT);	
				break;
				case "Nome":
					$sql = "SELECT * FROM fornecedores WHERE nome LIKE :nome ORDER BY id DESC";
					$sql = $con->prepare($sql);
					$parametro = "%".$parametro."%";
					$sql->bindParam(':nome', $parametro);
				break;
				case "Documento":
					$sql = "SELECT * FROM fornecedores WHERE numero_documento LIKE :numero_documento ORDER BY id DESC";
					$sql = $con->prepare($sql);
					$parametro = $parametro."%";
					$sql->bindParam(':numero_documento', $parametro);
				break;
				case "Data":
					$horaFim =  $parametro." 23:59:59";
					$sql = "SELECT * FROM fornecedores WHERE data_cadastro BETWEEN :parametro AND :horaFim";
					$sql = $con->prepare($sql);
					$sql->bindParam(':parametro', $parametro, PDO::PARAM_STR);
					$sql->bindParam(':horaFim', $horaFim, PDO::PARAM_STR);
				break;
				default:
					echo json_encode("Erro"); exit();
				break;
			}
			if($sql->execute()){
				$result = $sql->fetchAll(PDO::FETCH_ASSOC);
				$retornado = array();
				$contador=0;
				foreach($result as $retorno){ 
					$retornado[$contador]["id"]	= $retorno["id"];
					$retornado[$contador]["empresa"]	= $retorno["empresa"];
					$retornado[$contador]["nome"]	= $retorno["nome"];
					$retornado[$contador]["tipo_documento"]	= $retorno["tipo_documento"];
					$retornado[$contador]["rg"] = $retorno["rg"];
					$retornado[$contador]["numero_documento"] = $retorno["numero_documento"];
					$retornado[$contador]["data_nascimento"] = $retorno["data_nascimento"];
					$retornado[$contador]["telefones"] = $retorno["telefones"];
					$retornado[$contador]["data_cadastro"] = $retorno["data_cadastro"];
					$contador++;
				}
				echo json_encode($retornado);
			}else{
				echo json_encode("Erro ao Listar fornecedores!");
			}
		}		
	}
	$listagemDeFornecedores = new ListagemDeFornecedores();
?>