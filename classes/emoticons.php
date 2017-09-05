<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 05/09/2017
 * Time: 00:01
 */

class Emoticons
{
    public static function getEmojiPointRight() {
        return json_decode('"\ud83d\udc49"');
    }

    public static function getEmojiList() {
        return json_decode('"\ud83d\udcdc"');
    }

    public static function getEmojiOrder() {
        return json_decode('"\ud83d\udcdd"');
    }

    public static function getEmojiIphone() {
        return json_decode('"\ud83d\udcf1"');
    }

    public static function getEmojiAndroid() {
        return json_decode('"\ud83d\udc7e"');
    }

    public static function getEmojiBack() {
        return json_decode('"\ud83d\udd19"');
    }
}