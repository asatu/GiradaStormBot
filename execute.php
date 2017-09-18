<?php

require_once('classes/markups.php');
require_once('classes/telegramClient.php');
require_once('vendor/autoload.php');

$telegramClient = new TelegramClient();
$command = $telegramClient->GetInputCommand();

if(strcmp($command, "/start") === 0)
{
    $telegramClient->ShowStartView();
}
elseif(strcmp($command, "/home") === 0)
{
    $telegramClient->ShowMainMenuView();
}
elseif(strcmp($command, "/lista") === 0)
{
    $telegramClient->ShowListView();
}
elseif(strcmp($command, "/ordina") === 0)
{
    $telegramClient->ShowGetInListView();
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