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


//ato 3 switch metodo http
switch ($method) {

    case 'GET': // pegar dados
        if ($id) { // caso queira uma tarefa http especifica

            $task->id = $id; // informa qual tarefa buscar
            if ($task->readOne()) { // busca no bd
                http_response_code(200); //sucesso  xd.
                echo json_encode(["id" => $task->id, "title" => $task->title, ]); // envia a tarefa em json.
            } else { //caso nao encontre a tarefa.
                http_response_code(404); // mensagem de erro.
                echo json_encode(["message" => "Tarefa não encontrada."]);
            }
        } else { // caso queira todas as tarefas
    
            $stmt = $task->read(); // busca as tarefas no bd
            if ($stmt->rowCount() > 0) { // verifica se ha tarefas
                $tasks_arr = ["records" => []]; // prepara a lista.
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { /* ...lógica para adicionar cada tarefa ao array... */ }
                http_response_code(200); // sucesso xd
                echo json_encode($tasks_arr); // envia a lista em json.
            } else { // caso nao encontre nenhuma tarefa
                http_response_code(404); // mensagem de erro.
                echo json_encode(["message" => "Nenhuma tarefa encontrada."]);
            }
        }
        break; // fim do roteiro get
        
    



?>