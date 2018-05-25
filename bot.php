<?php 
define('BOT_TOKEN', '');
define('API_URL', 'https://api.telegram.org/bot'.BOT_TOKEN.'/');

// read incoming info and grab the chatID
$content    = file_get_contents("php://input");
$update     = json_decode($content, true);
$update_id  = $update["update_id"];
$message_id = $update["message"]["message_id"];
$chatID     = $update["message"]["chat"]["id"];
$unixdate   = $update["message"]["date"];
$message    = $update["message"]["text"];
$username   = $update["message"]["from"]["username"];
//$tgid       = $update["message"]["from"]["id"];
$username   = $update["message"]["chat"]["username"];
//$tgid       = $update["message"]["chat"]["id"];
$fn   	    = $update["message"]["from"]["first_name"];
$ln         = $update["message"]["from"]["last_name"];

// compose reply
$reply ="";
$mes5=substr($message,0,6);
switch ($mes5) {
    case "/start":
        //$reply =  "Добро пожаловать в SquadRunner Boost bot, ".$fn." ".$ln." (chatID=".$chatID." user=".$username .") !" ;
//        $reply .= "Передайте это сообщение капитану Вашей команды, чтобы он внёс эти данные в базу и добавил Вас в свой сквад.";
        $reply =  "Добрый день! /help - список команд." ;
        include 'start_include.php';
        $reply .=add_runner($username,$fn." ".$ln,$chatID);
        //$reply .=""
        break;
    case "/help":
        $reply =  "Доступные команды: /start , /help , /list , /planr, /delete";
        break;
    case "/list":
        $reply =  "Беговые планы сквада";
        include 'list_include.php';
        $run_list=run_plans_list($chatID);
        $reply .=  $run_list;
        break;
    case "/planr":
        $reply =  "Добавляем новый план бегуна";
        include 'add_include.php';
        $add_res=add_run_plan($chatID,$message);
      $reply .=  $add_res;
  //      $reply .=  "Теперь список выглядит так";
//        $run_list=run_plans_list($tgid);
     //   $reply .=  $run_list;
        break;
    case "/delet":
        $reply =  "Удаляем строку из плана";
        include 'delete_include.php';
        $run_list=run_plans_delete($chatID,$message);
        $reply .=  $run_list;
        break;
    default:
        $reply =  "не понимаю: ".$mes5;
}

// send reply
$pm="Markdown";
//$pm="HTML";
//$pm="'HTML'";
$sendto =API_URL."sendmessage?chat_id=".$chatID."&text=".$reply."&parse_mode=".$pm;
//$sendto =API_URL."sendmessage?chat_id=".$chatID."&text=".$reply;
file_get_contents($sendto);

// Create a debug log.txt to check the response/repy from Telegram in JSON format.
// You can disable it by commenting checkJSON.
checkJSON($chatID,$update);

//function add_log($update_id,$message_id,$chat_id,$unixdate,$message)
include 'log_include.php';
//add_log("911045762","837","83033404","1527150194","/list");
add_log($update_id,$message_id,$chatID,$unixdate,$message);

function checkJSON($chatID,$update){

    $myFile = "log.txt";
    $updateArray = print_r($update,TRUE);
    $fh = fopen($myFile, 'a') or die("can't open file");
    fwrite($fh, $chatID ."-");
    fwrite($fh, $updateArray."+");
    fclose($fh);
}