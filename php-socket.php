<?php
define('HOST_NAME',"localhost"); 
define('PORT',"8090");
$null = NULL;
$user=[];
$userlist=[];

require_once("class.chathandler.php");
require_once("func.php");
$chatHandler = new ChatHandler();
$socketResource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socketResource, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socketResource, 0, PORT);
socket_listen($socketResource);

$clientSocketArray = array($socketResource);
while (true) {
	$newSocketArray = $clientSocketArray;
	socket_select($newSocketArray, $null, $null, 0, 10);
	
	if (in_array($socketResource, $newSocketArray)) {
		$newSocket = socket_accept($socketResource);
		$clientSocketArray[] = $newSocket;
		
		$header = socket_read($newSocket, 1024);
		$chatHandler->doHandshake($header, $newSocket, HOST_NAME, PORT);
		
		$newSocketIndex = array_search($socketResource, $newSocketArray);
		unset($newSocketArray[$newSocketIndex]);
	}
	
	foreach ($newSocketArray as $newSocketArrayResource) {	
		while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1){
			$socketMessage = $chatHandler->unseal($socketData);
			$messageObj = json_decode($socketMessage);
//add user
	addUser($user,$userlist,$messageObj,$newSocketArrayResource,$chatHandler);
	//send message
	sendMsg($user,$messageObj,$chatHandler,$newSocketArrayResource);
			break 2;
		}
		
		$socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
		if ($socketData === false) { 
			$newSocketIndex = array_search($newSocketArrayResource, $clientSocketArray);

			rmUser($user,$userlist,$newSocketArrayResource,$chatHandler);
			var_dump($userlist);
			
						unset($clientSocketArray[$newSocketIndex]);			
		}
	}
}
socket_close($socketResource);