<?php
//Conexão com o banco
function conexaoBanco(){
    $serverName = '';
    $usuario = '';
    $senha = '';
    try{
        $db = new PDO("sqlsrv:server=$serverName ; Database=atendimentos_informatica", $usuario, $senha);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }catch(Exception $e){
        die(print_r($e->getMessage()));
    }
}

function listarUsuarios(){
    $db = conexaoBanco();
    $consulta = "SELECT id_usuario, nome FROM usuarios (nolock);";
    $stmt = $db->query( $consulta );
    $linhas = [];
    while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
        $retorno = new stdClass();
        $retorno->id_usuario = $row['id_usuario'];
        $retorno->nome = $row['nome'];
        array_push($linhas,$retorno);
    } 
    return $linhas;
}

function listarAtendentes(){
    $db = conexaoBanco();
    $consulta = "SELECT id_atendente, nome FROM atendentes (nolock);";
    $stmt = $db->query( $consulta );
    $linhas = [];
    while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
        $retorno = new stdClass();
        $retorno->id_atendente = $row['id_atendente'];
        $retorno->nome = $row['nome'];
        array_push($linhas,$retorno);
    } 
    return $linhas;
}

function incluirDemanda($descricao,$custo,$usuario,$atendente,$data_cadastro,$data_previsao_atendimento,$data_previsao_termino,$observacoes){
    $db = conexaoBanco();
    $consulta = "INSERT INTO atendimentos (descricao_demanda,custo, id_usuario, id_atendente, data_cadastro, data_previsao_atendimento, data_termino_atendimento, observacoes, status) 
    VALUES 
    ('".$descricao."', $custo, $usuario, $atendente, '".$data_cadastro."', '".$data_previsao_atendimento."', '".$data_previsao_termino."', '".$observacoes."', 2);";
    $stmt = $db->query( $consulta );
    if($stmt){
        return true;
    }else{
        return false;
    }
}

function listarAtendimentos($atendente, $usuario, $data_cadastro, $status){
    $db = conexaoBanco();
    $consulta_atendente = "";
    $consulta_usuario = "";
    $consulta_status = "";
    $consulta_data = "";
    if($atendente != 0){
        $consulta_atendente = " id_atendente = $atendente ";
    }
    if($usuario != 0){
        $consulta_usuario = " id_usuario = $usuario ";
    }
    if($status != 1){
        $consulta_status = " status = $status ";
    }
    if($data_cadastro != 0){
        $consulta_data = " data_cadastro = '$data_cadastro' ";
    }

    $consulta = "SELECT id_demanda, descricao_demanda, custo, id_usuario, id_atendente, data_cadastro, data_previsao_atendimento, data_termino_atendimento, observacoes FROM atendimentos (nolock)";

    if($consulta_atendente != "" || $consulta_usuario != "" || $consulta_status != "" || $consulta_data != ""){
        $consulta.=" WHERE ";

        if($consulta_atendente != ""){
            $consulta.= $consulta_atendente;    
        }

        if($consulta_atendente != "" && $consulta_usuario != ""){
            $consulta.= " AND ".$consulta_usuario; 
        }else{
            $consulta.= $consulta_usuario; 
        }

        if($consulta_atendente != "" && $consulta_status != ""){
            $consulta.= " AND ".$consulta_status; 
        }else if($consulta_usuario != "" && $consulta_status != ""){
            $consulta.= " AND ".$consulta_status; 
        }else{
            $consulta.= $consulta_status; 
        }

        if($consulta_atendente != "" && $consulta_data != ""){
            $consulta.= " AND ".$consulta_data; 
        }else if($consulta_usuario != "" && $consulta_data != ""){
            $consulta.= " AND ".$consulta_data; 
        }else if($consulta_status != "" && $consulta_data != ""){
            $consulta.= " AND ".$consulta_data;
        }else{
            $consulta.= $consulta_data;
        }
    }

    $stmt = $db->query( $consulta );
    $linhas = [];
    while ( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){  
        $retorno = new stdClass();
        $retorno->id_demanda = $row['id_demanda'];
        $retorno->descricao_demanda = $row['descricao_demanda'];
        $retorno->custo = $row['custo'];
        $retorno->id_usuario = $row['id_usuario'];
        $retorno->id_atendente = $row['id_atendente'];
        $retorno->data_cadastro = $row['data_cadastro'];
        $retorno->data_previsao_atendimento = $row['data_previsao_atendimento'];
        $retorno->data_termino_atendimento = $row['data_termino_atendimento'];
        $retorno->observacoes = $row['observacoes'];
        array_push($linhas,$retorno);
    } 
    return $linhas;
}

function excluirAtendimento($id){
    $db = conexaoBanco();
    $consulta = "DELETE FROM atendimentos WHERE id_demanda = $id;";
    $stmt = $db->query( $consulta );
    if($stmt){
        return true;
    }else{
        return false;
    }
}

