jQuery( document ).ready(function( $ ) {

// On file select validation
$(document).on("change","#pk_fav_url1,#pk_fav_url2",function(){
// allowed file type
var allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/x-icon'];
  var fileType = this.files[0].type;
  // Check if valid file type uploaded
  if(!allowedTypes.includes(fileType)){
	alert('Please select a valid file type.\n Supported formats: .jpeg .png .gif .ico');
	$(this).val(''); return false;
  }
  var fileSize = this.files[0].size;
  // 10,48,576 (1mb) * 3 (Limit max 3 mb file)
  if(fileSize > 3145728){
	alert('Please upload image file less than 3mb.');
	$(this).val(''); return false;
  }
  // Show image file preview
  var imgFile = this.files[0];
  var tmpImgPath = URL.createObjectURL(imgFile);
  $(this).next("img").attr('src',tmpImgPath);
});

});