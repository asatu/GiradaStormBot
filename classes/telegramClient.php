<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 16/09/2017
 * Time: 13:25
 */

require_once('api_clients/sessionClient.php');
require_once('api_clients/listClient.php');
require_once('api_clients/anagraficaClient.php');
require_once('poco/request.php');
require_once('markups.php');

use Telegram\Bot\Api;

class TelegramClient
{
    const WEBHOOK_URL = 'https://giradastormbot.herokuapp.com/execute.php';
    const BOT_TOKEN = '361431393:AAG-1mBbxkDlA7kgJZtSIVoyceqpxhE83O8';

    private $telegram;
    private $request;

    private $sessionState;

    function __construct()
    {
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

        if ($telegramUpdate->detectType() == 'message') {
            $this->request->Command = $telegramUpdate->getMessage()->getText();
            // $message->entities[0]->offset = $updateId + 1;
        } else /** E' un comando che viene da un pulsante */ {
            $this->request->Command = $telegramUpdate->getCallbackQuery()->getData();
            //$message->entities[0]->offset = $updateId + 1;
        }

        /** Se la sessione è impostata vuol dire che l'utente sta effettuando un ordine */
        $session = new SessionClient();
        $this->sessionState = $session->GetCurrentSession($this->request->Username);

        if (isset($this->sessionState) && !empty($this->sessionState))
        {
            if(strcmp($this->request->Command, "Annulla") !== 0 && strcmp($this->request->Command, "Conferma") !== 0)
            {
                $this->request->Args = $this->request->Command;
                $this->request->Command = "/ordina";
            }
        }

        return $this->request->Command;
    }

    public function ShowStartView()
    {
        $text =
            "Ciao *" . $this->request->First_name . "*, benvenuto!\n"
            . "\n"
            . "Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
            . "è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
            . "Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";

        if (!isset($this->request->Username) || empty($this->request->Username)) {
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

    public function ShowGetInListView()
    {
        if(!isset($this->request->Username) || empty($this->request->Username))
        {
            $this->telegram->sendMessage([
                'chat_id' => $this->request->Chat_id,
                'text' => 'Devi impostare lo username prima di ordinare'
            ]);
        }
        else
        {
            $session = new SessionClient();

            if(!isset($this->sessionState) || empty($this->sessionState))
            {
                $text =
                    "Verrai guidato passo passo per metterti in lista.\n"
                    . "Ricorda che devi fare questi passaggi *prima* di effettuare l'ordine su Girada.\n"
                    . "\n";

                $anagrafica = new AnagraficaClient();
                $codicePersonale = $anagrafica->GetCodicePersonale($this->request->Username);

                if(!isset($codicePersonale) || empty($codicePersonale))
                {
                    $text = $text . "Inserisci il tuo *codice Girada personale*: ";
                    $step = "Step1";
                }
                else
                {
                    $text = $text . "Inserisci il *prodotto* che vuoi acquistare: ";
                    $step = "Step2";
                }

                $session->CreateNewSession($this->request->Username, $this->request->First_name, $this->request->Last_name, $codicePersonale, $step);

                $this->telegram->sendMessage([
                    'chat_id' => $this->request->Chat_id,
                    'text' => $text,
                    'parse_mode' => 'Markdown',
                    'reply_markup' => Markups::showCancelMenu()
                ]);
            }
            elseif($this->sessionState == 'Step1')
            {
                $anagrafica = new AnagraficaClient();
                $anagrafica->CreateAnagrafica($this->request->Username, $this->request->Args);

                $session->AddCodicePersonale($this->request->Username, $this->request->Args);

                $this->telegram->sendMessage([
                    'chat_id' => $this->request->Chat_id,
                    'text' => 'Inserisci il *prodotto* che vuoi acquistare: ',
                    'parse_mode' => 'Markdown',
                    'reply_markup' => Markups::showCancelMenu()
                ]);
            }
            elseif($this->sessionState == 'Step2')
            {
                $session->AddProdotto($this->request->Username, $this->request->Args);

                $this->telegram->sendMessage([
                    'chat_id' => $this->request->Chat_id,
                    'text' => 'Inserisci il *prezzo* del prodotto: ',
                    'parse_mode' => 'Markdown',
                    'reply_markup' => Markups::showCancelMenu()
                ]);
            }
            elseif($this->sessionState == 'Step3')
            {
                $session->AddPrezzo($this->request->Username, $this->request->Args);

                $this->telegram->sendMessage([
                    'chat_id' => $this->request->Chat_id,
                    'text' => 'Verifica i dati e *conferma* o annulla',
                    'parse_mode' => 'Markdown',
                    'reply_markup' => Markups::showCancelAndConfirmMenu()
                ]);
            }
            elseif($this->sessionState == 'Step4')
            {

            }
        }
    }

    public function ShowCancelOrderView()
    {
        $session = new SessionClient();
        $session->DeleteCurrentSession($this->request->Username);

        $this->telegram->sendMessage([
            'chat_id' => $this->request->Chat_id,
            'text' => 'Annullato. Non verrai messo in lista',
            'reply_markup' => Markups::removeMenu()
        ]);
    }

    public function ShowConfirmOrderView()
    {
        $list = new ListClient();
        $response = $list->GetIn($this->request->Username);

        $session = new SessionClient();
        $session->DeleteCurrentSession($this->request->Username);

        $this->telegram->sendMessage([
            'chat_id' => $this->request->Chat_id,
            'parse_mode' => 'Markdown',
            'text' => "Sei stato messo in lista. Al momento dell'ordine su girada devi usare questo codice amico: *" . $response . "* .\n"
                        . "Una volta terminato l'acquisto torna qui e inviaci lo screen dell'ordine effettuato su girada cliccando "
                        . "sul pulsante *Invia screen ordine* o scrivendo il comando /confermaordine.\n"
                        . "Ricorda che se non confermi l'ordine non puoi ricevere aiuti. ",
            'reply_markup' => Markups::removeMenu()
        ]);
    }
}