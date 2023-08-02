//Language constant Array
const Lang = [];

//VALIDATION
var prev_i = 1;
for(var i = 0; i < 15; i++)
{
    var number = prev_i = prev_i*2;
    
    //Set Max chars input
    Lang['validation.maxchars'+number] = "Pole musí obsahovat maximálně "+number+" znaků";
    Lang['validation.minchars'+number] = "Pole musí obsahovat nejméně "+number+" znaků";
    
    prev_i = number;
}

Lang['validation.0or1'] = "Pole musí obsahovat pouze 1 nebo 0";
Lang['validation.required'] = "Toto pole nesmí být prázdné";
Lang['validation.url'] = "Pole musí obsahovat malá písmena, bez diakritiky, bez mezer, jsou povolené pouze pomlčky";
Lang['validation.email'] = "Toto pole musí být platný email";
Lang['validation.passwordvalidate'] = "Hesla se musí shodovat";

