<?php

# Send SMS Message
require_once("../library/Flashy.php");

$flashy = new Flashy("API_KEY");

$message = array(
	"from" => "COMPANY",
	"to"		=> "972523000445",
	"message"	=> "Hey there, hello world from Flashy.",
);

$test = $flashy->sms->send($message);

var_dump($test);