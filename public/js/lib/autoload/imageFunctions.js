function imageRemove(image_path)
{
    var request; 
    
    /*$.post("./App/Core/Lib/Ajax/removeImage.php", {
       image_source: image_path
    }, (data) => {
        console.log(data);
    });*/
    
    $.ajax({
		url: "./App/Core/Lib/Ajax/removeImage.php",
		type: "POST",
		data:  {'image_source':image_path},
		success: function(data){	
			console.log(data);
		},
		error: function(){} 	        
	});
}