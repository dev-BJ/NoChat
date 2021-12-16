<?php

function addUser(&$user,&$userlist,$messageObj,$newSocketArrayResource,$chatHandler){
	if(isset($messageObj)){
    if(!isset($user[$messageObj->chat_user])){
        $user[$messageObj->chat_user]=$newSocketArrayResource;
        array_unshift($userlist,$messageObj->chat_user);
		$ack=$chatHandler->newConnectionACK($messageObj->chat_user);
		send($ack);
$userl=["user_list"=>$userlist,
"message_type"=>"users-list"];
$ul=$chatHandler->seal(json_encode($userl));
$success=$chatHandler->seal(json_encode(['message'=>'Successful','message_type'=>'success']));
$chatHandler->send($newSocketArrayResource,$success);
send($ul);

        }else{
            if($user[$messageObj->chat_user]!=$newSocketArrayResource){
            $err=['message'=>"Name has been picked",'message_type'=>'name-error'];
            $seal=$chatHandler->seal(json_encode($err));
            $chatHandler->send($newSocketArrayResource,$seal);
            }	
		}
	}else{
		$userl=["user_list"=>$userlist,
"message_type"=>"users-list"];
$ul=$chatHandler->seal(json_encode($userl));
send($ul);
	}
}

function rmUser(&$user,&$userlist,$newSocketArrayResource,$chatHandler){
    $name=array_search($newSocketArrayResource,$user);
			unset($user[$name]);
			unset($user[$newSocketArrayResource]);
			$key=array_search($name,$userlist);
			unset($userlist[$key]);
			
			$userl=["user_list"=>array_filter($userlist),"message_type"=>"users-list"];
			$ul=$chatHandler->seal(json_encode($userl));
			send($ul);
}

function send($message) {
	global $clientSocketArray;
	$messageLength = strlen($message);
	foreach($clientSocketArray as $clientSocket)
	{
		@socket_write($clientSocket,$message,$messageLength);
	}
	return true;
}

function sendMsg($user,$messageObj,$chatHandler,$newSocketArrayResource){
	if(isset($messageObj)and!empty($messageObj->chat_with)){
    if(isset($user[$messageObj->chat_with])){
		if($messageObj->chat_user==$messageObj->chat_with){
			$err=['message'=>"You can't send a message to yourself",'message_type'=>'error'];
$seal=$chatHandler->seal(json_encode($err));
$chatHandler->send($newSocketArrayResource,$seal);
		}else{
		$chat_box_message = $chatHandler->createChatBoxMessage($messageObj->chat_user, $messageObj->chat_message);
		$chatHandler->send($user[$messageObj->chat_with],$chat_box_message);
		}
	}else{
$err=['message'=>"$messageObj->chat_with is not online",'message_type'=>'error'];
$seal=$chatHandler->seal(json_encode($err));
$chatHandler->send($newSocketArrayResource,$seal);
	}
}
}