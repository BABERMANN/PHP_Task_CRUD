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

//A API se configura, define como vai falar JSON, CORS e se conecta ao banco de dados para começar a trabalhar.

// ato 2
//indentificando o metodo http
$method = $_SERVER['REQUEST_METHOD']; //pega o metodo http da requisicao (GET, POST, PUT ou DELETE)


//extrair  o id da url, caso haja uma
$request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));  //divide a url em partes
$id = null; // inicializa o id como nulo Inicializamos $id = null; para evitar erros de variável indefinida,
//  deixar claro que ainda não ha um id e garantir que a lógica de busca funcione corretamente.

//veificar se a ultima parte da url e um numero e se for guardar como id
if (isset($request_uri[count($request_uri) - 1]) && is_numeric($request_uri[count($request_uri) - 1])) {
    $id = (int)$request_uri[count($request_uri) - 1]; // converte o id para numero inteiro
}

//A API identifica o que o cliente quer fazer método http e qual recurso específico ele quer se há um id na url.

?>