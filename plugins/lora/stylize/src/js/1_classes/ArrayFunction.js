class ArrayFunction
{
    constructor()
    {
        
    }
    
    /**
     * Find key in array
     * 
     * @param {string} needle     <p>What want you find</p>
     * @param {array} haystack    <p>In which array you finds</p>
     * @returns {Boolean}       <p>Returns true if needle is in array</p>
     */
    inArray(needle, haystack) 
    {
        var length = haystack.length;
        var result = false;
        
        for(var i = 0; i < length; i++) 
        {
            if(haystack[i] == needle)
            {
                result = true;
            }
        }
        return result;
    }
}


