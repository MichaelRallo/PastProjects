$(document).ready(function (){
    getWords();

    //Used for The PopUp Styling/Initializing
    $('#addWordsEngine').popup({
        pagecontainer: '#addWordsContainer',
        opacity:0.8,
        transition: 'all 0.3s',
        vertical:'top'
    }); 

    $("#submitButton").click(function(){

        var isValid = true;
        $('.errorStatement').remove();

        $('.userInformationFormField').each(function() {
            //Ensure all fields are filled out!
            if ($(this).val() === ''){
                $('#errors-container').append($('<p class="errorStatement" style="color:red;padding:0px;margin:0px;">Please Enter Information for: '+$(this).attr('placeholder')+'!</p>'));
                console.log("FALSE");
                isValid = false; 
            }
        });
        if(isValid == true){
            //Make our Rest POST Call to our Service to store new word.
            $.ajax({
              type: "POST",
              url: "api.php/"+$('#user-id').html(),
              data: JSON.stringify ({username: $('#user-id').html(), wordType: "MyWords", category: "MyWords", koreanWord: $('#Korean').val(), englishTranslation: $('#English').val(), romanization: $('#Pronounciation').val()}),
              dataType: 'json',
              success: function(data, textStatus ){
                  $('#errors-container').html("<p style='color:green;'>Word Added Successfully!</p>");
                  getWords();
               },
               error: function(xhr, textStatus, errorThrown){
                  $('#errors-container').html("<p style='color:red;'>Word Already Added, Try a different word!</p>");
               }
            });
        }
        return isValid;
    }); 
    
    function getWords(){
        //Make our Rest GET Call to our Service, Get JSON back.
        $.get("api.php/"+$('#user-id').html(), function(data) {
            $('#words-container').html("");
            var words = jQuery.parseJSON(data);
            $.each(words, function(key,word) {
                
                //Each Word's Contents
                var category = word.category;
                var koreanWord = word.koreanWord;
                var englishWord = word.englishTranslation;
                var romanization = word.romanization;
                var wordID = word.id;

                //Look at Word's Type, if it doesn't exist, make a new one
                if($('#' + category + '-container').length < 1){
                    $('#words-container').append($('<div id="'+category+'-container"><div class="panel panel-default"><div class="panel-heading" data-toggle="collapse" href="#'+category+'-collapse"><h4 class="panel-title"><a class="type-header">'+category+'</a></h4></div><div id="'+category+'-collapse" class="panel-collapse collapse"><ul class="list-group words-group"><li class="add-all">(Add All)</li></ul></div></div></div>'));
                    
                }
                
                var workingContainer = $('#' + category + '-container');
                if(category == "MyWords"){
                    workingContainer.find('.words-group').append($('<li><div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><span class="koreanCol"><em style="color:red;" class="fa fa-times delete-word" value="'+wordID+'" aria-hidden="true"></em> '+koreanWord+' - '+romanization+'</span></div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><span class="englishCol">'+englishWord+'</span></div></div></li>'));   
                }
                else{
                    workingContainer.find('.words-group').append($('<li><div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><span class="koreanCol">'+koreanWord+' - '+romanization+'</span></div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><span class="englishCol">'+englishWord+'</span></div></div></li>'));   
                }
                                         
            }); 
            //Add the Event for each Word.
            $('.words-group>li').click(function(){
                if($(this).hasClass('add-all')){
                    if($(this).hasClass('selected')){
                        $(this).parent().children('li').removeClass('selected');
                    }
                    else{
                        $(this).parent().children('li').removeClass('selected');
                        $(this).parent().children('li').addClass('selected');
                    }
                    
                }
                else{
                    if($(this).hasClass('selected')){
                        $(this).removeClass('selected'); 
                    }
                    else{$(this).addClass('selected');}
                }
            });
            //Handle Delete Word Events
            $('.delete-word').click(function(){
                var id = $(this).attr('value');
                //Make our Rest DELETE Call to our Service to remove our word.
                $.ajax({
                  type: "DELETE",
                  url: "api.php/"+$('#user-id').html()+"/"+id,
                  data: JSON.stringify ({username: $('#user-id').html(), wordType: "MyWords", category: "MyWords", koreanWord: $('#Korean').val(), englishTranslation: $('#English').val(), romanization: $('#Pronounciation').val()}),
                  dataType: 'json',
                  success: function(data, textStatus ){
                      $('#start-errors-container').html("<p style='color:green;'>Word Deleted Successfully!</p>");
                      getWords();
                   },
                   error: function(xhr, textStatus, errorThrown){
                      $('#start-errors-container').html("<p style='color:red;'>Word could not be Deleted!</p>");
                   }
                });
            });
            
        });
    }

});