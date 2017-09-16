<?php

require_once('classes/telegramConfig.php');
require_once('classes/markups.php');
require_once('vendor/autoload.php');

use Telegram\Bot\Api;

$telegram = new Api(TelegramConfig::BOT_TOKEN);

$request = $telegram->getWebhookUpdate();

$updateId = $request->getUpdateId();
$chat = $request->getChat();

$chatId = $chat->getId();
$first_name = $chat->getFirstName();
$last_name = $chat->getLastName();
$username = $chat->getUsername();

if ($request->detectType() == 'message')
{
    $message = $request->getMessage();

    $input = $message->getText();
    // $message->entities[0]->offset = $updateId + 1;
}
else
{
    $callbackQuery = $request->getCallbackQuery();
   // $message = $callbackQuery->getMessage();

    $input = $callbackQuery->getData();
    //$message->entities[0]->offset = $updateId + 1;
}




$service_url = 'http://giradastorm.altervista.org/_php/api/list/read.php';
$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (!isset($decoded->response->status) && $decoded->response->status != 'ERROR') {
    $param = $input;
    $input = "/ordina";

    $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => 'resp:' . $curl_response
    ]);
}

$telegram->sendMessage([
    'chat_id' => $chatId,
    'text' => 'input' . json_encode($input)
]);

$telegram->sendMessage([
    'chat_id' => $chatId,
    'text' => json_encode($request)
]);

if(strcmp($input, "/start") === 0)
{
	$text =
		"Ciao *$first_name*, benvenuto!\n"
		."\n"
		."Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
		."è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
		."Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'parse_mode' => 'Markdown',
        'reply_markup' => Markups::showHomeMenu()
    ]);
}
elseif(strcmp($input, "/lista") === 0)
{
    $text = "Visualizza la lista aggiornata";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'reply_markup' => Markups::showListMenu()
    ]);
}
/**
elseif(strcmp($text, "/listaprezzo") === 0)
{
	$parameters = array('chat_id' => $chatId, "text" => "qui scarichiamo la lista per prezzo aaaaaaaaaaaa");
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
}
 * */
elseif(strcmp($input, "/ordina") === 0)
{
    if(!isset($username) || empty($username))
    {
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Devi impostare lo username prima di ordinare'
        ]);
    }
    else
    {

        if(!isset($decoded) || empty($decoded))
        {
            $text =
                "Verrai guidato passo passo per metterti in lista.\n"
                . "Ricorda che devi fare questi passaggi *prima* di effettuare l'ordine su Girada.\n"
                . "\n"
                . "Adesso inserisci il *tuo codice Girada*: ";

            $response1 = $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $text,
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
        elseif($decoded == 'Stato1')
        {
            $_SESSION['order_step'] = 2;

            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Inserisci il *prodotto* che vuoi acquistare',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
        elseif($decoded == 'Stato2')
        {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Inserisci il *prezzo*: ',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
        elseif($decoded == 'Stato3')
        {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'bravo ',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
    }
}
elseif(strcmp($input, "/home") === 0)
{
    $text = "Seleziona un azione";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'reply_markup' => Markups::showHomeMenu()
    ]);
}
elseif(strcmp($input, "Annulla") === 0)
{
    $text = "Annullato";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'reply_markup' => Markups::removeMenu()
    ]);
}