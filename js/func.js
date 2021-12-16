$(document).ready(function () {
    
});
function process(file) {
    for (var i = 0; i < file.length; i++){
        var list = file[i];
        if (list.type == "image/jpeg" || "image/gif" || "image/png") {
            messageJSON.send_file[i] = {
                "name": list.name,
                "type": list.type,
                "size": list.size,
                "data":img(list,true)
            };
            showMessage("<div class='chat-box-html'>YOU: Sent this to "+messageJSON.chat_with+"</div>");
            showMessage(img(list));
                }
        }
}

function showMessage(messageHTML) {
    $('#chat-box').append(messageHTML);
}

function showError(errMsg) {
    var err = $('.err');
    err.css('border-radius', '5px');
    err.addClass('alert-danger').addClass('text-danger').html(errMsg).fadeIn();
    setInterval(turnOff, 3000)
    function turnOff() {
        err.fadeOut().hide();
        err.removeClass("alert-danger text-danger");
    }
}

function showSuccess(sucMsg) {
    var err = $('.err');
    err.css('border-radius', '5px');
    err.addClass('alert-success').addClass('text-success').html(sucMsg).fadeIn();
    setInterval(turnOff, 3000)
    function turnOff() {
        err.fadeOut().hide();
        err.removeClass("alert-success text-success");
    }
}

function img(file,ret) {
    var reader = new FileReader();
    var i = new Image(100,100);
    reader.onload = function (e) {
        i.src = e.currentTarget.result;
    }
    reader.readAsDataURL(file);
    return ret?i.src:i;
}

function userList(Data) {
    var ul = $("#user-list");
    var li;
    ul.empty();
    var user = Data.user_list;
    for (var i = 0; i < user.length; i++){
        li = $("<ul>");
        var st = $('<li>');
        li.attr('class', 'with');
        li.attr('data-name',user[i])
        li.text(user[i]);
        li.css({ "cursor": "pointer" });
        li.click(function (e) {
            e.preventDefault();
            ul.fadeOut(1000);
            chattee.attr('value', e.target.dataset.name)
            chat_box.fadeIn(1000);
            msg.show();
            send_file.show();
            send_btn.val('Send');
            send_btn.show();
            frm_chat.css({
                "left": "initial",
                "top": "initial"
            });
            isChat = true;
            frm_chat.fadeIn(1000);

        });
        st.append(li);
        st.append($('<br/>'));
        ul.append(st);
    }
    
}

function fileWalker(filelist) {
    if (filelist.length>0) {
        alert("file")
        process(filelist);
        }
}