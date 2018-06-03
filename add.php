<?php
require 'incloudes/config.php';
require 'incloudes/allPramter.php';
require 'incloudes/DBinterface.php';
require 'incloudes/models/model.php';
require 'incloudes/models/messagesClass.php';


if(count($_POST) > 0)
{
    $data = new allPramter();
    $Db = new model();
    $data->setTitle($_POST['title']);
    $data->setMessage($_POST['message']);
    $data->setPhone($_POST['phone']);
    $data->setEmail($_POST['email']);
    $data->setName($_POST['name']);

    $add = new messagesClass($Db);

    if($add->addMassage($data))
        $mes = "Success add Your Message, ";
        include 'public/templates/front/success.html';

    // else error after add validation


}

else
    {
        // not submit
        header('LOCATION: index.php');
    }
