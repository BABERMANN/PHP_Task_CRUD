<?php
//ato 1 preparo dos bastidores
//api fala para o cliente sobre respostas e permissoes

header("Access-Control-Allow-Origin: *");//permite que qualquer site acesse esta api
header("Content-Type: application/json; charset=UTF-8");//
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); //metodos http sao permitidos
header("Access-Controll-Max-Age: 3600"); //define por quanto tempo o navegador pode cachear as permissoes
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With"); //cabrcalhos que o cliente pode enviar.

//traz arquivos para o codigo de outras partes da aplicacao 
include_once '../config/database.php'; //classe database
include_once '../models/Task.php'; // TRaz a classe task


//definindo Objetos
$database = new database(); // objeto para gerenciar a conexao com o banco
$db = $database->getConnection(); // Realiza a conexao direto pro banco de dados
$task = new Task($db);  //objeto tarefas


//$task vai interragir com tarefas no banco de dados

//A API se configura, define como vai "falar" (JSON, CORS) e se conecta ao banco de dados para começar a trabalhar.

?>