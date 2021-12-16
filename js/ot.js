var websocket, chat_box, msg, user, chattee, send_file, user_list, send_btn, frm_chat;
var tab,messageJSON,isChat;
$(document).ready(function () {
    chat_box = $('#chat-box');
    msg = $('#chat-message');
    user = $('#chat-user');
    chattee = $('#chat-with');
    send_file = $('#send-file');
    user_list = $('#user-list');
    send_btn = $('#btnSend');
    frm_chat = $('#frmChat');

    chat_box.hide();
    msg.hide();
    chattee.hide();
    send_file.hide();
    user_list.hide()


    send_btn.val('Join');

    send_btn.css({
        "position": "absolute",
        "left": "30px"
    });

    if (!chat_box.is(':visible')) {
        frm_chat.css({
            "left": "200px",
            "top": "150px"
        });  
    }
});