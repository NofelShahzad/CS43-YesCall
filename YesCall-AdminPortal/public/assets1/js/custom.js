$(document).ready(function(){
    //video link frame logic
    //Yq_fVXatChk
    var video_link = 'https://www.youtube.com/embed/vL7p-IsObj4';
    $('.video-link').click(function(){
       $('#youtube-video').attr('src',video_link);
    });
    $('#close_youtube_iframe').click(function(){
       $('#youtube-video').attr('src','');
    });
    
    // Photo Uploader bootstrap
    $(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}

		$("#imgInp").change(function(){
		    readURL(this);
		}); 
    //open new windows
    $('.call').click(function(e){
        e.preventDefault();
        var hre=$(this).attr('href');
        window.open(hre,"MsgWindow", "width=500px,height=600px");
    })
});