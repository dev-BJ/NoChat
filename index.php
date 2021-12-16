<!doctype HTML>
<?php
set_time_limit(0);
ignore_user_abort(0);
?>
<html>
<head>
<title>NoChat</title>
	<link href="css/style.css" rel="stylesheet" type="text/css" ></link>
	<script src="js/jquery.js"></script>
	<script src="js/socket.js" ></script>
	<script src="js/func.js" ></script>
	<script src="js/ot.js" ></script>
	</head>
	<body>
		<div class="err" ></div>
		<div class="tab" >
			<div class="tab-item"></div>
			<div class="tab-item right"></div>
		</div>
	<div id="user-list" class="user-list"></div>
	<div id="chat-box"></div>
		<form name="frmChat" id="frmChat">
			<input type="text" name="chat-user" id="chat-user" placeholder="Name" class="chat-input" required />
			<input type="text" name="chat-with" id="chat-with" placeholder="To" class="chat-input" />
			<input type="text" name="chat-message" id="chat-message" placeholder="Message"  class="chat-input chat-message" />
			<input type="file" name="send-file" id="send-file" accept="image/*"
			class="chat-input" multiple />
			<input type="submit" id="btnSend" name="send-chat-message" value="Send" >
		</form>
</body>
</html>