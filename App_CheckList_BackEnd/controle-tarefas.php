<?php
  //sempre reafirmar a pasta que estou recuperando os dados para evitar conflitos de contexto

 require "../../App_CheckList_BackEnd/conexao.php";
 require "../../App_CheckList_BackEnd/tarefa-modelo.php";
 require "../../App_CheckList_BackEnd/tarefa-server.php"; 

 $acao =  isset($_GET['acao']) ? $_GET['acao'] : $acao;     // condicao ? expressao1 (sera executada caso seja true) : expressao2 (executada se for false)

 if ($acao == 'inserir') {

  $tarefa = new Tarefa();
  $tarefa->__set('tarefa', $_POST['tarefa']); 

  $conexao = new Conexao();

  $tarefaServer = new TarefaServer($conexao, $tarefa);
  $tarefaServer->inserir();

  header('Location: nova_tarefa.php?enviado=1');



} else if ($acao == 'recuperar') {
  
  $tarefa = new Tarefa();
  $conexao = new Conexao();

  $tarefaServer = new TarefaServer($conexao, $tarefa);
  $tarefas = $tarefaServer->recuperar();




} else if ($acao == 'atualiza') {

   $tarefa = new Tarefa();
   $tarefa->__set('id', $_POST['id']);
   $tarefa->__set('tarefa', $_POST['tarefa']);

   $conexao = new Conexao();

   $tarefaServer = new TarefaServer($conexao, $tarefa);
   if($tarefaServer->atualizar()) {  //Aqui uso o if pois quando algo é atualizado ele retorna 1 então apenas para segurança
   
   if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
     header('location: index.php');
   } else {
    header('location: todas_tarefas.php');
   }
  }

} else if ($acao == 'remover'){
  
  $tarefa = new Tarefa();
  $tarefa->__set('id', $_GET['id']);

  $conexao = new Conexao();

  $tarefaServer = new TarefaServer($conexao, $tarefa);
  $tarefaServer->remover();

  if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
    header('location: index.php');
  } else {
   header('location: todas_tarefas.php');
  }

  
} else if ($acao == 'realizada'){
  
  $tarefa = new Tarefa();
  $tarefa->__set('id', $_GET['id'])->__set('id_status', 2);

  $conexao = new Conexao();

  $tarefaServer = new TarefaServer($conexao, $tarefa);
  $tarefaServer->marcarRealizada();

  if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
    header('location: index.php');
  } else {
   header('location: todas_tarefas.php');
  }



} else if ($acao == 'recuperarTarefasPendentes'){
  $tarefa = new Tarefa();
  $tarefa->__set('id_status',1);
  $conexao = new Conexao();

  $tarefaServer = new TarefaServer($conexao, $tarefa);
  $tarefas = $tarefaServer->recuperarTarefasPendentes();
}

?>