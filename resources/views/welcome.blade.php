<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Testing file uploads with Laravel</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <style>
        .bd-masthead{
            position: relative;
            padding: 3rem 15px;
            background: linear-gradient(to right bottom,#f7f5fb 50%,#fff 50%);
        }

        .progress{
            border-radius: 10px;
            align-items: center;
        }
        .progress-bar{
            transition: width .1s ease;

            /* pulse 3s cubic-bezier(0.4, 0.0, 0.2, 1) infinite */


        }
        /* .progress { position:relative; width:100%; }
        .bar { background-color: #00ff00; width:0%; height:20px; }
        .percent { position:absolute; display:inline-block; left:50%; color: #040608;} */
    </style>
</head>
<body>

    <div class="bd-masthead">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-9">

                    <h1 class="mb-5">Testing file uploads with Laravel</h1>

                    <form action="/upload" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group mb-3 @error('file1') is-invalid @enderror">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Upload</span>
                              </div>
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file1" name="file1" aria-describedby="file1" accept="video/mp4">
                                <label class="custom-file-label" for="file1">Choose file</label>
                              </div>
                        </div>
                        @error('file1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror


                        <div class="mb-1 d-flex justify-content-between">
                            <div>Upload speed: <span class="percent">0%</span></div>
                            <div class="timer">00:00:00.00</div>
                            {{-- <div class="timers">00:00:00.00</div> --}}
                        </div>

                        <div class="progress">
                            <div class="progress-bar bg-success h-100"></div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-primary d-flex align-items-center">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-upload" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                            </svg>
                            <span class="ml-2">Upload</span>
                        </button>


                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- jQuery and JS bundle w/ Popper.js -->
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>



    <script type="text/javascript">
        const base_url = "{{URL('/')}}";

        // console.log(base_url);

        const $input = document.querySelector('.custom-file-input');

        $input.addEventListener('change',function(e){

            var fileName = 'Choose file';
            var nextSibling = e.target.nextElementSibling
            const file = document.getElementById("file1").files[0];

            if( file ){
                fileName = file.name;
            }

            nextSibling.innerText = fileName
        })


        var startTime, endTime, timer, sec_num, ms_num;


        function start() {
            startTime = new Date();

            sec_num = 0
            ms_num = 0


            timer = setInterval(function () {

                var elapsedTime = Date.now() - startTime;

                var dift = (elapsedTime / 1000).toFixed(2)

                var ms = parseInt(dift.split('.')[1])

                sec_num = dift.split('.')[0]

                // // var sec_num = parseInt(this, 10); // don't forget the second param
                var hours   = Math.floor(sec_num / 3600);
                var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                var seconds = sec_num - (hours * 3600) - (minutes * 60);

                // var ms = ms_num;

                if (hours   < 10) {hours   = "0"+hours;}
                if (minutes < 10) {minutes = "0"+minutes;}
                if (seconds < 10) {seconds = "0"+seconds;}
                if (ms < 10) {ms = "0"+ms;}

                $('.timer').text( hours+':'+minutes+':'+seconds +'.'+ ms )
                // $('.timer').text( ms_num )
                // return hours+':'+minutes+':'+seconds;

            }, 100);

        };

        function end() {
            clearInterval(timer);
        }


        $(document).ready(function()
        {

            var bar = $('.progress-bar');
            var percent = $('.percent');

            // $('form').s


            $('form').ajaxForm({

                beforeSend: function() {

                    start();

                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {

                    // console.log('uploadProgress...');

                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);
                },
                complete: function(xhr) {

                    end();

                    $($input).val('');
                    $('[for=file1]').text('Choose file');
                    var percentVal = '0%';
                    bar.width(percentVal)
                    percent.html(percentVal);


                    xhr.done( function(){
                        console.log( 'done...' );
                    } )
                    .fail( function(){
                        console.log( 'fail...' );
                    } )

                    // console.log( xhr );
                    alert('File Has Been Uploaded Successfully');
                }

            });


        });
    </script>


    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pako/1.0.4/pako_deflate.min.js"></script>

    <script type="text/js-worker" id="worker">
        self.addEventListener('message', function(e) {

            importScripts('https://cdnjs.cloudflare.com/ajax/libs/pako/1.0.4/pako_deflate.min.js');

            file = e.data;
            var reader = new FileReader();
            reader.onload = function(e) {
              var file = this.result;
              // Compress the file
              var compressed_file = pako.deflate(file, {level: 1});
              var myBlob = new Blob([compressed_file]);
              // Pass it back to the main thread
              self.postMessage(myBlob);
            };
            reader.readAsArrayBuffer(file);

        }, false);

    </script> --}}
</body>
</html>
