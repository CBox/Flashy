<?php

# Subscribe Contact to List
require_once("../library/Flashy.php");

$flashy = new Flashy("API_KEY");

$feed_id = 999;

$subscribe = $flashy->lists->subscribe($feed_id, array(
	"first_name"	=> 'Jhon Doe',
	"email"			=> 'email@addres.com',
	"phone"			=> '+972526845430'
));

var_dump($subscribe);