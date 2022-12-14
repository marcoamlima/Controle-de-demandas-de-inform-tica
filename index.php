<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
<title>Demandas de informática</title>
<!-- CSS -->
<link rel=stylesheet href="style.css">
</head>
<body>
<div class='conteudo'>
   <div class="titulo"><strong>DEMANDAS DE INFORMÁTICA</strong></div>
   <div class="filtro">
      <div class="filtro--linha">
         <div class="filtro--item">
            <div>Atendente</div>
            <div><select id="atendente_filtro"><option value='0'>Todos</option></select></div>
         </div> 
         <div class="filtro--item">
            <div>Usuários</div>
            <div><select id="usuario_filtro"><option value='0'>Todos</option></select></div>
         </div>
      </div>
      <div class="filtro--linha">
         <div class="filtro--item">
            <div>Status</div>
            <div>
               <select id="status_filtro">
                  <option value="1">Todas</option>
                  <option value="2">Pendentes</option>
                  <option value="3">Finalizadas</option>
               </select>
            </div>
         </div>
         <div class="filtro--item">
            <div>Data de cadastro</div>
            <div><input id="data_cadastro_filtro" type="date" value='<?php echo date("Y-m-d"); ?>'></div>
         </div>
      </div>
      <div class="filtro--linha buscar">
         <div class="botao__div" id="buscar_demandas">
            Buscar
         </div>
      </div>
      <div id="total">
      </div>
   </div>
   <div class="listagem-demandas">
      <div><i>NÃO HÁ ATENDIMENTOS CADASTRADOS</i></div>
   </div>
   <div class="botao__div incluir-demanda" id="incluir_demanda">
         + Incluir nova demanda
   </div>
   <div class="form-incluir-demanda">
      <div>
         <div><strong>INCLUSÃO DE NOVA DEMANDA DE ATENDIMENTO</strong></div>
      </div>
      <hr>
      <div>
         <div>
            <div>Descrição</div>
            <div><input id="descricao_incluir" type="text"></div>
         </div>
         <div>
            <div>Custo</div>
            <div><input id="custo_incluir" type="number"></div>
         </div>
      </div>
      <div>
         <div>
            <div>Usuário</div>
            <div><select id="usuario_incluir"></select></div>
         </div>
         <div>
            <div>Atendente</div>
            <div><select id="atendente_incluir"></select></div>
         </div>
      </div>
      <div>
         <div>
            <div>Data de cadastro</div>
            <div><input id="data_cadastro_incluir" value='<?php echo date("Y-m-d"); ?>' type="date"></div>
         </div>
      </div>
      <div>
         <div>
            <div>Data de previsão de atendimento</div>
            <div><input id="data_previsao_atendimento_incluir" value='<?php echo date("Y-m-d"); ?>' type="date"></div>
         </div>
         <div>
            <div>Data de previsão de termino</div>
            <div><input id="data_previsao_termino_incluir" value='<?php echo date("Y-m-d"); ?>' type="date"></div>
         </div>
      </div>
      <div>
         <div>Observações</div>
         <div><textarea class="observacoes__textarea" id="observacoes_incluir"></textarea></div>
      </div>
      <div class="botoes-acao">
         <div class="botao__div" id="salvar">
            Salvar
         </div>
         <div class="botao__div" id="cancelar">
            Cancelar
         </div>
      </div>
   </div>
</div>

<div class="modal">
   <div class="modal__content">
   <div class="form-editar-demanda">
      <div>
         <div><strong>EDITAR DEMANDA DE ATENDIMENTO</strong></div>
      </div>
      <div>
         <div>
            <div>Descrição</div>
            <div><input id="descricao_editar" type="text"></div>
         </div>
         <div>
            <div>Custo</div>
            <div><input id="custo_editar" type="number"></div>
         </div>
      </div>
      <div>
         <div>
            <div>Usuário</div>
            <div><select id="usuario_editar"></select></div>
         </div>
         <div>
            <div>Atendente</div>
            <div><select id="atendente_editar"></select></div>
         </div>
         <div>
            <div>Status</div>
            <div>
               <select id="status_editar">
                  <option value="2">Pendente</option>
                  <option value="3">Finalizada</option>
               </select>
            </div>
         </div>
      </div>
      <div>
         <div>
            <div>Data de previsão de atendimento</div>
            <div><input id="data_previsao_atendimento_editar" type="date"></div>
         </div>
         <div>
            <div>Data de previsão de termino</div>
            <div><input id="data_previsao_termino_editar" type="date"></div>
         </div>
      </div>
      <div>
         <div>Observações</div>
         <div><textarea class="observacoes__textarea" id="observacoes_editar"></textarea></div>
      </div>
      <div class="botoes-acao">
         <div class="botao__div" id="salvar_editar">
            Salvar
         </div>
         <div class="botao__div" id="cancelar_editar">
            Cancelar
         </div>
      </div>
   </div>      
   </div>
</div>

<!-- jquery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="main.js"></script>
</body>
</html>