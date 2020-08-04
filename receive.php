<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

require_once 'config.php';
require_once 'connection.php';

$connection = new connection();

$mail = new PHPMailer(true);


    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->SMTPDebug = 2;                                       // Enable verbose debug output
    $mail->Host       = SMPT_HOST;  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = SMPT_USER;                     // SMTP username
    $mail->Password   = SMPT_PASS;                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to
    
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
	
	 $mail->setFrom(SENDER_ADDRESS, REPLY_DISPLAY);
    
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    

$response  = file_get_contents('php://input'); // handling messages


file_put_contents('test_message.txt', $response); // for testing response message

$message = json_decode($response, 1);

//file_put_contents('updates/'.$message['update_id'].'.txt', $response); // for testing response message


if(file_exists('reply.txt') AND $message['message']['from']['id'] == ADMIN_BOT){

	$body = $message['message']['text'];
	$pieces = explode('|', file_get_contents('reply.txt'));
	$details = [
	'receiver' => $pieces[0]
	];
	$sql = "UPDATE `messages_of_bot` SET `answered` = '1' WHERE `messages_of_bot`.`id` = ".$pieces[1]; 

	$connection->update($sql);
	
	unlink('reply.txt');
	if(sendMail($mail, $body, $details)){
		
		$data = [
		'chat_id' => $message['message']['from']['id'], 
		'text' => "Xabar Email orqali jo'natildi.", 
		'parse_mode' => 'HTML',
		'reply_to_message' => $message['message']['message_id']
		];
	}else{
						
		$data = [
		'chat_id' => $message['message']['from']['id'], 
		'text' => "Xabar Email orqali jo'natilmadi.", 
		'parse_mode' => 'HTML',
		'reply_to_message' => $message['message']['message_id']
		];

	}

	sendMessage($data, 'sendMessage');
	
	die;
}




