<?php

$mysqli = new mysqli('https://s338.altervista.org/', 'giradastorm', 'doktefagpu80', 'my_giradastorm');
if ($mysqli->connect_errno) {
    // The connection failed. What do you want to do?
    // You could contact yourself (email?), log the error, show a nice page, etc.
    // You do not want to reveal sensitive information

    // Let's try this:
    echo "Sorry, this website is experiencing problems.";

    // Something you should not do on a public site, but this example will show you
    // anyways, is print out MySQL error related information -- you might log this
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";

    // You might want to show them something nice, but we will simply exit
    exit;
}

$sql = "SELECT Nome FROM gs_lista WHERE CodicePersonale = 168658";
if (!$result = $mysqli->query($sql)) {
    // Oh no! The query failed.
    echo "Sorry, the website is experiencing problems.";

    // Again, do not do this on a public site, but we'll show you how
    // to get the error information
    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
}

if ($result->num_rows === 0) {
    // Oh, no rows! Sometimes that's expected and okay, sometimes
    // it is not. You decide. In this case, maybe actor_id was too
    // large?
    echo "We could not find a match for ID 168658, sorry about that. Please try again.";
    exit;
}

echo "<ul>\n";
while ($actor = $result->fetch_assoc()) {
    echo "<li>" . $actor['Nome'] . "</li>\n";
}
echo "</ul>\n";

// The script will automatically free the result and close the MySQL
// connection when it exits, but let's just do it anyways
$result->free();
$mysqli->close();
?>

/**
 * @file
 *
 * Reads data from a Google Spreadsheet that needs authentication.
 */
/**
 * require_once dirname(__FILE__) . '/vendor/autoload.php';
 * */

/**
 * Set here the full path to the private key .json file obtained when you
 * created the service account. Notice that this path must be readable by
 * this script.
 */
/**
 * $service_account_file = dirname(__FILE__) . '/giradastormbot.json';
 * */

/**
 * This is the long string that identifies the spreadsheet. Pick it up from
 * the spreadsheet's URL and paste it below.
 */
/**
$spreadsheet_id = '1OpkvFJRzxZ2lxv_CPV1akNeagaKAGZjTlhRRzxrJbrc';
echo $spreadsheet_id;
 * */
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
/**
$spreadsheet_range = 'Foglio1!A1:A1';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $service_account_file);
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google_Service_Drive::DRIVE_READONLY);
$service = new Google_Service_Drive($client);
/**   $result = $service->spreadsheets_values->get($spreadsheet_id, $spreadsheet_range);
$response = $result->getValues()[0][0];
 */
/**
$response = $service->files->export($spreadsheet_id, 'application/pdf');

$content = $response->getBody()->getContents();
echo "content:" . json_encode($content);
*/
