String.prototype.replaceBetween = function(opentag, closetag, replacement) 
 {
      var read_index = 0;
      var open_index = 0;
      var close_index = 0;
      var output = '';

      while ((open_index = this.indexOf(opentag, read_index)) != -1) {
        output += this.slice(read_index, open_index) + opentag;
        read_index = open_index + opentag.length;

        if ((close_index = this.indexOf(closetag, read_index)) != -1) {
          if (typeof replacement === 'function') {
            output += replacement(this.substring(open_index + opentag.length, close_index - 1)) + closetag;
          } else {
            output += replacement + closetag;
          }
          read_index = close_index + closetag.length;
        }
      }

      output += this.slice(read_index);

      return output
};


/**
 * 
 * @param {String} find_substring   <p>Substring to find in</p>
 * @param {String} in_string        <p>String, where substring must be</p>
 * @returns {Boolean}
 */
function str_contains(find_substring, in_string)
{
    if(in_string.indexOf(find_substring) >= 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

