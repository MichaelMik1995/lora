function cookieBar()
{
    if(getCookie("cookies_accepted") == "")
    {
        var element = "<div id='cookie_bar' class='row bottom-fixed pd-2 background-dark-3 bd-top-basic'>"+
            "<div class='column-8 column-10-xsm'>"+
                "<div class='row'>"+
                    "<div class='column-5'>"+
                        "<div class='header-6 pdy-1 t-bolder'>"+
                            "Vážíme si Vašeho soukromí (lišta ve vývoji)"+
                        "</div>"+
                        "<div class=''>"+
                            "Používáme cookies, abychom Vám umožnili pohodlné prohlížení webu a díky analýze provozu webu neustále zlepšovali jeho funkce, výkon a použitelnost."+
                            "<br><br>Více informací o registraci a sběru dat <a class='a-link ws-href t-basic' href='/auth/rules' target='_blank'>zde</a>."+
                        "</div>"+
                    "</div>"+
                    "<div class='column-5'>"+
                        "<div class='header-6 pdy-1 t-bolder'>"+
                            "Jaká data tento web sbírá?"+
                        "</div>"+
                        "<div class=''>"+
                            "Webová stránka sbírá data v podobě přihlašovacích údajů (přihlašovací jméno, email, otisk hesla)"+
                        "</div>"+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<div class='column-1 column-10-xsm content-center mg-auto'>"+
                "<div class='pdy-1'><button id='cookies_accepted' class='button button-basic width-100'>Přijmout</button></div>"+
                "<div class='pdy-1'><button id='cookies_rejected' class='button button-basic width-100'>Zamítnout</button></div>"+
                "<div class='pdy-1'><button id='cookies_view_settings' class='button button-basic width-100'>Nastavení</button></div>"+
            "</div>"+
        "</div>";

        $("body").append(element);
        $("#cookie_bar").show(200);
    }
}

$(document).ready(function(){
        //cookieBar();
    
    $("#cookies_accepted").click(function()
    {
        $("#cookie_bar").fadeOut(300);
        setCookie("cookies_accepted", true, 30);
    });
    
    $("#cookies_rejected").click(function()
    {
        $("#cookie_bar").fadeOut(300);
        setCookie("cookies_accepted", false, 30);
    });
});

