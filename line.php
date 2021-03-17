<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'lg5IqRjtt/+/Jal1O+giqlt+sjO77C+hekvOgqugrGzo7W2fqIG7NDVZ9fKiiNlppzU+YdGsq1webTiFJixMljN2LgAdgUzph3jIq7mhkpDd24InyJydf/1EmUSAfS+kqlNlUZ3Y411yB2NJjl+2VAdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
		$text = $event['message']['text'];
		
	   	if($text == "ชื่อ" || $text == "ชื่ออะไร" || $text == "ชื่ออะไรครับ"|| $text == "ชื่ออะไรคะ"){
			$reply_message = 'ชื่อของฉันคือ BOTCAT ครับ';
		}
	   
		if($text == "สถานการณ์โควิดวันนี้" || $text == "covid19" || $text == "covid-19" || $text == "Covid-19"){
		   $url = 'https://covid19.th-stat.com/api/open/today';
// 		   $ch = curl_init($url);
// 		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// 		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 		   curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
// 		   curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
// 		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
// 		   $result = curl_exec($ch);
// 		   curl_close($ch);   
		   
// 		   $obj = json_decode($result);
		   $json = file_get_contents($url);
		   $obj = json_decode($json);
		   
		   //$reply_message = $result;
		   //$reply_message = 'ติดเชื้อสะสมโว้ยยย!!! '. $obj->{'Confirmed'} .' คน เสียชีวิต '.$obj->{'Deaths'} . ' คน' .' คน รักษาหายแล้ว '.$obj->{'Recovered'} . ' คน';
		   $reply_message = 'ติดเชื้อสะสมโว้ยยย!!! '. $obj->Confirmed .' คน เสียชีวิต '.$obj->Deaths . ' คน' .' คน รักษาหายแล้ว '.$obj->Recovered . ' คน';
		   //$reply_message = 'ติดเชื้อสะสมโว้ยยย!!! ';
	
	        }	
	   
	   if($text =="@บอท ขอรหัสนิสิตของผู้พัฒนา ส่งไปที่ https://linebot.kantit.com/stuid.php"){
	    	  $url = 'https://linebot.kantit.com/stuid.php';
		   $ch = curl_init($url);
		   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
		   curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
		   curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		   $result = curl_exec($ch);
		   curl_close($ch);   		   
		   $obj = json_decode($result);		   
		   $reply_message = $result;
		   //$reply_message = 'ผลการบันทึกข้อมูล'. $obj->{'status'} .' และ '.$obj->{'data'} . ' OK!';
	   }
	   
	   if($text =="@บอท ขอรายชื่อนิสิตที่ส่งงาน LineBoT"){
	    	   $url = 'https://linebot.kantit.com/list.php';
		   
		   $reply_message = file_get_contents($url);   // Get request content
		   
		   //$request_array = json_decode($request, true);   // Decode JSON to Array
		   
		   //$result = file_get_contents($url);		   
		   //$obj = json_decode($result);
		   //$reply_message = 'มีส่งงาน '. $obj->{'Confirmed'} .' คน ได้แก่...';
		   //$reply_message = 'ติดเชื้อสะสม '. $obj->{'Confirmed'} .' คน รักษาหายแล้ว '.$obj->{'Recovered'} . ' คน';
		   $reply_message = "โปรดรอสักครู่....";
	   }
	   
	     if($text =="@บอท ขอที่อยู่มทร.หน่อยจิ"){
	    	   $url = 'https://www.google.com/maps/place/Phra+Nakhon+Si+Ayutthaya/@14.3935691,100.237786,10z/data=!3m1!4b1!4m8!1m2!2m1!1smaps+google!3m4!1s0x30e2736f5bfd8f7f:0x1019237450c4860!8m2!3d14.3532128!4d100.5689599';
		   
		   $reply_message = $url;   // Get request content

		   //$reply_message = $reply_message;
	   }
	   
		//$reply_message = '('.$text.') ได้รับข้อความเรียบร้อย!!';   
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>
