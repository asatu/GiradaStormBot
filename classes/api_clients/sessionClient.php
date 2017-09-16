<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 16/09/2017
 * Time: 11:41
 */

class SessionClient
{
    private $service_url = 'http://giradastorm.altervista.org/_php/api/session/select.php';

    public function GetCurrentSession($username)
    {
        $curl = curl_init($this->service_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);

        return json_decode($curl_response);
    }
}