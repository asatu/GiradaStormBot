<?php
/**
 * Created by PhpStorm.
 * User: csimb
 * Date: 08/09/2017
 * Time: 08:30
 */

class Order
{
    public $personalcode;
    public $product;
    public $price;
    public $step = 1; //1: Codice personale, 2: prodotto, 3: prezzo
}