<?php

require_once('classes/markups.php');

$content = file_get_contents("php://input");
$request = json_decode($content, false);
if(!$request)
{
  exit;
}

header("Content-Type: application/json");

echo $content;

$updateId = $request->update_id;
if ($request->callback_query != null) 
{
	$firstname = $request->callback_query->message->chat->first_name;
	$chatId = $request->callback_query->message->chat->id;
	$text = $request->callback_query->data;
    $request->callback_query->message->entities[0]->offset = $updateId + 1;
}
else
{
	$firstname = $request->message->chat->first_name;
	$chatId = $request->message->chat->id;
	$text = $request->message->text;
    $request->message->entities[0]->offset = $updateId + 1;
}

if(strcmp($text, "/start") === 0)
{
	$response = 
		"Ciao *$firstname*, benvenuto!\n"
		."\n"
		."Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
		."è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
		."Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";

	$parameters = ['chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown", "reply_markup" => Markups::getHomeMenu()];
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
}
elseif(strcmp($text, "/lista") === 0)
{
    $response = "Visualizza la lista aggiornata";
	$parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::getListMenu());
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}
elseif(strcmp($text, "/listaprezzo") === 0)
{
	$parameters = array('chat_id' => $chatId, "text" => "qui scarichiamo la lista per prezzo aaaaaaaaaaaa");
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}
elseif(strcmp($text, "/ordina") === 0)
{
    $response =
        "Verrai guidato passo passo per metterti in lista.\n"
        ."Ricorda che devi fare questi passaggi *prima* di effettuare l'ordine su Girada.";

	$parameters = ['chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown"];
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);

	$first_step = "Inserisci il nome, senza cognome";
    $parameters = ['chat_id' => $chatId, "text" => $first_step, "parse_mode" => "Markdown"];
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);

    $parameters = ['chat_id' => $chatId, "action" => "typing"];
    $parameters["method"] = "sendChatAction";
}
elseif(strcmp($text, "/home") === 0)
{
    $response = "Seleziona un azione";
    $parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::getHomeMenu());
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}


