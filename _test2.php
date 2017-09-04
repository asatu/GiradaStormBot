<?php

$service_url = 'http://giradastorm.altervista.org/_php/api/list/create.php';
$curl = curl_init($service_url);

$curl_post_data = array(
    'codicepersonale' => '111111',
    'nome' => 'ciccio',
    'cognome' => 'pasticcio',
    'oggetto' => 'cellulare',
    'prezzo' => '100',
    'codiceutilizzato' => '2222222',
    'amicitrovati' => 2,
    'data' => '2017-09-03'
);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
    die('error occured: ' . $decoded->response->errormessage);
}
echo 'response ok!';