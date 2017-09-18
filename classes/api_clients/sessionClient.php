<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 16/09/2017
 * Time: 11:41
 */

class SessionClient
{
    private $service_create_url = 'http://giradastorm.altervista.org/_php/api/session/create.php';
    private $service_read_url = 'http://giradastorm.altervista.org/_php/api/session/select.php?u=';
    private $service_update_url = 'http://giradastorm.altervista.org/_php/api/session/update.php';
    private $service_delete_url = 'http://giradastorm.altervista.org/_php/api/session/delete.php?u=';

    public function GetCurrentSession($username)
    {
        $curl = curl_init($this->service_read_url . $username);
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

    public function CreateNewSession($username, $nome, $cognome, $codicePersonale, $step)
    {
        $curl = curl_init($this->service_create_url);
        $curl_post_data = array(
            'username' => $username,
            'nome' => $nome,
            'cognome' => substr($cognome, 0, 1) . ".",
            'codicePersonale' => $codicePersonale,
            'step' => $step
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

    public function AddCodicePersonale($username, $codicePersonale)
    {
        $curl = curl_init($this->service_update_url);
        $curl_post_data = array(
            'username' => $username,
            'codicePersonale' => $codicePersonale,
            'step' => 'Step1'
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

    public function AddProdotto($username, $prodotto)
    {
        $curl = curl_init($this->service_update_url);
        $curl_post_data = array(
            'username' => $username,
            'prodotto' => $prodotto,
            'step' => 'Step2'
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

    public function AddPrezzo($username, $prezzo)
    {
        $curl = curl_init($this->service_update_url);
        $curl_post_data = array(
            'username' => $username,
            'prezzo' => $prezzo,
            'step' => 'Step3'
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

    public function DeleteCurrentSession($username)
    {
        $curl = curl_init($this->service_delete_url . $username);
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