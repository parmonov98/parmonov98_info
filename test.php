<?php



define("TOKEN", '814120399:AAF_DTcIFZb4yDHdAu9uTVUVUNnHC4v6JG8'); // token of your bot
define("MAIN_URL", 'https://api.telegram.org/bot814120399:AAF_DTcIFZb4yDHdAu9uTVUVUNnHC4v6JG8/');
 

$response  = file_get_contents('php://input'); // handling messages

file_put_contents('test_message.txt', $response); // for testing response message

$message = json_decode($response, 1);

$data = [
'chat_id' => $message['message']['from']['id'], 
'text' => 'response from test!'
];

sendMessage($data, 'sendMessage');

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
		
 
	#file_put_contents("return_sent.txt", $output);
	return $output;

}
