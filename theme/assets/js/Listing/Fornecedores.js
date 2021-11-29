class ListagemDeFornecedores{
	constructor(){
		this.buscador(this);
		this.toggleListagem(this);
	}
	listagem(objeto, comando, parametro){
		ferramentas("Aguarde", 1, 0);
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
		var url = baseUrl+"/source/Models/Listing/Fornecedores.php";
		$.ajax({
			url: url,
			type: 'POST',
			data: {'comando': comando, 'parametro': parametro},
			dataType: 'json',
			success: function(retorno){				
				ferramentas("Aguarde", 0, 0);				
				var fornecedores="";
				for(let i=0; i<retorno.length; i++){
					fornecedores+="<form id='formEdicaoDeFornecedores"+retorno[i].id+"'>";					
					fornecedores+="<ul class='border border-warning mt-3 p-0 text-center'>";
					fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Nome</label><input type='text' name='nomeFornecedor' value='"+retorno[i]['nome']+"' class='form-control p-1 me-3' /></li>";
					fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Empresa</label><input type='text' name='Empresa' value='"+retorno[i]['empresa']+"' class='form-control p-1 me-3' /></li>";
					fornecedores+="<li><input type='hidden' name='tipo_documento' value='"+retorno[i]['tipo_documento']+"' class='form-control p-1 me-3' /></li>";
					if(retorno[i]['tipo_documento'] == "CPF"){
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Pessoa física</label></li>";
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>CPF</label><input type='text' name='documento_cpf' value='"+retorno[i]['numero_documento']+"' class='form-control p-1 me-3 cpfMasck' /></li>";
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>RG</label><input type='text' name='rg' value='"+retorno[i]['rg']+"' class='form-control p-1 me-3 rgMasck' /></li>";	
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Data Nascimento</label><input type='text' name='data_nascimento' value='"+retorno[i]['data_nascimento']+"' class='form-control p-1 me-3' /></li>";
					}else{
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Pessoa Jurídica</label></li>";
						fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>CNPJ</label><input type='text' name='documento_cnpj' value='"+retorno[i]['numero_documento']+"' class='form-control p-1 me-3 cnpjMasck' /></li>";
					}
					fornecedores+=objeto.separarTelefones(retorno[i].telefones, i);
					fornecedores+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Data Cadastro "+retorno[i]['data_cadastro']+"</label></li>";
					fornecedores+="<li class='border p-3'>";
					fornecedores+="<button type='button' value='"+retorno[i].id+"' class='form-control btn btn-lg btn-outline-success my-3 btEditarFornecedor'>Editar</button>";
					fornecedores+="<button type='button' value='"+retorno[i].id+"' class='form-control btn btn-lg btn-outline-danger btExcluirFornecedor'>Excluir</button>";
					fornecedores+="</li><li><input type='hidden' name='id' value='"+retorno[i].id+"' /></li></ul>";
					fornecedores+="</form>";
				}
				if(!isNaN(parametro)) {
					parametro = parseInt(parametro)+parseInt(4);
				 	fornecedores+="<ul class='border border-warning mt-3 p-0 text-center'><li>";
				 	fornecedores+="<button type='button' value='"+parametro+"' class='form-control btn btn-lg btn-outline-primary btMostrarMaisFornecedores'>Mostrar Mais +</button>";
				 	fornecedores+="</li></ul>";
				}else{
					fornecedores+="<ul class='border border-warning mt-3 p-0 text-center'><li>";
				 	fornecedores+="<button type='button' value='4' class='form-control btn btn-lg btn-outline-primary btMostrarMaisFornecedores'>Mostrar Mais +</button>";
				 	fornecedores+="</li></ul>";
				}				
				$("#carregarFornecedores").html(fornecedores);				
				objeto.mostrarMais(objeto);
				objeto.mascaraDeCPF();
				objeto.mascaraDeRG();
				objeto.mascaraDeCNPJ();
				objeto.mascaraDeTelefone();
				/*Chama edicao*/
				let editarDeletarFornecedores = new EditarDeletarFornecedores();
			}
		});
	}
	buscador(objeto){
		var tipoDeBusca = "Nome";
		$("input[name='tipoDeBuscaFornecedor']").click(function(){			
			tipoDeBusca = $(this).val();
			if($(this).val() == "Data"){
			 	$("#divBuscaPorData").show();
			 	$("#ChaveFornecedor").val("");
			}else{
				$("#divBuscaPorData").hide();
			}
		});
		$("#buscadorFornecedores").submit(function(evento){
			evento.preventDefault();
			let chave = "";
			if(tipoDeBusca == "Data"){
				chave = $("#inputDataCadastroFornecedor").val();
			}else{
				chave = $("#ChaveFornecedor").val();
			}
			objeto.listagem(objeto, tipoDeBusca, chave);
		});
	}
	toggleListagem(objeto){
		$(".btAbreListagemDeFornecedores").on("click", function(){
			$("#LinhaListagemEmpresas").hide();
			$("#LinhaListagemFornecedores").toggle();			
			objeto.listagem(objeto, "Carregar", 4);
		});
	}
	separarTelefones(telefones, id){
		var splits = telefones.split('#');
		var inputsTelefones="";
		for(let i=0; i<splits.length; i++){
			if(splits[i] != ""){
				inputsTelefones+="<li class='border p-3 text-center'><label class='form-control p-0 shadow-lg'>Telefone</label><input type='text' name='telefone"+i+"' value='"+splits[i]+"' class='form-control p-1 me-3 telefoneMask' /></li>";
			}			
		}
		return inputsTelefones;
	}
	mostrarMais(objeto){
		$(".btMostrarMaisFornecedores").click(function(){			
			objeto.listagem(objeto, "Carregar", $(this).val());
		});
	}
	mascaraDeCPF(){
		 $('.cpfMasck').mask('000.000.000-00', {reverse: true});
	}
	mascaraDeRG(){
		 $('.rgMasck').mask('99.999.999-9');
	}
	mascaraDeCNPJ(){
		$(".cnpjMasck").mask("99.999.999/9999-99");
	}
	mascaraDeTelefone(){
		 $(".telefoneMask").mask("(00) 0000-00000");
	}
}
let listagemDeFornecedores = new ListagemDeFornecedores();