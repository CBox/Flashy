<?php

# Sample Sending
require_once("../library/Flashy.php");

$flashy = new Flashy("NKCUatAZ7j6yjJyukIeRJH");

$message = array(
	"from_name" => "COMPANY",
	"to"		=> "972526845430",
	"message"	=> "Hey there, hello world from Flashy.",
);

$test = $flashy->sms->send($message);