function editarAtendimento($id){
    $db = conexaoBanco();
    $consulta = "SELECT descricao_demanda, custo, id_usuario, id_atendente, data_previsao_atendimento, data_termino_atendimento, observacoes, status FROM atendimentos (nolock) WHERE id_demanda = $id;";
    $stmt = $db->query( $consulta );
    
    if ($stmt){  
        $row = $stmt->fetch( PDO::FETCH_ASSOC );
        $retorno = new stdClass();
        $retorno->descricao_demanda = $row['descricao_demanda'];
        $retorno->custo = $row['custo'];
        $retorno->id_usuario = $row['id_usuario'];
        $retorno->id_atendente = $row['id_atendente'];
        $retorno->data_previsao_atendimento = $row['data_previsao_atendimento'];
        $retorno->data_termino_atendimento = $row['data_termino_atendimento'];
        $retorno->observacoes = $row['observacoes'];
        $retorno->status = $row['status'];
        return $retorno;
    }
}

function salvarEdicaoDemanda($id, $descricao, $custo, $id_usuario, $id_atendente, $status, $data_previsao_atendimento, $data_previsao_termino, $observacoes){
    $db = conexaoBanco();
    $consulta = "UPDATE atendimentos SET descricao_demanda = '$descricao', custo = $custo, id_usuario = $id_usuario, id_atendente = $id_atendente, status = $status, data_previsao_atendimento= '$data_previsao_atendimento', data_termino_atendimento = '$data_previsao_termino', observacoes = '$observacoes' WHERE id_demanda = $id;";
    $stmt = $db->query( $consulta );
    if($stmt){
        return true;
    }else{
        return false;
    }
}

$acao = "";
if(isset($_POST['acao'])){
    $acao = $_POST['acao'];
}

switch ($acao){
    case "listarUsuarios":
        $retorno = new stdClass();
        $configuracao = listarUsuarios();
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "Consulta realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a consulta";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;

    case "listarAtendentes":
        $retorno = new stdClass();
        $configuracao = listarAtendentes();
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "Consulta realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a consulta";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;

    case "incluirDemanda":
        $retorno = new stdClass();
        $descricao = $_POST['descricao'];
        $custo = $_POST['custo'];
        $usuario = $_POST['usuario'];
        $atendente = $_POST['atendente'];
        $data_cadastro = $_POST['data_cadastro'];
        $data_previsao_atendimento = $_POST['data_previsao_atendimento'];
        $data_previsao_termino = $_POST['data_previsao_termino'];
        $observacoes = $_POST['observacoes'];
        $configuracao = incluirDemanda($descricao,$custo,$usuario,$atendente,$data_cadastro,$data_previsao_atendimento,$data_previsao_termino,$observacoes);
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "Demanda cadastrada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel cadastrar a demanda";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;

    case "listarAtendimentos":
        $retorno = new stdClass();
        $atendente = $_POST['atendente'];
        $usuario = $_POST['usuario'];
        $data_cadastro = $_POST['data_cadastro'];
        $status = $_POST['status'];
        $configuracao = listarAtendimentos($atendente, $usuario, $data_cadastro, $status);
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "Consulta realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a consulta";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;

    case "excluirAtendimento":
        $retorno = new stdClass();
        $id_atendimento = $_POST['id_atendimento'];
        $configuracao = excluirAtendimento($id_atendimento);
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "ExclusÃ£o realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a exclusÃ£o";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;

    case "editarAtendimento":
        $retorno = new stdClass();
        $id_atendimento = $_POST['id_atendimento'];
        $configuracao = editarAtendimento($id_atendimento);
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "Consulta realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a recuperaÃ§Ã£o do registro";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;
        
    case "salvarEdicaoDemanda":
        $retorno = new stdClass();
        $id = $_POST['id'];
        $descricao = $_POST['descricao'];
        $custo = $_POST['custo'];
        $id_usuario = $_POST['id_usuario'];
        $id_atendente = $_POST['id_atendente'];
        $status = $_POST['status'];
        $data_previsao_atendimento = $_POST['data_previsao_atendimento'];
        $data_previsao_termino = $_POST['data_previsao_termino'];
        $observacoes = $_POST['observacoes'];

        $configuracao = salvarEdicaoDemanda($id, $descricao, $custo, $id_usuario, $id_atendente, $status, $data_previsao_atendimento, $data_previsao_termino, $observacoes);
        if($configuracao){
            $retorno->status = true;
            $retorno->mensagem = "EdiÃ§Ã£o realizada com sucesso";
            $retorno->data = $configuracao;
        }else{
            $retorno->status = false;
            $retorno->mensagem = "NÃ£o foi possÃ­vel realizar a ediÃ§Ã£o do registro";
            $retorno->data = null;
        }
        $retorno->mensagem = utf8_encode($retorno->mensagem);
        echo json_encode($retorno);
        break;
}
?>