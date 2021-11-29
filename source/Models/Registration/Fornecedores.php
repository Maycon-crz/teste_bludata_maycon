<?php
	require_once("../Lib/Conn.php");
	require_once("../Ferramentas.php");	
	class CadastroDeFornecedores{
		public function __construct(){			
			$con = Connection::getConn();
			$ferramentas = new Ferramentas;
			if(session_status() === PHP_SESSION_NONE){ session_start(); }	
			if($_SESSION['login'] == "sim"){
				if(isset($_POST['selectEmpresas'])){
					$this->carregarEmpresasParaSelect($con);				
				}
				if(isset($_POST['Empresa'])){
					$this->validacao($con, $ferramentas);
				}
			}
		}
		private function validacao($con, $ferramentas){			
			$dados = array();
			//Captura
			$dados['Empresa'] = $_POST['Empresa'] ?? "";
			$dados['UF'] = $_POST['UF'] ?? "";
			$dados['nomeFornecedor'] = $_POST['nomeFornecedor'] ?? "";						
			$dados['tipo_documento'] = $_POST['tipo_documento'] ?? "";
			$dados['rg'] = $_POST['rg'] ?? "";
			$dados['documento_cpf'] = $_POST['documento_cpf'] ?? "";
			$dados['documento_cnpj'] = $_POST['documento_cnpj'] ?? "";

			$dados['data_nascimento'] = $_POST['data_nascimento'] ?? "";	
			
			//Filtra
			$dados['Empresa'] = $ferramentas->filtrando($dados['Empresa']);
			$dados['UF'] = $ferramentas->filtrando($dados['UF']);
			$dados['nomeFornecedor'] = $ferramentas->filtrando($dados['nomeFornecedor']);						
			$dados['tipo_documento'] = $ferramentas->filtrando($dados['tipo_documento']);
			$dados['rg'] = $ferramentas->filtrando($dados['rg']);
			$dados['documento_cpf'] = $ferramentas->filtrando($dados['documento_cpf']);
			$dados['documento_cnpj'] = $ferramentas->filtrando($dados['documento_cnpj']);
			$dados['data_nascimento'] = $ferramentas->filtrando($dados['data_nascimento']);
			//Valida
			$msg = ($dados['Empresa'] == "") ? "Selecione uma Empresa!" : "";			
			$msg = ($msg == "") ? ($dados['nomeFornecedor'] == "") ? "Informe o nome do fornecedor" : "": $msg;						
			$msg = ($msg == "") ? ($dados['tipo_documento'] == "") ? "Selecione entre CPF OU CNPJ" : "": $msg;
			//Valida Pessoa fisíca
			if($dados['tipo_documento'] == "CPF"){				
				$msg = ($msg == "") ? ($dados['documento_cpf'] == "") ? "Informe o CPF" : "": $msg;
				$msg = ($msg == "") ? (strlen($dados['rg']) != 12) ? "Informe o RG corretamente" : "": $msg;				
				$msg = ($msg == "") ? ($dados['data_nascimento'] == "") ? "Informe sua data de nascimento" : "": $msg;				
				if($dados['UF'] == "PR" && $msg == ""){
					$anoAtual = date("Y");
					$anoNascimento = substr($dados['data_nascimento'], 0, 4);
					$idade = ($anoAtual-$anoNascimento);
					$msg = ($msg == "") ? ($idade < 18) ? "Não é permitido cadastrar um fornecedor pessoa física menor de idade de empresas do Paraná!" : "": $msg;					
				}
				$dados['numero_documento'] = $dados['documento_cpf'];
			}else{
				$msg = ($msg == "") ? ($dados['documento_cnpj'] == "") ? "Informe o CNPJ" : "": $msg;
				$dados['numero_documento'] = $dados['documento_cnpj'];
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
				$this->cadastro($con, $dados);
			}else{
				echo json_encode($msg);
			}
		}
		private function cadastro($con, $dados){
			date_default_timezone_set('America/Sao_Paulo');
			$data = date("Y-m-d H:i:s");
			$sql = "INSERT INTO fornecedores(empresa, nome, tipo_documento, numero_documento, rg, telefones, data_nascimento, data_cadastro) VALUES(:empresa, :nome, :tipo_documento, :numero_documento, :rg, :telefones, :data_nascimento, :data_cadastro)";
			$sql = $con->prepare($sql);			
			$sql->bindParam("empresa", $dados['Empresa']);
			$sql->bindParam("nome", $dados['nomeFornecedor']);
			$sql->bindParam("tipo_documento", $dados['tipo_documento']);
			$sql->bindParam("numero_documento", $dados['numero_documento']);
			$sql->bindParam("rg", $dados['rg']);
			$sql->bindParam("telefones", $dados['telefones']);
			$sql->bindParam("data_nascimento", $dados['data_nascimento']);
			$sql->bindParam("data_cadastro", $data);
			if($sql->execute()){
				echo json_encode("Fornecedor cadastrado com sucesso!");
			}else{
				echo json_encode("Erro ao cadastrar Fornecedor!");
			}
		}
		private function carregarEmpresasParaSelect($con){
			$sql = "SELECT * FROM empresas";
			$sql = $con->prepare($sql);
			if($sql->execute()){
				$result = $sql->fetchAll(PDO::FETCH_ASSOC);				
				$dados = array();
				$contador=0;				
				foreach($result as $empresas){
					$dados[$contador]['nome'] = $empresas['nome'];
					$dados[$contador]['UF'] = $empresas['estado'];
					$contador++;
				}
				echo json_encode($dados);
			}else{
				echo json_encode("Erro");
			}
		}
	}
	$cadastroDeFornecedores = new CadastroDeFornecedores();
?>