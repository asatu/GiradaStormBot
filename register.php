<?php

require_once('classes/telegramConfig.php');
require_once('vendor/autoload.php');

use Telegram\Bot\Api;

$telegram = new Api(TelegramConfig::BOT_TOKEN);
$telegram->setWebhook(['url' => TelegramConfig::WEBHOOK_URL]);
