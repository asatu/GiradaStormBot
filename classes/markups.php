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
    public static function getHomeMenu()
    {
        $home_markup = new InlineKeyboardMarkup([
            'inline_keyboard' => [
                [
                    new InlineKeyboardButton(["text" => Emoticons::getEmojiPointRight() . "    Mettiti in Lista    " . Emoticons::getEmojiPointRight(), "callback_data" => "/ordina"])
                ],
                [
                    new InlineKeyboardButton(["text" => Emoticons::getEmojiList() . "    Lista Completa    " . Emoticons::getEmojiList(), "url" => "http://giradastorm.altervista.org/lista"])
                ],
                [
                    new InlineKeyboardButton(["text" => Emoticons::getEmojiList() . "    Lista per Prezzo    " . Emoticons::getEmojiList(), "callback_data" => "/listaprezzo"])
                ],
                [
                    new InlineKeyboardButton(["text" => Emoticons::getEmojiIphone() . "    Lista iPhone 8    " . Emoticons::getEmojiIphone(), "callback_data" => "/listaiphone"]),
                        new InlineKeyboardButton(["text" => Emoticons::getEmojiIphone() . "    Entra in Lista iPhone 8    " . Emoticons::getEmojiIphone(), "callback_data" => "/ordinaiphone"])
                ]
            ]
        ]);

        return json_encode($home_markup);
    }

    public static function getListMenu()
    {
        $list_markup = array(
            'inline_keyboard' => array(
                array(
                    array("text" => "    Visualizza lista aggiornata    ", "url" => "http://giradastorm.altervista.org/lista")
                ),
                array(
                    array("text" => Emoticons::getEmojiList() . "    Indietro    " . Emoticons::getEmojiList(), "callback_data" => "/lista")
                )
            )
        );

        return json_encode($list_markup);
    }
}