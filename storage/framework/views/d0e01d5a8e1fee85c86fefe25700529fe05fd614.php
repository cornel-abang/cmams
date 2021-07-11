<!doctype html>

<head>
    <title>Case Manager Attendance Tracker</title>
    <script src="<?php echo e(asset('assets/js/vendor-all.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/bootstrap.min.css')); ?>">
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
    <script type='text/javascript'>
        var page_data = <?php echo pageJsonData(); ?>;
    </script>
</head>

<body>
    <div class="jumbotron" style="margin-top:20px;padding:20px;">
    <div class="header">
      <img src="<?php echo e(asset('assets/images/logo-dark.png')); ?>" alt="" class="logo-thumb"> 
      <h3>FHI360 - Case Manager Analysis & Monitoring System</h3> 
      <h5>Attendance Tracker and Verifier</h5>
      <i class="badge badge-primary">Please make sure you're in the facility and the image is clear enough</i>
    </div>  
    <p><span id="errorMsg"></span></p>    
    <div class="row">    
        <div class="col-md-6"> 

            <!-- Here we streaming video from webcam -->       
            <video id="video" playsinline autoplay></video>
            <h4>    
                 <button class="btn btn-primary" id="btnCapture">Capture photo </button>    
            </h4>     
        </div>    
    
        <div class="col-md-6"> 
            <form id="att_frm" method="POST" action="<?php echo e(route('check_attendance')); ?>" enctype="multipart/formdata">
            <?php echo csrf_field(); ?>     
                <!-- Webcam video snapshot -->    
                <canvas style="border:solid 1px #ddd;background-color:white;" id="canvas" width="475" height="475"></canvas>
                <div class="form-group col-lg-6">
                    
                </div>
                <div class="form-group col-md-6">
                    <select name="facility" class="form-control" id="facility">
                      <option value="">--Select facility--</option>
                      <?php $__currentLoopData = __facilities(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($facility->name); ?>" class="fac-option"><?php echo e($facility->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <select name="case_manager" class="form-control" id="mg_name">
                      <option value="">--Case Manager--</option>
                      
                    </select>
                </div>
                <input type="hidden" name="cm_img" value="" id="img_area">
                <input type="hidden" name="location" id="location_area">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="latitude" id="latitude">
                <h4>    
                    <input type="button" class="btn btn-primary" id="btnSave" name="btnSave" value="Sign" />    
                </h4>
            </form>  
        </div>    
    </div>    
</div>
<style type="text/css">
  .header{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
  }
    h3, h5{
      text-align: center;
      margin-bottom: 30px;
      width: 40%;
    } 
    /* Flipping the video as it was not mirror view */  
    video {  
        -webkit-transform: scaleX(-1);  
        transform: scaleX(-1);  
        margin-top: 5px;  
    }  
  
    /* Flipping the canvas image as it was not mirror view */  
    #canvas {  
        -moz-transform: scaleX(-1);  
        -o-transform: scaleX(-1);  
        -webkit-transform: scaleX(-1);  
        transform: scaleX(-1);  
        filter: FlipH;  
        -ms-filter: "FlipH";  
    }

    .form-group{
      margin-left: -15px;
    }  
</style>  

<script type="text/javascript">  
    var video = document.querySelector("#video");  
  
    // Basic settings for the video to get from Webcam  
    const constraints = {  
        audio: false,  
        video: {  
            width: 475, height: 475  
        }  
    };  
  
    // This condition will ask permission to user for Webcam access  
    if (navigator.mediaDevices.getUserMedia) {  
        navigator.mediaDevices.getUserMedia(constraints)  
            .then(function (stream) {  
                video.srcObject = stream;  
            })  
            .catch(function (err0r) {  
                console.log("Something went wrong!");  
            });  
    }  
  
    function stop(e) {  
        var stream = video.srcObject;  
        var tracks = stream.getTracks();  
  
        for (var i = 0; i < tracks.length; i++) {  
            var track = tracks[i];  
            track.stop();  
        }  
        video.srcObject = null;  
    }  
</script>

