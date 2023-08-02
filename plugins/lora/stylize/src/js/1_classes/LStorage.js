class LStorage
{
    constructor()
    {
        
    }
    
    getToken()
    {
        return localStorage.getItem("TOKEN");
    }
    
    getSID()
    {
        return localStorage.getItem("SID");
    }
    
    getCsrf()
    {
       return "<input hidden type='text' name='token' value='"+this.getToken()+"'> <input hidden type='text' name='SID' value='"+this.getSID()+"'>";
    }
}


