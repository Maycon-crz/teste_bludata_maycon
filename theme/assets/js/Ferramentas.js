function ferramentas(parametro, segundoparametro, terceiroparametro){	
	switch(parametro){		
		case "Recarregar":			
			location.reload();
		break;
		case "Aguarde":
			var aguarde = document.querySelector("#aguarde");
			switch(segundoparametro){
				case 0:
					aguarde.style.height = "0px";
					aguarde.innerHTML = "";
				break; 
				case 1:								
					aguarde.style.height = "50px";							
					aguarde.innerHTML = "<div class='spinner-border text-success' role='status'>"+
					"<span class='sr-only'>...</span>"+
					"</div>";
				break;	
			}
		break;
	}	
}