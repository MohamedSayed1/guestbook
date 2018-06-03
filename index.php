<?php
require 'incloudes/config.php';
require 'incloudes/DBinterface.php';
require 'incloudes/models/model.php';
require 'incloudes/models/messagesClass.php';

// get message
$DB = new model();
$message = new messagesClass($DB);
$approved = $message->approved();

include 'public/templates/front/index.html';