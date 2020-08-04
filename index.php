<?php

setcookie('redirect', $_SERVER['REQUEST_URI']);
setcookie('remote_host', $_SERVER['HTTP_HOST']);

//echo $_SERVER['HTTP_HOST'];

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

if(!empty($_POST['name']))
	$name = $_POST['name'];
else{
	echo "Sorry, your Name contains buggy data! to contact with Murod Parmonov, look for on Telegram: @parmonov98 ";
	die;
}
if(!empty($_POST['subject']))
	$subject = $_POST['subject'];
else{
	$subject = 'empty';
}
if(!empty($_POST['email']))
	$email = $_POST['email'];
else{
	echo "Sorry, your Email contains buggy data! to contact with Murod Parmonov, look for on Telegram: @parmonov98 ";
	die;
}
if(!empty($_POST['message']))
	$text = $_POST['message'];

else{
	echo "E'tiborli bo'ling, Sizning xabaringiz kutilmagan belgilari bor! Murod Parmonov bilan aloqaga chiqish uchun Telegram da @parmonov98 orqali xabar yozing.";
	die;
}


$data = [
'chat_id' => 94665561, 
'display' => "<b>Ismi:</b> $name ;
<b>Pochtasi:</b> $email ;
<b>Mavzu:</b> $subject ;
<b>Matni:</b> $text ;",
'isSite' => 'yes',
'text' => $text,
'subject' => $subject,
'email' => $email,
'name' => $name
];
	
$res = sendMessage($data);

if($res == 1){
	if($_SERVER['HTTP_HOST'] == 'parmonov98.uz'){
		header('refresh:2;url=index.html');
		echo '<img src="https://parmonov98.uz/accepted.png">';
	}else{
		header('refresh:2;url=index.html');
		echo '<img src="https://parmonov98.uz/unaccepted.png">';
	}
	
}else{
	header('refresh:2;url=index.html');
	echo '<img src="https://parmonov98.uz/unaccepted.png">';
}

/*
if(file_exists('res.txt')){
	unlink('res.txt');
	echo "Your message sent to Murod Parmonov";
	/*
	sleep(3);
	header('Location: https://parmonov98.info/index.html');
	*/
	
	/*
}else{
	echo "Sorry, your message contains buggy data! to contact with Murod Parmonov, look for on Telegram: @parmonov98 |||| ";
	
	/*sleep(3);
	header('Location: https://parmonov98.info/index.html');

}
*/
function sendMessage($content) {

  #$postdata = http_build_query($content);
  $curl = curl_init(); 

  
		
		curl_setopt($curl, CURLOPT_URL, 'https://parmonov98.uz/receive.php'); 
		
        //return the transfer as a string 
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($content));
        // $output contains the output string 
        $output = curl_exec($curl); 

        curl_close($curl);      
		
 
	file_put_contents("return_sent.txt", $output);
	return $output;

}


?>