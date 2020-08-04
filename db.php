<?php

require_once("config.php");

#require_once('../config/db.php');
require_once('connection.php');

#require_once('language.php');
require_once('user.php');

require_once('good.php');

$json = '{"update_id":344460847,
"message":{"message_id":5843,"from":{"id":94665561,"is_bot":false,"first_name":"Murod = \u7a46\u62c9\u5fb7","last_name":"Parmonov = \u6cd5\u4ee4","username":"parmonov98","language_code":"en"},"chat":{"id":94665561,"first_name":"Murod = \u7a46\u62c9\u5fb7","last_name":"Parmonov = \u6cd5\u4ee4","username":"parmonov98","type":"private"},"date":1553659382,"text":"Referallar"}}';

$user = new user(TOKEN, json_decode($json));
$good = new Good(json_decode($json));


		$referals = $user->getReferals(94665561);
		print_r($referals);
		echo $firstLevel = '<br>1-darajali taklif qilingan referallaringiz(odamlar): 
Ismi | hisobi | ro`yxatdan o`tgan vaqti';
		
		

for($i = 0; $i < $referals[0]; $i++){
			$firstLevel .= $referals[0][$i]['u_name']." | ".$referals[0][$i]['u_balance'].' | '.$referals[0][$i]['u_date'];
		}