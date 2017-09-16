<?php

require_once('classes/markups.php');
require_once('classes/telegramClient.php');
require_once('vendor/autoload.php');

$telegramClient = new TelegramClient();
$command = $telegramClient->GetInputCommand();

if(strcmp($command, "/start") === 0)
{
    $telegramClient->ShowHomeView();
}
elseif(strcmp($command, "/lista") === 0)
{
    $text = "Visualizza la lista aggiornata";

    $response = $telegram->sendMessage([
        'chat_id' => $request->Chat_id,
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
elseif(strcmp($command, "/ordina") === 0)
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
        if(!isset($sessionState) || empty($sessionState))
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
        elseif($sessionState == 'Step1')
        {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Inserisci il *prodotto* che vuoi acquistare',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
        elseif($sessionState == 'Step2')
        {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Inserisci il *prezzo*: ',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
        elseif($sessionState == 'Step3')
        {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'bravo ',
                'reply_markup' => Markups::showCancelMenu()
            ]);
        }
    }
}
elseif(strcmp($command, "/home") === 0)
{
    $text = "Seleziona un azione";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'reply_markup' => Markups::showHomeMenu()
    ]);
}
elseif(strcmp($command, "Annulla") === 0)
{
    $text = "Annullato";

    $response = $telegram->sendMessage([
        'chat_id' => $chatId,
        'text' => $text,
        'reply_markup' => Markups::removeMenu()
    ]);
}