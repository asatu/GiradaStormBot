<?php

require_once('classes/telegramConfig.php');
require_once('classes/markups.php');
require_once('vendor/autoload.php');

use Telegram\Bot\Api;

$telegram = new Api(TelegramConfig::BOT_TOKEN);


$request = $telegram->getWebhookUpdates();



/**
$content = file_get_contents("php://input");
$request = json_decode($content, false);
if(!$request)
{
  exit;
}

header("Content-Type: application/json");
*/
$updateId = $request->getUpdateId();
/**
if ($request->callback_query != null)
{
	$first_name = $request->callback_query->message->chat->first_name;
	$chatId = $request->callback_query->message->chat->id;
	$text = $request->callback_query->data;
    $request->callback_query->message->entities[0]->offset = $updateId + 1;
}
else*/
{
    $message = $request->getMessage();
    $chat = $message->getChat();

    $first_name = $chat->getFirstName();
	$chatId = $chat->getId();
	$text = $message->getText();
   // $message->entities[0]->offset = $updateId + 1;
}

if(strcmp($text, "/start") === 0)
{
	$response = 
		"Ciao *$first_name*, benvenuto!\n"
		."\n"
		."Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
		."è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
		."Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";

	/**
	$parameters = ['chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown", "reply_markup" => Markups::showHomeMenu()];
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
     * */

    $response2 = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => 'Hello World'
    ]);
}
/**
elseif(strcmp($text, "/lista") === 0)
{
    $response = "Visualizza la lista aggiornata";
	$parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::showListMenu());
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

	$parameters = ['chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown", "reply_markup" => Markups::showCancelMenu()];
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
}
elseif(strcmp($text, "/home") === 0)
{
    $response = "Seleziona un azione";
    $parameters = array('chat_id' => $chatId, "text" => $response, "reply_markup" => Markups::showHomeMenu());
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
*/

