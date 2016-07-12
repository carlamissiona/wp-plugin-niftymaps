jQuery(document).ready(function($){
    var tgm_media_frame;
    window.img =""; window.alt="";
    $('#upload_image_button').click(function() {

      if ( tgm_media_frame ) {
        tgm_media_frame.open();
        return;
      }

      tgm_media_frame = wp.media.frames.tgm_media_frame = wp.media({
        multiple: true,
        library: {
          type: 'image'
        },   
      });

      tgm_media_frame.on('select', function(){
        var selection = tgm_media_frame.state().get('selection');
        selection.map( function( attachment ) {
              attachment = attachment.toJSON();
              console.log(attachment);
             // $("#banner-desc").val( JSON.stringify(attachment) );
              $(".preview, .publish").attr("style","float:left; display:block;");
              $(".shortcode").attr("style","display:block;");
              var imgbx = '<img src='+ attachment.url +' alt='+ attachment.alt +' class="img-thb" id="carla-wp-banner-img-'+attachment.title+'">';
              $(".banner-img-preview").append(imgbx);
              window.img += attachment.url +",";
              window.meta += attachment.alt +",";
              // Do something with attachment.id and/or attachment.url here
        });

           console.log( window.img + " End");
        
      });

      tgm_media_frame.open();
      
      

    }); // end click
    $(".button.publish").click(function(){
      console.log( "name " +$("#banner-name").val()  +  $("#banner-desc").val() +  window.img + window.alt + "before publish");
      var url = window.location.href.substring(0,  window.location.href.lastIndexOf("+") );
        $.post(
          url+"+new",
          { action_new_banner : "token" ,
            name : $("#banner-name").val()  ,  
            desc :  $("#banner-desc").val() ,
            img : window.img ,
            meta : window.alt  
            
          },
          function(data){
            
            var uc =data.substring( data.lastIndexOf("<use-code>")+10 , data.lastIndexOf("</use-code>"));
            $(".use-code").text("[cwpb id='"+uc+"' ]");
            $(".code-container").show();
            setTimeout( function(){ window.location.reload(true) } , 4000);
         

          });
 
    });  
    $("#cb-select-all-1").on('change', 'input[type=checkbox]', function(e) {
          alert("Are you sure you want to delete all banners");
          var url = window.location.href.substring(0,  window.location.href.lastIndexOf("+") );
          $.post(
            url+"+delete+all",
            { 
              action_delete_all : "token" ,
            },
            function(data){
              
                setTimeout( function(){ window.location.reload(true) } , 4000);

          });  

    });
  
      $("#cb-select-all-1").live("click", function(){
          alert("Are you sure you want to delete all banners");
          var url = window.location.href.substring(0,  window.location.href.lastIndexOf("+") );
          $.post(
            url+"+delete+all",
            { 
              action_delete_all : "token" ,
            },
            function(data){
              
                setTimeout( function(){ window.location.reload(true) } , 4000);

          });
      });
        $(".accordion-section-title.hndle").live("click", function(){
            if( $(".control-section.accordion-section.open").is(":visible") == 0 ){
                $(".shortcode").hide();
                $(".banner-img-preview").empty();
                $(".preview, .publish").removeAttr("style");    
            }

        });

    
     
});
/*
jQuery(function($){

  // Set all variables to be used in scope
  var frame,
      metaBox = $('#meta-box-id.postbox'), // Your meta box id here
      addImgLink = metaBox.find('.upload-custom-img'),
      delImgLink = metaBox.find( '.delete-custom-img'),
      imgContainer = metaBox.find( '.custom-img-container'),
      imgIdInput = metaBox.find( '.custom-img-id' );
  
  // ADD IMAGE LINK
  addImgLink.on( 'click', function( event ){
    
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media Of Your Chosen Persuasion',
      button: {
        text: 'Use this media'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();

      // Send the attachment URL to our custom image input field.
      imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );

      // Send the attachment id to our hidden input
      imgIdInput.val( attachment.id );

      // Hide the add image link
      addImgLink.addClass( 'hidden' );

      // Unhide the remove image link
      delImgLink.removeClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });
  
  
  // DELETE IMAGE LINK
  delImgLink.on( 'click', function( event ){

    event.preventDefault();

    // Clear out the preview image
    imgContainer.html( '' );

    // Un-hide the add image link
    addImgLink.removeClass( 'hidden' );

    // Hide the delete image link
    delImgLink.addClass( 'hidden' );

    // Delete the image id from the hidden input
    imgIdInput.val( '' );

  });

});


/*jQuery(document).ready(function($){

  jQuery('#upload_image_button').click(function() {
      formfield = jQuery('#wpss_upload_image').attr('name');
      tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
      return false;
  });     

  window.send_to_editor = function(html) {
   imgurl = jQuery('img',html).attr('src');
   jQuery('#wpss_upload_image').val(imgurl);
   tb_remove();

   jQuery('#wpss_upload_image_thumb').html("<img height='65' src='"+imgurl+"'/>");
  }


});
  
*/