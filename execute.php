<?php

require_once('classes/markups.php');

$content = file_get_contents("php://input");
$request = json_decode($content, false);
if(!$request)
{
  exit;
}

header("Content-Type: application/json");

$updateId = $request->update_id;
if ($request->callback_query != null) 
{
	$first_name = $request->callback_query->message->chat->first_name;
	$chatId = $request->callback_query->message->chat->id;
	$text = $request->callback_query->data;
    $request->callback_query->message->entities[0]->offset = $updateId + 1;
}
else
{
    $first_name = $request->message->chat->first_name;
	$chatId = $request->message->chat->id;
	$text = $request->message->text;
    $request->message->entities[0]->offset = $updateId + 1;
}

if(strcmp($text, "/start") === 0)
{
	$response = 
		"Ciao *$first_name*, benvenuto!\n"
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
        ."Ricorda che devi fare questi passaggi *prima* di effettuare l'ordine su Girada.\n"
        ."\n"
        ."Adesso inserisci il *nome*, senza cognome:";

	$parameters = ['chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown", "reply_markup" => Markups::getCancelMenu()];
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
/**
    $parameters2 = array('chat_id' => $chatId, "text" => "good! Now insert the surname");
    $parameters2["method"] = "sendMessage";
    echo json_encode($parameters2);
 * */
}
elseif(strcmp($text, "/home") === 0)
{
    $response = "Seleziona un azione";
    $parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::getHomeMenu());
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}
elseif(strcmp($text, "Annulla") === 0)
{
    $response = "Annullato";
    $parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::removeMenu());
    $parameters["method"] = "sendMessage";
    echo json_encode($parameters);
}


