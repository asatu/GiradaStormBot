<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 05/09/2017
 * Time: 00:07
 */

require_once('emoticons.php');

class Markups
{
    public static function showMainMenu()
    {
        $home_markup = [
            'inline_keyboard' => [
                [
                    ["text" => Emoticons::getEmojiPointRight() . "    Mettiti in Lista    " . Emoticons::getEmojiPointRight(), "callback_data" => "/ordina"]
                ],
                [
                    ["text" => Emoticons::getEmojiList() . "    Lista Completa    " . Emoticons::getEmojiList(), "url" => "http://giradastorm.altervista.org/lista"]
                ],
                [
                    ["text" => Emoticons::getEmojiList() . "    Lista per Prezzo    " . Emoticons::getEmojiList(), "callback_data" => "/listaprezzo"]
                ],
                [
                    ["text" => Emoticons::getEmojiIphone() . "    Lista iPhone X    " . Emoticons::getEmojiIphone(), "callback_data" => "/listaiphone"],
                    ["text" => Emoticons::getEmojiIphone() . "    Entra in Lista iPhone X    " . Emoticons::getEmojiIphone(), "callback_data" => "/ordinaiphone"]
                ],
                [
                    ["text" => Emoticons::getEmojiQuestion() . "    Aiuto    " . Emoticons::getEmojiQuestion(), "callback_data" => "/help"]
                ]
            ]
        ];

        return json_encode($home_markup);
    }

    public static function showListMenu()
    {
        $list_markup = [
            'inline_keyboard' => [
                [
                    ["text" => Emoticons::getEmojiList() . "    Vai alla lista aggiornata    " . Emoticons::getEmojiList(), "url" => "http://giradastorm.altervista.org/lista"]
                ],
                [
                    ["text" => Emoticons::getEmojiBack() . "    Indietro    ", "callback_data" => "/home"]
                ]
            ]
        ];

        return json_encode($list_markup);
    }

    public static function showCancelMenu()
    {
        $cancel_markup = [
            'keyboard' => [
                    ["Annulla"]
            ],
            'resize_keyboard' => true
        ];

        return json_encode($cancel_markup);
    }

    public static function removeMenu()
    {
        $remove_markup = [
            'remove_keyboard' => true
        ];

        return json_encode($remove_markup);
    }

    public static function reply()
    {
        $reply_markup = [
            'force_reply' => true
        ];

        return json_encode($reply_markup);
    }
}