<script type="text/javascript">
   //Facility Case manager select
    $(document).on('change','#facility',function(){
        let facility = $(this).val();
        $('#mg_name').empty();
        $.ajax({
          type: "GET",
          url: page_data.routes.get_managers,
          data: { facility, _token: page_data.csrf_token },
          success: function (data) {
            if (data.success) {
              $('#mg_name').append('<option>Select case manager</option>');
              for (let i = 0; i < data.managers.length; i++) {
                $('#mg_name').append('<option value="'+data.managers[i].names+'">'+data.managers[i].names+'</option>');
              }
            }else{
                $('#mg_name').append('<option>No case managers yet</option>');
            }
            // console.log(data);
          },
        });
    });  
    // Below code to capture image from Video tag (Webcam streaming)  
    $("#btnCapture").click(function () {  
        var canvas = document.getElementById('canvas');  
        var context = canvas.getContext('2d');  
  
        // Capture the image into canvas from Webcam streaming Video element  
        context.drawImage(video, 0, 0);  
    });  
  
    // Upload image to server - ajax call - with the help of base64 data as a parameter  
    $("#btnSave").click(function (e) {  
        e.preventDefault();
        // Below new canvas to generate flip/mirron image from existing canvas  
        var destinationCanvas = document.createElement("canvas");  
        var destCtx = destinationCanvas.getContext('2d');  
  
  
        destinationCanvas.height = 500;  
        destinationCanvas.width = 500;  
  
        destCtx.translate(video.videoWidth, 0);  
        destCtx.scale(-1, 1);  
        destCtx.drawImage(document.getElementById("canvas"), 0, 0);  
  
        // Get base64 data to send to server for upload  
        var imagebase64data = destinationCanvas.toDataURL("image/png");  
        imagebase64data = imagebase64data.replace('data:image/png;base64,', ''); 
        // var cm_name = $("#mg_name").val(); 
        $('#img_area').val(imagebase64data);
        console.log('NAME: '+$('#mg_name').val(), 
                'FACILITY: '+ $('#facility').val(), 
                'COORDS: Longitude - '+$('#longitude').val(), 'Latitude - '+$('#latitude').val(),
                'LOCATION: '+$('#location_area').val(),
                'TIMESTAMP: '+ new Date() 
                )
        $('#att_frm').submit();
        // $.ajax({  
        //     type: 'POST',  
        //     url: page_data.routes.check_attendance,  
        //     data: {imagebase64data, cm_name, _token: page_data.csrf_token },  
        //     contentType: 'application/json; charset=utf-8',  
        //     dataType: 'text',  
        //     success: function (out) {  
        //         alert('Image uploaded successfully..');  
        //     }  
        // });  
    });

    /*
    GEOLOCATION
     */  
function ipLookUp () {
  $.ajax('http://ip-api.com/json')
  .then(
      function success(response) {
          console.log('User\'s Location Data is ', response);
          console.log('User\'s Country', response.country);
          getAdress(response.lat, response.lon)
},

      function fail(data, status) {
          console.log('Request failed.  Returned status of',
                      status);
      }
  );
}
function getAddress (latitude, longitude) {
  $.ajax(`https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=a9a3cf10f9e04f07aeaedb032c2df537`)
  .then(
    function success (response) {
        $('#location_area').val(response.results[0].formatted);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
      console.log('User\'s Address Data is ', response.results[0].formatted)
    },
    function fail (status) {
      console.log('Request failed.  Returned status of',
                  status)
    }
   )
}
if ("geolocation" in navigator) {
  // ipLookUp()
  // check if geolocation is supported/enabled on current browser
  navigator.geolocation.getCurrentPosition(
   function success(position) {
     // for when getting location is a success
     console.log('latitude', position.coords.latitude, 
                 'longitude', position.coords.longitude);
     getAddress(position.coords.latitude, position.coords.longitude);
   },
  function error(error_message) {
    // for when getting location results in an error
    console.error(`An error has occured while retrieving
                  location`, error_message)
  });  
}
else {
  // geolocation is not supported
  // get your location some other way
  console.log('geolocation is not enabled on this browser')
  ipLookUp()
}
</script>
<script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>  
<script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>  
</body>

</html><?php /**PATH C:\laragon\www\qmams\resources\views/attendance/tracker.blade.php ENDPATH**/ ?>