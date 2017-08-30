<?php
/**
 * @file
 *
 * Reads data from a Google Spreadsheet that needs authentication.
 */
require_once dirname(__FILE__) . '/vendor/autoload.php';
/**
 * Set here the full path to the private key .json file obtained when you
 * created the service account. Notice that this path must be readable by
 * this script.
 */
$service_account_file = dirname(__FILE__) . '/giradastormbot.json';
/**
 * This is the long string that identifies the spreadsheet. Pick it up from
 * the spreadsheet's URL and paste it below.
 */

$spreadsheet_id = '1OpkvFJRzxZ2lxv_CPV1akNeagaKAGZjTlhRRzxrJbrc';
echo $spreadsheet_id;
/**
 * This is the range that you want to extract out of the spreadsheet. It uses
 * A1 notation. For example, if you want a whole sheet of the spreadsheet, then
 * set here the sheet name.
 *
 * @see https://developers.google.com/sheets/api/guides/concepts#a1_notation
 */

/**
    $spreadsheet_range = 'Foglio1!A1:A1';
    putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $service_account_file);
    $client = new Google_Client();
    $client->useApplicationDefaultCredentials();
    $client->addScope(Google_Service_Sheets::SPREADSHEETS);
    $service = new Google_Service_Sheets($client);
    $result = $service->spreadsheets_values->get($spreadsheet_id, $spreadsheet_range);
    var_dump($result->getValues());
 * */

$spreadsheet_range = 'Foglio1!A1:A1';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $service_account_file);
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Drive::DRIVE_READONLY);
$service = new Google_Service_Drive($client);
/**   $result = $service->spreadsheets_values->get($spreadsheet_id, $spreadsheet_range);
$response = $result->getValues()[0][0];
 */

$response = $service->files->export($spreadsheet_id, 'application/pdf');

$content = $response->getBody()->getContents();
echo "content:" . json_encode($content);

