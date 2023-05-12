<?php
 //CRUD

 class TarefaServer {
   
    private $conexao;
    private $tarefa;

    public function __construct(Conexao $conexao, Tarefa $tarefa){
        $this->conexao = $conexao->conectar();
        $this->tarefa = $tarefa;
    }

    public function inserir(){

       $query = 'insert into tb_tarefas(tarefa)values(:tarefa)';               //insiro o valor de tarefa na coluna tarefa de tb_tarefas
       $stmt = $this->conexao->prepare($query);                               // preparo para evitar erros
       $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));          //no bindvalue o primeiro parametro vai ser a coluna desejada, e o segundo o valor que vai ser adicionado recuperado do get(uso o get pois o método é privado)
       $stmt->execute();                                                    //executar a instrucao
    }

    public function recuperar(){

       $query = '
                select 
                 t.id, s.status, t.tarefa 
                from 
                   tb_tarefas as t
                left join tb_status as s on (t.id_status = s.id)
       ';
       $stmt = $this->conexao->prepare($query);
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ); //retorno em forma de obj para melhor tratamento dos dados
    }

    public function atualizar(){
      $query = 'update tb_tarefas set tarefa = :tarefa where id = :id';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
      $stmt->bindValue(':id', $this->tarefa->__get('id'));
      return $stmt->execute();
    }

    public function remover(){
      $query = 'delete from tb_tarefas where id = :id';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue(':id' , $this->tarefa->__get('id'));
      $stmt->execute();

    }

    public function marcarRealizada(){
      $query = 'update tb_tarefas set id_status = :id_status where id = :id';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
      $stmt->bindValue(':id', $this->tarefa->__get('id'));
      return $stmt->execute();
    }

    public function recuperarTarefasPendentes(){
       $query = '
                select 
                 t.id, s.status, t.tarefa 
                from 
                   tb_tarefas as t
                left join tb_status as s on (t.id_status = s.id)
                where 
                t.id_status = :id_status
       ';
       $stmt = $this->conexao->prepare($query);
       $stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
       $stmt->execute();
       return $stmt->fetchAll(PDO::FETCH_OBJ); 

    }
 }

?>