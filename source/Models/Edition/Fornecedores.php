<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");
	class EdicaoDeFornecedores{	
		public function __construct(){
			$con = Connection::getConn();
			$ferramentas = new Ferramentas;
			if(session_status() === PHP_SESSION_NONE){ session_start(); }
			if($_SESSION['login'] == "sim"){
				if(isset($_POST['nomeFornecedor'])){				
					$this->validacao($con, $ferramentas);
				}
				if(isset($_POST['excluir'])){				
					$this->excluir($con, $ferramentas);				
				}
			}
		}
		private function validacao($con, $ferramentas){
			$dados = array();
			//Captura
			$dados['id'] = $_POST['id'] ?? "";
			$dados['Empresa'] = $_POST['Empresa'] ?? "";
			$dados['UF'] = $_POST['UF'] ?? "";
			$dados['nomeFornecedor'] = $_POST['nomeFornecedor'] ?? "";						
			$dados['tipo_documento'] = $_POST['tipo_documento'] ?? "";
			$dados['documento_cpf'] = $_POST['documento_cpf'] ?? "";
			$dados['documento_cnpj'] = $_POST['documento_cnpj'] ?? "";
			$dados['rg'] = $_POST['rg'] ?? "";
			$dados['data_nascimento'] = $_POST['data_nascimento'] ?? "";			
			//Filtra
			$dados['id'] = $ferramentas->filtrando($dados['id']);
			$dados['Empresa'] = $ferramentas->filtrando($dados['Empresa']);
			$dados['UF'] = $ferramentas->filtrando($dados['UF']);
			$dados['nomeFornecedor'] = $ferramentas->filtrando($dados['nomeFornecedor']);						
			$dados['tipo_documento'] = $ferramentas->filtrando($dados['tipo_documento']);
			$dados['documento_cpf'] = $ferramentas->filtrando($dados['documento_cpf']);
			$dados['documento_cnpj'] = $ferramentas->filtrando($dados['documento_cnpj']);
			$dados['rg'] = $ferramentas->filtrando($dados['rg']);
			$dados['data_nascimento'] = $ferramentas->filtrando($dados['data_nascimento']);
			//Valida
			$msg = ($dados['Empresa'] == "Selecionar Empresa Cadastrada") ? "Selecione uma Empresa!" : "";			
			$msg = ($msg == "") ? ($dados['nomeFornecedor'] == "") ? "Informe o nome do fornecedor" : "": $msg;			
			
			if($dados['tipo_documento'] == "CPF" || $dados['tipo_documento'] == "CNPJ"){
				//Valida Pessoa fisíca
				if($dados['tipo_documento'] == "CPF"){
					$msg = ($msg == "") ? ($dados['documento_cpf'] == "") ? "Informe o CPF" : "": $msg;
					$msg = ($msg == "") ? ($dados['rg'] == "") ? "Informe o RG" : "": $msg;
					$msg = ($msg == "") ? (strlen($dados['rg']) != 12) ? "Informe o RG corretamente" : "": $msg;				
					$msg = ($msg == "") ? ($dados['data_nascimento'] == "") ? "Informe sua data de nascimento" : "": $msg;				
					if($dados['UF'] == "PR" && $msg == ""){
						$anoAtual = date("Y");
						$anoNascimento = substr($dados['data_nascimento'], 0, 4);
						$idade = ($anoAtual-$anoNascimento);
						$msg = ($msg == "") ? ($idade < 18) ? "Não é permitido cadastrar um fornecedor pessoa física menor de idade!" : "": $msg;
					}
					$dados['numero_documento'] = $dados['documento_cpf'];
				}else{
					$msg = ($msg == "") ? ($dados['documento_cnpj'] == "") ? "Informe o CNPJ" : "": $msg;
					$dados['numero_documento'] = $dados['documento_cnpj'];
				}
			}else{
				$msg = "Erro";
			}
			//Telefones dinâmicos
			$telefones="";
			for($i=0;$i<=4;$i++){
				$telefone = $_POST['telefone'.$i] ?? "";
				if($telefone != ""){
					$caracteres = strlen($telefone);
					if($caracteres <= 15){
						$telefones .= $_POST['telefone'.$i]."#";
					}
				}
			}
			$msg = ($msg == "") ? ($telefones == "") ? "Cadastre pelo menos 1 telefone" : "OK": $msg;
			$dados['telefones'] = $ferramentas->filtrando($telefones);
			if($msg == "OK"){
				$this->atualizar($con, $dados);
			}else{
				echo json_encode($msg);
			}
		}
		private function atualizar($con, $dados){
			$sql = "UPDATE fornecedores SET empresa=:empresa, nome=:nome, numero_documento=:numero_documento, rg=:rg, telefones=:telefones, data_nascimento=:data_nascimento WHERE id=:id";	
			$sql = $con->prepare($sql);
			$sql->bindParam(":empresa", $dados['Empresa']);
			$sql->bindParam(":nome", $dados['nomeFornecedor']);
			$sql->bindParam(":numero_documento", $dados['numero_documento']);
			$sql->bindParam(":rg", $dados['rg']);
			$sql->bindParam(":telefones", $dados['telefones']);
			$sql->bindParam(":data_nascimento", $dados['data_nascimento']);
			$sql->bindParam(":id", $dados['id']);
			if($sql->execute()){
				echo json_encode("Fornecedor Editado com sucesso!");
			}else{
				echo json_encode("Erro ao Editar Fornecedor!");
			}
		}
		private function excluir($con, $ferramentas){
			$id = $_POST['excluir'] ?? "";
			$id = $ferramentas->filtrando($id);			
			$sql = "DELETE FROM fornecedores WHERE id=:id";
			$sql = $con->prepare($sql);		
			$sql->bindParam(":id", $id);
			if($sql->execute()){
				echo json_encode("Exluido com sucesso");					
			}else{ echo json_encode("Erro ao Exluir"); }
		}		
	}
	$edicaoDeFornecedores = new EdicaoDeFornecedores();
?>