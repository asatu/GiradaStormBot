<?php

/** Include Google Excel */
require_once dirname(__FILE__) . '/vendor/autoload.php';


define('APPLICATION_NAME', 'giradastormbot');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', dirname(__FILE__) . '/client_secret.json');

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
    $client = new Google_Client();
    $client->setApplicationName(APPLICATION_NAME);
    $client->setAuthConfig(CLIENT_SECRET_PATH);
    $client->setAccessType('offline');

    // Load previously authorized credentials from a file.
    $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
    if (file_exists($credentialsPath)) {
        $accessToken = json_decode(file_get_contents($credentialsPath), true);
    } else {
        // Request authorization from the user.
        $authUrl = $client->createAuthUrl();
        printf("Open the following link in your browser:\n%s\n", $authUrl);
        print 'Enter verification code: ';
        $authCode = trim(fgets(STDIN));

        // Exchange authorization code for an access token.
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Store the credentials to disk.
        if(!file_exists(dirname($credentialsPath))) {
            mkdir(dirname($credentialsPath), 0700, true);
        }
        file_put_contents($credentialsPath, json_encode($accessToken));
        printf("Credentials saved to %s\n", $credentialsPath);
    }
    $client->setAccessToken($accessToken);

    // Refresh the token if it's expired.
    if ($client->isAccessTokenExpired()) {
        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
    $homeDirectory = getenv('HOME');
    if (empty($homeDirectory)) {
        $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
    }
    return str_replace('~', realpath($homeDirectory), $path);
}

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
					),
					array(
						array("text" => $emoji_android."    Lista Note 8    ".$emoji_android, "callback_data" => "/listanote"),
						array("text" => $emoji_android."    Entra in Lista Note 8    ".$emoji_android, "callback_data" => "/ordinanote")
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
	$parameters = array('chat_id' => $chatId, "text" => "qui scarichiamo la lista aaaaaaaaaa");
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
    $response = "";
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Sheets($client);

    // Prints the names and majors of students in a sample spreadsheet:
    // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
    $spreadsheetId = '1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms';
    $range = 'Class Data!A2:E';
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    if (count($values) == 0) {
        $response = "No data found.\n";
    } else {
        $response = "sono qui";

    }

	$parameters = array('chat_id' => $chatId, "text" => $response);
	$parameters["method"] = "sendMessage";
	echo json_encode($parameters);	
}


