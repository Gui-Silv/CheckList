<?php

 class Conexao {

    private $host = 'localhost';
    private $dbname = 'app_tarefas';
    private $user = 'root';
    private $pass = '';

    public function conectar(){
       try {
 
          $conexao = new PDO(
            "mysql:host=$this->host;dbname=$this->dbname",  //1- Dsn / 2- User / 3- Password 
            "$this->user",
            "$this->pass",
          );

          return $conexao; 


       } catch (PDOException $e){
          echo '<p>'. $e->getMessege(). '</p>';
       }
    }
 }
?>