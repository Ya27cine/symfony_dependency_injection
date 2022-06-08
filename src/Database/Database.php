<?php

namespace App\Database;

use App\Model\Order;

class Database
{

    public function insertOrder(Order $order)
    {
        dump(">> REQUETE DATABASE POUR INSERER LA COMMANDE");
    }
}
