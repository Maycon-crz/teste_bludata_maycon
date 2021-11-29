function sairDeslogar(){
	var btSair = document.getElementById("btSair");
	if(btSair){
		btSair.addEventListener("click", function(){
			ferramentas("Aguarde", 1, 0);
			var sair = "sair";
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
			var url = baseUrl+"/source/Models/ModelLogin.php";
			$.ajax({
				url: url,
				type: "POST",
				data: {"sair": sair},
				dataType: "json",
				success: function(retorno){
					ferramentas("Aguarde", 0, 0);
					if(retorno == "saiu"){
						window.location.href = baseUrl;					
					}else{ alert(retorno); }
				}
			});
		});
	}		
}
function login(){
	$("#formLoginUsuario").submit(function(ev){
		ev.preventDefault();
		var formLoginUsuario = $("#formLoginUsuario");
		formLoginUsuario = formLoginUsuario.serialize();
		ferramentas("Aguarde", 1, 0);
		var getUrl = window.location;
		var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];		
		var url = baseUrl+"/source/Models/ModelLogin.php";
		$.ajax({
			url: url,
			type: 'POST',
			data: formLoginUsuario,
			dataType: 'json',
			success: function(retorno){
				ferramentas("Aguarde", 0, 0);
				if(retorno === "Senha certa pronto para logar!"){										
					window.location.href = baseUrl+"/painel";
				}else{ alert(retorno); }
			}
		});
	});
}
login();
sairDeslogar();