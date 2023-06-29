class APP
{
    constructor()
    {
        this.appname = "Stylize version 1.0";
        this.appversion = "1.0.0";
        this.debugon = true;
    }
    
    
    writeLog(content)
    {
        if(this.debugon === true)
        {
            var date = new Date();
            var months = ["Leden", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var month = months[date.getMonth()];
            console.log("[STYLIZE]: "+date.getDate()+". "+month+" "+date.getFullYear()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds()+" -"+content);
        }
    }
}
