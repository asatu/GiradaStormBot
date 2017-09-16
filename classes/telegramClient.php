<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 16/09/2017
 * Time: 13:25
 */

require_once('api_clients/sessionClient.php');
require_once('poco/request.php');
require_once('markups.php');

use Telegram\Bot\Api;

class TelegramClient
{
    const WEBHOOK_URL = 'https://giradastormbot.herokuapp.com/execute.php';
    const BOT_TOKEN = '361431393:AAG-1mBbxkDlA7kgJZtSIVoyceqpxhE83O8';

    private $telegram;
    private $request;

    function __construct() {
        $this->telegram = new Api(TelegramClient::BOT_TOKEN);
    }

    public function GetInputCommand()
    {
        $telegramUpdate = $this->telegram->getWebhookUpdate();

        $this->request = new Request();
        $this->request->Update_id = $telegramUpdate->getUpdateId();

        $chat = $telegramUpdate->getChat();

        $this->request->Chat_id = $chat->getId();
        $this->request->First_name = $chat->getFirstName();
        $this->request->Last_name = $chat->getLastName();
        $this->request->Username = $chat->getUsername();

        if ($telegramUpdate->detectType() == 'message')
        {
            $this->request->Command = $telegramUpdate->getMessage()->getText();
            // $message->entities[0]->offset = $updateId + 1;
        }
        else /** E' un comando che viene da un pulsante */
        {
            $this->request->Command = $request->getCallbackQuery()->getData();
            //$message->entities[0]->offset = $updateId + 1;
        }

        /** Se la sessione è impostata vuol dire che l'utente sta effettuando un ordine */
        $session = new SessionClient();
        $sessionState = $session->GetCurrentSession($this->request->Username);

        if (isset($sessionState) && !empty($sessionState))
        {
            $this->request->Command = "/ordina";
            $this->request->Args = $sessionState;
        }

        return $this->request->Command;
    }

    public function ShowStartView()
    {
        $text =
            "Ciao *" . $this->request->First_name . "*, benvenuto!\n"
            ."\n"
            ."Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
            ."è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
            ."Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";

        if(!isset($this->request->Username) || empty($this->request->Username))
        {
            $text = $text . "\n" .
                "\n" .
                "*N.B.* :Per metterti in lista è necessario che tu imposti uno username.";
        }

        $this->telegram->sendMessage([
            'chat_id' => $this->request->Chat_id,
            'text' => $text,
            'parse_mode' => 'Markdown',
            'reply_markup' => Markups::showMainMenu()
        ]);
    }

    public function ShowListView()
    {
        /** In questo metodo si entra solo se viene fatta la richiesta di visualizzazione lista dal comando /lista */

        $this->telegram->sendMessage([
            'chat_id' => $this->request->Chat_id,
            'text' => 'TODO : Qui va del testo da decidere',
            'reply_markup' => Markups::showListMenu()
        ]);
    }

    public function ShowMainMenuView()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->request->Chat_id,
            'text' => 'TODO : Qui va del testo da decidere',
            'reply_markup' => Markups::showMainMenu()
        ]);
    }
}