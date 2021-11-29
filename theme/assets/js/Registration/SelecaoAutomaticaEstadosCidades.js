$(document).ready(function(){        
  carregar_json('Estado');
  function carregar_json(id, cidade_id){
    var html = '';
    //Carregando Cidades e estados GITHUB
    $.getJSON('https://gist.githubusercontent.com/letanure/3012978/raw/78474bd9db11e87de65a9d3c9fc4452458dc8a68/estados-cidades.json', function(data){
      html += '<option>Selecionar '+id+'</option>';
      if(id == 'Estado'){
        for(var i=0; i<data.estados.length; i++){
          html += '<option value='+data.estados[i].sigla+'>'+data.estados[i].nome+'</option>';
        }
      }else{
        for(var i = 0; i < data.estados.length; i++){
          if(data.estados[i].sigla == cidade_id){
            for(var j = 0; j < data.estados[i].cidades.length; j++){
              html += '<option value='+data.estados[i].cidades[j]+'>'+data.estados[i].cidades[j]+'</option>';
            }
          }
        }
      }
      $('.'+id).html(html);
    });          
  }    

  $(document).on('change', '.Estado', function(){
    var cidade_id = $(this).val();
    if(cidade_id != null){
      carregar_json('Cidade', cidade_id);
    }
  });
});