class LightSocket
{
    constructor()
    {
        this.application_module = "LightSocket";
        this.application_version = "1.0";
        this.socket_ip = "https://185.91.116.167:80/";
        this.socket = io(this.socket_ip, {transports: ["websocket"]}); 
        console.log("Initializing app " + this.application_module + "; version: " + this.application_version);
    }

    
    /**
     * 
     * @param {String} channel          -> define socket channel
     * @param {Object} data             -> sends data to socket
     * @param {Function} callback       -> after sending -> callback if defined
     * @returns {callback|null}         -> return depends on settings
     */
    sendToSocket(channel, data, callback = null)
    {
        this.socket.emit(channel, data);
        
        if(callback !== null)
        {
            return callback();
        }
        else
        {
            return null;
        }
    }
    
    /**
     * 
     * @param {String} channel              -> requesting channel
     * @param {Object} data                 -> retrieved data from socket
     * @param {type} callback               -> on requesting -> work with data in function  
     * @returns {Bool}                      -> returns true
     */
    socketEmit(channel, data, callback = null)
    {
        this.socket.on(channel, (data) => {
            callback(data);
        });
        
        return true;
    }
    
    /**
     * 
     * @param {String} template
     * @param {Object} data
     * @param {String} element
     * @param {String} addToHtml
     * @returns {Bool|Error}
     */
    getTemplate(template, data, element = "", addToHtml = "append")
    {
        $.post({
            url: "/plugins/lora/lightsocket/api/sendTemplate.php",
            data: {
                "token": $("input[name=token]").val(),
                "SID": $("input[name=SID]").val(),
                "template": template,
                "data": data
            },

            success: (data) => {
                var json_data = JSON.parse(data);
                    const return_data = json_data.return;
                    if(element !== "")
                    {
                        if(addToHtml == "append")
                        {
                            $(element).append(return_data);
                        }
                        else
                        {
                            $(element).prepend(return_data);
                        }
                        return true;
                    }
                    else
                    {
                        return return_data;
                    }
                    
                   
                },

            error:function(thrownError){
              return console.log(thrownError);
            }
        });
        
    }
    
    /**
     * 
     * @param {String} channel                  </p>Socket channel</p>
     * @param {String} receiver [uid= ""]       <p></p>
     * @returns {Element}                       <p>Returns new element #notification-block</p>
     */
    sendNotification(channel, header, content, receiver = "")
    {
        this.socketEmit(channel, (data) => {
            //If receiver is null, condition is required by template, else => send for concrete user
            if(receiver != "")
            {
                if(data.user_for == receiver)
                {
                    var dialog_id = randomInt(1111,9999);
                    var dialog_notif;
                    dialog_notif = GUIDialog.dialogNotification(dialog_id, header, content); 
                    
                    //Generate Notification
                    if(!($("#dialog-notification-"+dialog_id).length))
                    {
                        $('#notification-block').prepend(dialog_notif).prepend(dialog_notif);
                    }
                }
            } 
            else
            {
                var dialog_id = randomInt(1111,9999);
                var dialog_notif;
                dialog_notif=GUIDialog.dialogNotification(dialog_id, header, content); 
                
                //Generate Notification
                if(!($("#dialog-notification-"+dialog_id).length))
                {
                    $('#notification-block').prepend(dialog_notif).prepend(dialog_notif);
                }
            }
        });
    }
}

//Initialize app
let LS = new LightSocket();







