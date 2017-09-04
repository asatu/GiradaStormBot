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
        $home_markup = array(
            'inline_keyboard' => array(
                array(
                    array("text" => Emoticons::getEmojiPointRight() . "    Mettiti in Lista    " . Emoticons::getEmojiPointRight(), "callback_data" => "/ordina")
                ),
                array(
                    array("text" => Emoticons::getEmojiList() . "    Lista Completa    " . Emoticons::getEmojiList(), "callback_data" => "/lista")
                ),
                array(
                    array("text" => Emoticons::getEmojiList() . "    Lista per Prezzo    " . Emoticons::getEmojiList(), "callback_data" => "/listaprezzo")
                ),
                array(
                    array("text" => Emoticons::getEmojiIphone() . "    Lista iPhone 8    " . Emoticons::getEmojiIphone(), "callback_data" => "/listaiphone"),
                    array("text" => Emoticons::getEmojiIphone() . "    Entra in Lista iPhone 8    " . Emoticons::getEmojiIphone(), "callback_data" => "/ordinaiphone")
                )
            )
        );

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