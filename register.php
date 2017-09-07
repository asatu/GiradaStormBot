<?php

require_once('classes/telegramConfig.php');

use Telegram\Bot\Api;

// PARAMETRI DA MODIFICARE
$WEBHOOK_URL = 'https://giradastormbot.herokuapp.com/execute.php';
$BOT_TOKEN = '430468745:AAFf2enKI48Xr2vHqnFcWz3eyUK0pA_Mk44';

$telegram = new Api(TelegramConfig::BOT_TOKEN);
$telegram->removeWebhook();
//$telegram->setWebhook(['url' => $WEBHOOK_URL]);
