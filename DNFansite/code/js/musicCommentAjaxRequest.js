$(function() {
    

    loadComments();
    if(document.getElementById("commentSubmit") != null){
    commentSubmit = document.getElementById("commentSubmit");
    commentSubmit.addEventListener("click", postComment);
   }
    
    $("#limit").animate({
    height: $("#div").height('auto')
},600);
    
	//***********************Functions***********************//
function postComment() {
        var comment = document.getElementById('userCommentText').value;        
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
                document.getElementById("commentSection").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxRequests/generateMusicComment.php?q="+comment,true);
        xmlhttp.send();
        }
    
function loadComments()  {
        var comment = document.getElementById('userCommentText').value;
        console.log(comment);
        console.log(document.getElementById('userCommentText').value);
        
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
                document.getElementById("commentSection").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET","ajaxRequests/loadMusicComments.php",true);
        xmlhttp.send();
        }
  	
    
});