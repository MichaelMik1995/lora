/**
 * Description of Web stylize javascript class module
 *
 * @author MiroJi
 * @copyright (c) 2022, Miroslav Jirgl
 */
class WPAGE
{
    constructor()
    {
        Application.writeLog("Web module loaded");
    }
    
    /**
     * 
     * @param {String} element
     * @param {Integer} interval (in /ms)
     * @param {String} page_to_load
     * @returns {undefined}
     */
    reloadDiv(element, interval)
    {
        // 60000 = 1 minute
        setInterval(function() { $(element).load(location.href + ' '+element); }, interval); 
        console.log("test");
    }
}


