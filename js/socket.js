$(document).ready(function () {
    websocket = new WebSocket("ws://localhost:8090");
    
    websocket.onopen = function (event) {
        showMessage("<div class='chat-connection-ack'>Connection is established!</div>");		
    }
    websocket.onmessage = function(event) {
        var Data = JSON.parse(event.data);
        if (Data.message_type == "users-list") {
            userList(Data);
        }
        else if(Data.message_type=="name-error"){
            user.attr("type","text");
            showError("<div class='error'>"+Data.message+"</div>");
        msg.val('');
        } else if (Data.message_type=='success') {
            showSuccess("<div class='text-success'>" + Data.message + "</div>");
            setTimeout(function () {
                frm_chat.fadeOut().hide();
                user_list.show().fadeIn();
            }, 3000);
        } else if (Data.message_type == 'error') {
            showError("<div class='error'>"+Data.message+"</div>");
        }
            else{
        showMessage("<div class='"+Data.message_type+"'>"+Data.message+"</div>");
        msg.val('');
        }
    };
    
    websocket.onerror = function (event) {
        showError("<div class='error'>Problem due to some Error</div>");
    };
    websocket.onclose = function(event){
        showMessage("<div class='chat-connection-ack'>Connection Closed</div>");
    }; 
    
    $('#frmChat').on("submit",function(event){
        event.preventDefault();		
        messageJSON = {
            chat_user: $('#chat-user').val(),
            chat_with: $('#chat-with').val(),
            chat_message: $('#chat-message').val()
        };
        console.log(messageJSON)
        var filelist = document.querySelector("#send-file").files;
        fileWalker(filelist);
        if (messageJSON.chat_message.length > 0) {
            showMessage("<div class='chat-box-html'>YOU: " + messageJSON.chat_message + "</div>");
        }
        user_list.hide();
        msg.val('');
        send_file.val('');
        websocket.send(JSON.stringify(messageJSON));
    });
});