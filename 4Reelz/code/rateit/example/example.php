<!-- http://antenna.io/demo/jquery-bar-rating/examples/ -->
<!-- http://www.jqueryrain.com/demo/jquery-rating-plugin/ -->
<!--http://plugins.krajee.com/star-rating#installation-->
<!DOCTYPE html>
<html>
<head>



<link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
<link href="path/to/css/star-rating.min.css" media="all" rel="stylesheet" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="path/to/js/star-rating.min.js" type="text/javascript"></script>


</head>
<body>


<script>
starCaptions: function(val) {
    if (val < 3) {
        return 'Low: ' + val + ' stars';
    } else {
        return 'High: ' + val + ' stars';
    }

}


</script>

<input id="input-id" type="number" class="rating" min=1 max=10 step=2 data-size="lg" data-rtl="false">
<?php



echo" Start";

echo" End ";


?>






</body>

</html>