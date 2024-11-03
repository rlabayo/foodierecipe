function attachment(id){
  var width = document.getElementById('width_preview').value
  var height = document.getElementById('height_preview').value
  const [file] = document.getElementById(id).files
  var filetypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'];

  // const MAX_FILE_SIZE = 2048
  const MAX_FILE_SIZE = 2097152 // bytes , 2mb
  
  document.getElementById('file_error_' + id).innerHTML = "";
  
  // Check if the given image file type is valid
  if(!filetypes.includes(file.type)){
      document.getElementById('file_error_' + id).innerHTML = "The attachment field must be a file of type: jpg, jpeg, png, webp.";
  }else{
      if(file.size <= MAX_FILE_SIZE){
          if (file) {
            document.getElementById('preview_container_' + id).style.display = '';
            document.getElementById('preview_container_' + id).innerHTML = "";

            createBlobImage(document.getElementById(id).files, id, display_image, width, height) 
          }
      }else{
        document.getElementById('file_error_' + id).innerHTML = "The attachment exceeded the maximum file size of 2MB. Your image file size is " + (file.size / 1048576).toFixed(2) + ' mb';
        document.getElementById('preview_container_' + id).innerHTML = "";
        document.getElementById('preview_container_' + id).innerHTML = '<img src="/storage/assets/images/icons/img_logo.svg" alt="Image logo" class="m-auto my-auto py-1" />'+
          '<span class="text-center text-[12px] py-1 px-2 leading-tight">File size maximum of 2mb</span>';
      }
  }
}

function createBlobImage(imageData, id, funct_display_image, custom_width, custom_height) {
  var filesSelected = imageData;

  if (filesSelected.length > 0) {
    var fileToLoad = filesSelected[0];

    var fileReader = new FileReader();

    fileReader.onload = function(fileLoadedEvent) {
      var img = document.createElement("img");

      img.onload = function (event) {

        function createBlob(canvasBlob, elem){
          // replace hidden attachment input file image with the canvas image
          canvasBlob.toBlob( (blob) => {
            // const mimeType = fileToLoad.type;
            var type = 'webp' 
            const file = new File( [ blob ], "image." + type, { type: "image/webp" });
            const dT = new DataTransfer();
            dT.items.add( file );
            // elem.files = dT.files;

            encodeBlobImageToBase64(dT.files, elem)
          });
        }

        /** banner image */
          var canvas = document.createElement("canvas");
          canvas.width = this.width;
          canvas.height = this.height;
          var ctx = canvas.getContext("2d");
          ctx.drawImage(img, 0, 0);

          // Show resized image in preview element
          var dataurl = canvas.toDataURL(fileToLoad.type);

          // call the function to display image
          funct_display_image(id, dataurl)
          
          // replace hidden attachment input file image with the canvas image
          createBlob(canvas, document.getElementById('attachment_banner_hidden_' + id))

        /** end for banner image */

        /** thumbnail image */
          var MAX_WIDTH = 500;
          var MAX_HEIGHT = 500;

          var canvas_thumbnail = document.createElement("canvas");
          canvas_thumbnail.width = MAX_WIDTH;
          canvas_thumbnail.height = MAX_HEIGHT;
          var ctx_thumbnail = canvas_thumbnail.getContext("2d");
          ctx_thumbnail.drawImage(img, 0, 0, MAX_WIDTH, MAX_HEIGHT);

          // replace hidden attachment input file image with the canvas image
          createBlob(canvas_thumbnail, document.getElementById('attachment_thumbnail_hidden_' + id))
          
        /** end for thumbnail image */
      }
      img.src = fileLoadedEvent.target.result;
      // var srcData = fileLoadedEvent.target.result; // <--- data: base64
    }
    fileReader.readAsDataURL(fileToLoad);
    /** end fo banner image */
  }
}


function display_image(id, base64){
  document.getElementById('preview_container_' + id).innerHTML = "";
  document.getElementById('preview_container_' + id).innerHTML = '<img src="'+ base64 +'" alt="Preview Image" class="my-auto w-full" id="attached_'+id+'" />';
}

function encodeBlobImageToBase64(imageData, elem){
  var filesSelected = imageData;

  if (filesSelected.length > 0) {
      var fileToLoad = filesSelected[0];

      var fileReader = new FileReader();

      fileReader.onload = function(fileLoadedEvent) {
          var img = document.createElement("img");
          img.onload = function (event) {
              var canvas = document.createElement("canvas");
              canvas.width = this.width;
              canvas.height = this.height;
              var ctx = canvas.getContext("2d");
              ctx.drawImage(img, 0, 0);

              // Show resized image in preview element
              var dataurl = canvas.toDataURL(fileToLoad.type);
              
              elem.value = dataurl

          }
          img.src = fileLoadedEvent.target.result;
          // var srcData = fileLoadedEvent.target.result; // <--- data: base64
      }
      fileReader.readAsDataURL(fileToLoad);
      /** end fo banner image */

  }
}
