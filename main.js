$(document).ready(function() {
    listarUsuarios();
    listarAtendentes();
    listarAtendimentos(0, 0, 1, 0);
 });
 
 $("#buscar_demandas" ).click(function() {
    buscarDemandas();
 });
 
 $("#cancelar_editar" ).click(function() {
    $(".modal").css("display", "none");
 });
 
 $("#incluir_demanda" ).click(function() {
   $("#incluir_demanda").css("display","none");
   $(".form-incluir-demanda").css("display","flex");
   $("html, body").animate({
       scrollTop: $(
          'html, body').get(0).scrollHeight
    }, 2000);
 });
 
 $("#salvar" ).click(function() {
    incluirDemanda();
 });
 
 $("#cancelar").click(function() {
    $("#incluir_demanda").css("display","flex");
    $(".form-incluir-demanda").css("display","none");
    limparFormularioInclusao();
 });
 
 function salvarEdicaoDemanda(id){
    let descricao = $('#descricao_editar').val();
    let custo = $('#custo_editar').val();
    let id_usuario = $('#usuario_editar').val();
    let id_atendente = $('#atendente_editar').val();
    let status = $('#status_editar').val();
    let data_previsao_atendimento = $('#data_previsao_atendimento_editar').val();
    let data_previsao_termino = $('#data_previsao_termino_editar').val();
    let observacoes = $('#observacoes_editar').val();   
 
    let acao = "salvarEdicaoDemanda";
    $.post("controller.php", 
    {
       acao: acao,
       id: id,
       descricao: descricao,
       custo: custo,
       id_usuario: id_usuario,
       id_atendente: id_atendente,
       status: status,
       data_previsao_atendimento: data_previsao_atendimento,
       data_previsao_termino: data_previsao_termino,
       observacoes: observacoes
    },
    function(result, status){
       if(status == 'success'){
          let resultado = JSON.parse(result);
          if(resultado.status == true){
             alert("Demanda editada com sucesso!");
             buscarDemandas();
             $(".modal").css("display", "none");
          }else{
             alert("Não foi possível salvar a edição do atendimento!");
          }
       }else{
          alert("Não foi possível salvar a edição do atendimento!");
       }
    });
 }
 
 function buscarDemandas(){
    let atendente = $('#atendente_filtro').val();
    let usuario = $('#usuario_filtro').val();
    let status = $('#status_filtro').val();
    let data_cadastro = $('#data_cadastro_filtro').val();
    listarAtendimentos(atendente, usuario, status, data_cadastro);
 }
 
 function listarUsuarios(){
    let acao = "listarUsuarios";
    $.post("controller.php", {acao: acao}, function(result, status){
       let resultado = JSON.parse(result);
       let usuarios = resultado.data;
       let conteudo = "";
       for (i = 0; i < usuarios.length; i++) {
          conteudo +='<option value="'+usuarios[i].id_usuario+'">'+ usuarios[i].nome +'</option>';
       }
       $('#usuario_filtro').append(conteudo);
       $('#usuario_incluir').append(conteudo);
       $('#usuario_editar').append(conteudo);
    });
 }
 
 function listarAtendentes(){
    let acao = "listarAtendentes";
    $.post("controller.php", {acao: acao}, function(result, status){
       let resultado = JSON.parse(result);
       let atendentes = resultado.data;
       let conteudo = "";
       for (i = 0; i < atendentes.length; i++) {
          conteudo +='<option value="'+atendentes[i].id_atendente+'">'+ atendentes[i].nome +'</option>';
       }
       $('#atendente_filtro').append(conteudo);
       $('#atendente_incluir').append(conteudo);
       $('#atendente_editar').append(conteudo);
    });
 }
 
 function excluirAtendimento(id_atendimento){
    let acao = "excluirAtendimento";
    $.post("controller.php", {acao: acao, id_atendimento: id_atendimento}, function(result, status){
       if(status == 'success'){
          let resultado = JSON.parse(result);
          if(resultado.status == true){
             alert("Atendimento excluído com sucesso!");
             buscarDemandas();
          }else{
             alert("Não foi possível excluir o atendimento!");
          }
       }else{
          alert("Não foi possível excluir o atendimento!");
       }
    });
 }
 
 function editarAtendimento(id_atendimento){
    let acao = "editarAtendimento";
    $.post("controller.php", {acao: acao, id_atendimento: id_atendimento}, function(result, status){
       if(status == 'success'){
          let resultado = JSON.parse(result);
          if(resultado.status == true){
             $('#descricao_editar').val(resultado.data.descricao_demanda);
             $('#custo_editar').val(resultado.data.custo);
             $('#usuario_editar').val(resultado.data.id_usuario);
             $('#atendente_editar').val(resultado.data.id_atendente);
             $('#status_editar').val(resultado.data.status);
             $('#data_previsao_atendimento_editar').val(resultado.data.data_previsao_atendimento);
             $('#data_previsao_termino_editar').val(resultado.data.data_termino_atendimento);
             $('#observacoes_editar').val(resultado.data.observacoes);
             $('#salvar_editar').attr('onclick', 'salvarEdicaoDemanda('+id_atendimento+')')
             $(".modal").css("display", "flex");
          }else{
             alert("Não foi possível recuperar dados do atendimento!");
          }
       }else{
          alert("Não foi possível recuperar dados do atendimento!");
       }
    });
 }
 
 function listarAtendimentos(atendente, usuario, status, data_cadastro){
    let acao = "listarAtendimentos";
    $.post("controller.php", 
       {
          acao: acao,
          atendente: atendente, 
          usuario: usuario,
          status: status,
          data_cadastro: data_cadastro
       }, 
       function(result, status){
          if(status == 'success'){
             let resultado = JSON.parse(result);
             if(resultado.status == true){
                let total = 0;
                let atendimentos = resultado.data;
                let conteudo = "";
                for (i = 0; i < atendimentos.length; i++) {
                   conteudo +='<div class="atendimento">';
                   conteudo +='<div class="id-demanda"><div>ID:</div><div>'+atendimentos[i].id_demanda+'</div></div>';
                   conteudo +='<div class="atendimento-descricao"><div>Descrição:</div><div>'+atendimentos[i].descricao_demanda+'</div></div>';
                   conteudo +='<div class="atendimento-custo" ><div>Custo:</div><div>'+atendimentos[i].custo+'</div></div>';
                   conteudo +='<div class="atendimento-data"><div>Cadastro:</div><div>'+atendimentos[i].data_cadastro+'</div></div>';
                   conteudo +='<div class="botoes-editar-excluir__div"><div class="botao__div botoes-editar-excluir" onclick="excluirAtendimento('+atendimentos[i].id_demanda+')">Excluir</div>';
                   conteudo +='<div class="botao__div botoes-editar-excluir" onclick="editarAtendimento('+atendimentos[i].id_demanda+')">Editar</div></div>';
                   conteudo +='</div>';
                   total += parseFloat(atendimentos[i].custo);
                }
                $('.listagem-demandas').html(conteudo);
                $('#total').html("<i>Total: "+total+"</i>");
             }else{
                $('.listagem-demandas').html("<div><i>NÃO HÁ ATENDIMENTOS CADASTRADOS</i></div>");
                $('#total').html("<i>Total: 0</i>");
             }
          }
    });
 }
 
 function incluirDemanda(){
    let acao = "incluirDemanda";
    let descricao = $('#descricao_incluir').val();
    let custo = $('#custo_incluir').val();
    let usuario = $('#usuario_incluir').val();
    let atendente = $('#atendente_incluir').val();
    let data_cadastro = $('#data_cadastro_incluir').val();
    let data_previsao_atendimento = $('#data_previsao_atendimento_incluir').val(); 
    let data_previsao_termino = $('#data_previsao_termino_incluir').val();
    let observacoes = $('#observacoes_incluir').val();
 
    $.post("controller.php",
     {
       acao: acao,
       descricao: descricao,
       custo: custo,
       usuario: usuario,
       atendente: atendente,
       data_cadastro: data_cadastro,
       data_previsao_atendimento: data_previsao_atendimento,
       data_previsao_termino: data_previsao_termino,
       observacoes: observacoes
    }, function(result, status){
       if(status == 'success'){
          let retorno = JSON.parse(result);
          if(retorno.status == true){
             alert("Demanda incluída com sucesso!");
             limparFormularioInclusao();
             $("#incluir_demanda").css("display","flex");
             $(".form-incluir-demanda").css("display","none");
             buscarDemandas();
          }else{
             alert("Não foi posssível incluir a demanda!");
          }
       }else{
          alert("Não foi posssível incluir a demanda!");
       }
    });
 }
 
 function limparFormularioInclusao(){
    $('#descricao_incluir').val("");
    $('#custo_incluir').val("");
    $('#data_cadastro_incluir').val("");
    $('#data_previsao_atendimento_incluir').val(""); 
    $('#data_previsao_termino_incluir').val("");
    $('#observacoes_incluir').val("");
 }