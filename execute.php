<?php

require_once('classes/telegramClient.php');
require_once('vendor/autoload.php');

$telegramClient = new TelegramClient();
$command = $telegramClient->GetInputCommand();

if(strcmp($command, "/start") === 0)
{
    $telegramClient->ShowStartView();
}
elseif(strcmp($command, "/menu") === 0)
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
    $telegramClient->ShowCancelOrderView();
}
elseif(strcmp($command, "Conferma") === 0)
{
    $telegramClient->ShowConfirmOrderView();
}