if($message['isSite'] == 'yes'){
		
		file_put_contents('res.txt', 1); // 

		$sql = "INSERT into `messages_of_bot` 
		(`sender`, `subject`, `text`, `datetime`) 
		VALUES('".$message['email']."', '".$message['subject']."', 
		'".$message['text']."', ".time().")";

		$id = $connection->insert($sql);
		
		if($id === true){
			
			$id = $connection->getLastInsertId();
			
			$data = [
				'chat_id' => ADMIN_BOT, 
				'text' => "Murodjon sen bilan qiziqishyapti:
<b>Murojaat turi:</b> sayt orqali
".$message['display'],
'parse_mode' => 'HTML',
'reply_markup' => json_encode(replyInlineMarkUp($id))] ;
			sendMessage($data, 'sendMessage');
			echo 1;
		}else{
			echo 0;
		}

	die;
	
}else if($message['message']['text'] == '/start'){

	$data = [
	'chat_id' => $message['message']['from']['id'], 
	'text' => "Assalomu alaykum, Men <b>Murod Parmonov</b>ning taklif|buyurtma|fikr| qabul qiladigan botiman!:). 
Hurmatli murojaat qiluvchi. Xush kelibsiz!
Xabar jo'natayotganizda barcha savol yoki takliflarizni bitta xabarda jo'nating. Agar yozib tushuntirish qiyin bo'lsa yoki noqulay bo'lsa, telefon raqamizni qoldiring va o'zim tez orada siz bilan bog'lanaman.",
'parse_mode' => 'HTML'
	
	];

	sendMessage($data, 'sendMessage');
}else{
	
	if($message['message']['from']['id'] == ADMIN_BOT){
		if($message['message']['reply_to_message']['forward_from']['id']){
			
			
			
			$data = [
			'chat_id' => $message['message']['reply_to_message']['forward_from']['id'], 
			'text' => $message['message']['text'],
			'parse_mode' => 'HTML'
			];
			  
			$replytocustomer = sendMessage($data, 'sendMessage');
			file_put_contents("replytocustomer.txt", $replytocustomer);
			 
			$data = [
			'chat_id' => $message['message']['from']['id'], 
			'text' => "Javob berildi!",
			'parse_mode' => 'HTML',
			'reply_to_message_id' => $message['message']['message_id']
			];
 
			sendMessage($data, 'sendMessage');
		}elseif($message['message']['reply_to_message']['from']['id'] == 814120399){
			
			$body = $message['message']['text'];
			
			$details = [
			'receiver' => 'parmonov98@yandex.ru'
			];
			if(sendMail($mail, $body, $details)){
				
				$data = [
				'chat_id' => $message['message']['from']['id'], 
				'text' => "Xabar Email orqali jo'natildi.", 
				'parse_mode' => 'HTML',
				'reply_to_message' => $message['message']['message_id']
				];
			}else{
								
				$data = [
				'chat_id' => $message['message']['from']['id'], 
				'text' => "Xabar Email orqali jo'natilmadi.", 
				'parse_mode' => 'HTML',
				'reply_to_message' => $message['message']['message_id']
				];

			}

			sendMessage($data, 'sendMessage');
		}else{
			
			$data = [
			'chat_id' => $message['message']['from']['id'], 
			'text' => "Murod kallani garang qilma! Biron bir foydali yangi texnologiya o'rgan.", 
			'parse_mode' => 'HTML',
			'reply_to_message' => $message['message']['message_id']
			];
 
			sendMessage($data, 'sendMessage');
		}
		file_put_contents('replyfromme.txt', $response); 
	}else{
		
		 
		
		if($message['message']['text']){
			
			$data = [
			'chat_id' => $message['message']['from']['id'], 
			'text' => "Xabaringiz qabul qilindi! Kuting o'zim siz bilan albatta aloqaga chiqaman.",
			'parse_mode' => 'HTML',
			'reply_to_message' => $message['message']['message_id']	
			];

			sendMessage($data, 'sendMessage');
		}elseif($message['callback_query']){
			$sql = "SELECT * from messages_of_bot WHERE id = ".$message['callback_query']['data'];

			$mess = $connection->select($sql);

			if(is_array($mess)){
				$data = [
					'chat_id' => $message['callback_query']['from']['id'], 
					'text' => "Javob xatini kiriting va jo'nating: ",
					'parse_mode' => 'HTML',
					'reply_to_message' => $message['callback_query']['message']['message_id']	
				];
			}
			
			file_put_contents('reply.txt', $mess[0]['sender'].'|'.$mess[0]['id']);
	
			sendMessage($data, 'sendMessage');
		}
			
		$forward = [
		'chat_id' => 94665561, 
		'from_chat_id' => $message['message']['from']['id'], 
		'message_id' => $message['message']['message_id']
		];

		sendMessage($forward, 'forwardMessage');
	}
}


function replyInlineMarkUp($id){
	file_put_contents('number.txt', $id);
	$reply = [
		'inline_keyboard' => [
			[
				[ 'text' => "Javob berish",
				'callback_data' => $id ]
			]

		]
	];

	return $reply;
}


function sendMessage($content, $method, $type = '') {

	#$postdata = http_build_query($content);
	$curl = curl_init(); 
  
		  // set url 
		  curl_setopt($curl, CURLOPT_URL, MAIN_URL.$method); 
  
		  //return the transfer as a string 
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		  
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
		  // $output contains the output string 
		  $output = curl_exec($curl); 
  
		  curl_close($curl);      
		  
   
	  file_put_contents("return_sent_receive.txt", $output);
	  return $output;
  
  }
	 
  
  
  function sendMail($mail, $body = '<b>in bold!</b>', $details){
	  
	  //Recipients
	 
	  $mail->addAddress($details['receiver'], 'Murod Parmonov');     // Add a recipient
	  $mail->addReplyTo($details['receiver'], 'Reply to me');
	  
	  // Content
	  $mail->isHTML(true);                                  // Set email format to HTML
	  $mail->Subject = 'Here is the subject';
	  $mail->Body    = 'This is the HTML message body ' . $body;
	  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	  
	  try{
		  $mail->send();
		  
	  }catch(Exception $e){
		  return false;
	  }
	  return true;
  }
  
  /*
 
$data = [
'chat_id' => $message['message']['from']['id'], 
'text' => 'response from test!'
];

sendMessage($data, 'sendMessage'); 
  */