$(document).ready(function() {
    let easytext_area = $(".easyText_textarea");
    //Live

    //Words counter
    easytext_area.keyup(function() {
        let text = easytext_area.val(); //Textarea
        let words = text.split(/\s+/);
        let words_length = words.length;
        let words_count = 0;

        for (let i = 0; i < words_length; i++) {
            if (words[i].length > 0) {
                words_count++;
            }
        }

        $("#es_words_counter").text(words_count);

        //Changes colors
        
    });

});