<?php

$content = file_get_contents("php://input");
$request = json_decode($content, false);
if(!$request)
{
  exit;
}

header("Content-Type: application/json");

$emoji_point_right = json_decode('"\ud83d\udc49"');
$emoji_list = json_decode('"\ud83d\udcdc"');
$emoji_order = json_decode('"\ud83d\udcdd"');
$emoji_iphone = json_decode('"\ud83d\udcf1"');
$emoji_android = json_decode('"\ud83d\udc7e"');

if ($request->callback_query != null) 
{
	$firstname = $request->callback_query->message->chat->first_name;
	$chatId = $request->callback_query->message->chat->id;
	$text = $request->callback_query->data;
}
else
{
	$firstname = $request->message->chat->first_name;
	$chatId = $request->message->chat->id;
	$text = $request->message->text;
}

if(strcmp($text, "/start") === 0)
{
	$response = 
		"Ciao *$firstname*, benvenuto!\n"
		."\n"
		."Ti ricordiamo che tutto quello che riguarda *Girada Storm* non ha nulla a che vedere con *Girada*. Lo scopo di questo gruppo e di questo bot "
		."è quello di offrire gratuitamente un aiuto agli utenti per trovare nel minor tempo possibile i 3 amici necessari per ottenere il massimo sconto. "
		."Non siamo quindi responsabili nè dell'ordine nè del prodotto acquistato, per i quali potrai contattare direttamente Girada.";
		
	$reply_markup =
		array(
				'inline_keyboard' => array(
					array(
						array("text" => $emoji_order."    Mettiti in Lista    ".$emoji_order, "callback_data" => "/ordina")
					),
					array(
						array("text" => $emoji_list."    Lista Completa    ".$emoji_list, "callback_data" => "/lista")
					),
					array(
						array("text" => $emoji_list."    Lista per Prezzo    ".$emoji_list, "callback_data" => "/listaprezzo")
					),
					array(
						array("text" => $emoji_iphone."    Lista iPhone 8    ".$emoji_iphone, "callback_data" => "/listaiphone"),
						array("text" => $emoji_iphone."    Entra in Lista iPhone 8    ".$emoji_iphone, "callback_data" => "/ordinaiphone")
					)
				)
			);
	$reply_markup_enc = json_encode($reply_markup);

	$parameters = array('chat_id' => $chatId, "text" => $response, "parse_mode" => "Markdown", "reply_markup" => $reply_markup_enc);
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);
}
elseif(strcmp($text, "/lista") === 0)
{
    $list_url = urlencode("http://giradastorm.altervista.org/lista");

	$parameters = array('chat_id' => $chatId, "text" => json_encode($list_url));
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}
elseif(strcmp($text, "/listaprezzo") === 0)
{
	$parameters = array('chat_id' => $chatId, "text" => "qui scarichiamo la lista per prezzo aaaaaaaaaaaa");
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}
elseif(strcmp($text, "/ordina") === 0)
{
    $response = "sono qui";

	$parameters = array('chat_id' => $chatId, "text" => $response);
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}


