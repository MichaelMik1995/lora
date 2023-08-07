/**
 * Get ONE image from folder by name
 * @param {String} folder 
 * @param {String} image_name 
 * @param {Array} allowed_extensions
 * @returns 
 */
function getImageByName(folder, image_name, allowed_extensions = ["png", "jpg", "jpeg"]) {
    var imageExtensions = allowed_extensions; // Přípustné přípony obrázků
    var imagePath = ''; // Sem uložíme cestu k obrázku
    
    // Projdi všechny přípustné přípony
    for (var i = 0; i < imageExtensions.length; i++) 
    {
      
      var currentExtension = imageExtensions[i];
      var possibleImagePath = folder + '/' + image_name + '.' + currentExtension;
      
      
      // Pokud existuje, nastav cestu k obrázku a přeruš smyčku
      if (imageExists(possibleImagePath)) {
        console.log("Image exists: " + currentExtension);
        imagePath = possibleImagePath;
        break;
      }
    }
    console.log(imagePath);
    return imagePath;
}

function imageExists(imagePath) 
{
  var http = new XMLHttpRequest();
  http.open('HEAD', imagePath, false); // Synchronní požadavek
  http.send();

  return http.status !== 404;

}