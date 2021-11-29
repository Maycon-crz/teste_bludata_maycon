class ListagemDeEmpresa{
	constructor(){
		this.buscador(this);
		this.toggleListagem(this);
	}
	listagem(objeto, comando, parametro){
		ferramentas("Aguarde", 1, 0);
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
		var url = baseUrl+"/source/Models/Listing/Empresas.php";
		$.ajax({
			url: url,
			type: 'POST',
			data: {'comando': comando, 'parametro': parametro},
			dataType: 'json',
			success: function(retorno){				
				ferramentas("Aguarde", 0, 0);
				var empresas="";
				for(let i=0; i<retorno.length; i++){
					empresas+="<form id='formEdicaoDeEmpresas"+retorno[i].id+"'>";
					empresas+="<ul class='border border-warning mt-3 p-0 text-center'>";
					empresas+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Nome</label><input type='text' name='NomeFantasia' value='"+retorno[i]['nome']+"' class='form-control p-1 me-3 rounded' /></li>";
					empresas+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Estado</label><input type='text' name='Estado' value='"+retorno[i]['estado']+"' class='form-control p-1 me-3 rounded' /></li>";
					empresas+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Cidade</label><input type='text' name='Cidade' value='"+retorno[i]['cidade']+"' class='form-control p-1 me-3 rounded' /></li>";
					empresas+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>CNPJ</label><input type='text' name='CNPJ' value='"+retorno[i]['cnpj']+"' class='form-control p-1 me-3 rounded cnpjMasck' /></li>";
					empresas+="<li class='border p-3'><label class='form-control p-0 shadow-lg'>Data de cadastro: "+retorno[i]['data']+"</label>";
					empresas+="<button type='button' value='"+retorno[i].id+"' class='form-control btn btn-lg btn-outline-success my-3 btEditarEmpresa'>Editar</button>";
					empresas+="<button type='button' value='"+retorno[i]['nome']+"' id='"+retorno[i].id+"' class='form-control btn btn-lg btn-outline-danger btExcluirEmpresa'>Excluir</button>";
					empresas+="</li><li><input type='hidden' name='id' value='"+retorno[i].id+"' /></li></ul>";
					empresas+="</form>";
				}
				if(!isNaN(parametro)) {
					parametro = parseInt(parametro)+parseInt(4);
				 	empresas+="<ul class='border border-warning mt-3 p-0 text-center'><li>";
				 	empresas+="<button type='button' value='"+parametro+"' class='form-control btn btn-lg btn-outline-primary btMostrarMaisEmpresas'>Mostrar Mais +</button>";
				 	empresas+="</li></ul>";
				}else{
					empresas+="<ul class='border border-warning mt-3 p-0 text-center'><li>";
				 	empresas+="<button type='button' value='4' class='form-control btn btn-lg btn-outline-primary btMostrarMaisEmpresas'>Mostrar Mais +</button>";
				 	empresas+="</li></ul>";
				}				
				$("#carregarEmpresas").html(empresas);
				let editarDeletarEmpresa = new EditarDeletarEmpresa();
				objeto.mascaraDeCNPJ();
				objeto.mostrarMais(objeto);
			}
		});
	}
	buscador(objeto){
		$("#buscadorEmpresas").submit(function(evento){
			evento.preventDefault();
			let chave = $("#chaveEmpresa").val();
			objeto.listagem(objeto, "Busca", chave);
		});
	}
	toggleListagem(objeto){
		$(".btAbreListagemDeEmpresas").on("click", function(){
			$("#LinhaListagemEmpresas").toggle();
			objeto.listagem(objeto, "Carregar", 4);
		});
	}
	mascaraDeCNPJ(){
		$(".cnpjMasck").mask("99.999.999/9999-99");
	}
	mostrarMais(objeto){
		$(".btMostrarMaisEmpresas").click(function(){			
			objeto.listagem(objeto, "Carregar", $(this).val());
		});
	}
}
let listagemDeEmpresa = new ListagemDeEmpresa();