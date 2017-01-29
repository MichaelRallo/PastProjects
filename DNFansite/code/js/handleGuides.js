$(function() {
    
	guideSelection = document.getElementsByClassName("dragon");
    for(var i=0; i<guideSelection.length; i++) { 
      guideSelection[i].addEventListener("click", updateGuide);
    }
    
    
function updateGuide($guide) {
        var guide = event.target.attributes.id.value;
        
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } 
        else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("content").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxRequests/" + guide + "Guide.php",true);
        xmlhttp.send();
        }

});