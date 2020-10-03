<!DOCTYPE html>
<html>

<head>
    <title>Capture webcam image with php and jquery</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

</head>

<body>
    <div class="container">
        <form method="POST" action="storeImage.php">
            <div class="row">
                <div class="col-md-6">
                    <div id="my_camera"></div>
                    <br />
                    <input type="hidden" name="image" class="image-tag">
                </div>
                <div class="col-md-6">
                    <div id="" class="card card-body bg-light">Your captured image will appear here...</div>
                </div>
                <div class="col-md-12 text-center">
                    <div class="card card-body bg-light">
                        <div class="" >
                            <div class="float-left">
                                <input type=button class="btn btn-info btn-sm" value="Take Snapshot" onClick="take_snapshot()">
                            </div>
                            <div class="float-right">
                                <button class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <?php

            $files = scandir('./upload/');
            sort($files); // this does the sorting
            foreach ($files as $file) {
                if ($file != "." && $file != "..") {
                    //var_dump($file);
                    echo '<div class="col-md-3">';
                    echo '<img class="img-fluid" src="/webcam/upload/' . $file . '" alt="">';
                    echo '</div>';
                }
            }
            ?>
        </div>

    </div>

    <!-- Configure a few settings and attach camera -->
    <script language="JavaScript">
        Webcam.set({
            width: 490,
            height: 390,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $(".image-tag").val(data_uri);
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            });
        }
    </script>

</body>

</html>