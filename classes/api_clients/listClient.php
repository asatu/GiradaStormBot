<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 18/09/2017
 * Time: 14:31
 */

class ListClient
{
    private $service_get_in_url = 'http://giradastorm.altervista.org/_php/api/list/getin.php';

    public function GetIn($username)
    {
        $curl = curl_init($this->service_create_url);
        $curl_post_data = array(
            'username' => $username
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($curl_post_data));
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

        return true;
    }
}