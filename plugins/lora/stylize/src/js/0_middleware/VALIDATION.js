class VALIDATION
{
    constructor()
    {
        this.input = [];
        Application.writeLog("Validation module loaded");
        this.errorString = "";
        this.validationStatus = [];
    }
    
    /**
     * 
     * @param {String} password_input1  <p>First password input</p>
     * @param {String} password_input2  <p>Second (controll) password input</p>
     * @param {Function} bad_callback   <p>Callback if validate is WRONG</p>
     * @returns {True|Event}     <p>If validation is correct = returns TRUE else bad_callback()</p>
     */
    validatePasswords(password_input1, password_input2, bad_callback = null)
    {
        var password1 = $(password_input1).val();
        var password2 = $(password_input2).val();
        if(password1 != "" && password2 != "")
        {
            if(password1 === password2)
            {
                return true;
            }
            else
            {
                if(bad_callback !== null)
                {
                    bad_callback();
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            if(bad_callback !== null)
            {
                bad_callback();
            }
            else
            {
                return false;
            }
        }
    }
    
    /**
     * 
     * @param {type} element_input -    ID or class or other selector: ex.: #this-element; .element
     * @param {Array} validation -      Array of required validations: maxchars8|
     * @param {String} true_class       Apply these classes if Validation of this input is TRUE
     * @param {String} error_class      Apply these classes if Validation of this input is FALSE
     * @returns {Boolean|getError()}
     */
    validate(element_input, validation = [], true_class="t-create", error_class = "t-error")
    {       
        //input is required
        if(validation.indexOf("required") !== -1)
        {
            var length = $(element_input).val().length;
            if(length > 0)
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.required']);               
            }
        }
        
        if(validation.indexOf("password-validate") !== -1)
        {
            var password1 = $(element_input).val();
            var password2 = $(element_input+"-2").val();
            if(password1 === password2)
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.passwordvalidate']);               
            }
        }
        
        
        //Max|Min chars
        var loop_state_count = 15;
        var prev_i = 1;
        for(var i = 0; i < loop_state_count; i++)
        {
            var number = prev_i = prev_i*2;
            if(validation.indexOf("maxchars"+number) !== -1)
            {
                var length = $(element_input).val().length;
                if(length <= number)
                {
                    this.validationStatus.push("true");
                }
                else
                {
                    this.validationStatus.push("false");
                    this.setError(Lang['validation.maxchars'+number]);               
                }
            }
            
            if(validation.indexOf("minchars"+number) !== -1)
            {
                var length = $(element_input).val().length;
                if(length >= number)
                {
                    this.validationStatus.push("true");
                }
                else
                {
                    this.validationStatus.push("false");
                    this.setError(Lang['validation.minchars'+number]);               
                }
            }
            
            prev_i = number;
        }
        
        //if input has 1 or 0
        if(validation.indexOf("0or1") !== -1)
        {
            var length = $(element_input).val().length;
            if(length === 1 && ($(element_input).val() === "0" || $(element_input).val() === "1"))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.0or1']);              
            }
        }
        
        
        //URL
        if(validation.indexOf("url") !== -1)
        {
            var regex = /^[a-z]+(-[a-z]+)*$/;
            if(regex.test($(element_input).val()))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.url']);              
            }
        }
        
        //EMAIL
        if(validation.indexOf("email") !== -1)
        {
            var regex = /^\S+@\S+\.\S+$/;
            if(regex.test($(element_input).val()))
            {
                this.validationStatus.push("true");
            }
            else
            {
                this.validationStatus.push("false");
                this.setError(Lang['validation.email']);              
            }
        }
        
        // /^\S+@\S+\.\S+$/
        
        //'/^([0-9 a-z\s\-]+)$/'
        
        
        //Error writer element
        var error_writer = $("*[valid-for='"+element_input+"']");
        
        
        //Check all required validation statuses
        if(this.isValidated() === true)
        {
            $(element_input).removeClass(error_class);
            $(element_input).addClass(true_class);
            
            $(error_writer).removeClass(error_class);
            $(error_writer).addClass(true_class);
            
            $(error_writer).html("<i class='fa fa-check-circle'></i>");
            this.validationStatus = [];
            return true;
        }
        else
        {
            $(element_input).removeClass(true_class);
            $(element_input).addClass(error_class); 
            
            $(error_writer).removeClass(true_class);
            $(error_writer).addClass(error_class); 
            
            $(error_writer).html(this.errorString);
            this.validationStatus = [];
            return false;
        }
       
        this.errorString = "";
    }
    
    isValidated()
    {
        if(this.validationStatus.indexOf("false") !== -1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    getError()
    {
        return this.errorString;
    }
 
    setError(error_text)
    {
        var message = "<i class='fa fa-window-close'></i> "+ error_text + " ";
        this.errorString += message;
    }
}
