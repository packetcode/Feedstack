/** APP: Ajax Image uploader with progress bar
    Website:packetcode.com
    Author: Krishna TEja G S
    Date: 29th April 2014
***/

$(function(){
	 

	 // function from the jquery form plugin
	 $('#myForm').ajaxForm({
	 	beforeSubmit:function(formData, jqForm, options){
	 		$(".progress").show()
	 		var n = formData[0].value.name;
	 		var ext = n.substr(n.lastIndexOf('.') + 1);
	 		var et = ext.toUpperCase();
	 		var array = ['PNG','JPG','JPEG','GIF'];
	 		var there = $.inArray(et, array);
	 		if(there == -1)
	 		{
	 			alert("Please enter a valid image file");
	 			return false;
	 		}	
	 		else{
	 			return true;
	 		}	
	 	},
	 	uploadProgress:function(event,position,total,percentComplete){

	 	},
	 	success:function(){
	 		$(".progress").hide(); //hide progress bar on success of upload
	 	},
	 	complete:function(response){
	 		if(response.responseText=='0'){
				$(".image").html("<b>Error: Please upload valid image file</b>"); //display error if response is 0
	 		}	
	 		else
	 		{
	 			var u = $('.url').attr('r');
	 			console.log(response.responseText);
             	window.location.assign(u);
	 		}
	 			//$(".image").html("<img src='"+response.responseText+"' width='100%'/>");
	 			// show the image after success
	 	}
	 });

	 //set the progress bar to be hidden on loading
	 $(".progress").hide();
});