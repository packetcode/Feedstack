$(function(){


	var obj = $(".drop");
	
    obj.on('dragenter', function (e) 
	{
	    e.stopPropagation();
	    e.preventDefault();
	    $(this).css('border', '2px solid #16a085');
	});
	
    obj.on('dragover', function (e) 
    {
         e.stopPropagation();
         e.preventDefault();
    });
    
    obj.on('drop', function (e){
 
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        var file = files[0];
      
        xhr = new XMLHttpRequest();
        if (xhr.upload && check(file.type)) {
        var exte = ext(file.type);
        var url = $('.url').attr('u');
        xhr.open("post", url+"&ext="+exte, true);

        xhr.upload.addEventListener("progress", function (event) {
            if (event.lengthComputable) {
                $(".progress").show();
               // $(".progress-bar").css("width",(event.loaded / event.total) * 98 + "%");
                //$(".sr-only").html((event.loaded / event.total) * 98+'%');
            }
            else {  
                alert("Failed to compute file upload length");
            }
        }, false);

        xhr.onreadystatechange = function (oEvent) {
          if (xhr.readyState === 4) {  
            if (xhr.status === 200) {  
              //$(".progress-bar").css("width","100%");
              $(".progress").slideUp();
              //$(".sr-only").html( '100%');
              //$(".image").html("<img src='"+xhr.responseText+"' width='100%'/>");
              var u = $('.url').attr('r');
                window.location.assign(u);
              } else {  
              alert("Error"+ xhr.statusText);  
            }  
          }  
        };  
    
        // Set headers
        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.setRequestHeader("X-File-Name", file.fileName);
        xhr.setRequestHeader("X-File-Size", file.fileSize);
        xhr.setRequestHeader("X-File-Type", file.type);

        // Send the file (doh)
        xhr.send(file);
        }else
        alert('Please upload image file')
    });

  


    function check(file){
        switch(file)
        {
            case "image/jpeg":
                return 1;
            case "image/png":
                return 1;
             case "image/gif":
                return 1;
             default:
                return 0;      
        }
    }

    function ext(file){
        switch(file)
        {
            case "image/jpeg":
                return 'jpg';
            case "image/png":
                return 'png';
             case "image/gif":
                return 'gif';
             default:
                return 0;      
        }
    }
});