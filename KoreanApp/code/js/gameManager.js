$(document).ready(function (){
        
        //Starts The Game Practice
        $('#start-practice').click(function(){
           var wordsToPractice = $('#words-container').find('.selected');
           if(wordsToPractice.length < 6){
               $('#start-errors-container').html('<p style="color:red;">Please Select more than 5 words!</p>');
               return;
           }
           else{
                $('#word-selection-container').fadeOut();
                $("#choice-1").css('background-color', '');
                $("#choice-2").css('background-color', '');
                $("#choice-3").css('background-color', '');
                $("#choice-4").css('background-color', '');
                $('#game-container').fadeIn();
                startGame(wordsToPractice);
           }
       }); 
        
        //Starts the Word Selection Screen
        $('#back-to-selection').click(function(){ 
            $('#game-container').fadeOut();
            $('#word-selection-container').fadeIn()
        });
        
        function startGame(words){
            var wordList = [];
            $.each(words, function(key,word) {
                if($(this).html == "(Add All)" || $(this).hasClass('add-all')){console.log("nice");}
                else{
                    wordList.push({"korean":$(word).find('.koreanCol').html(),"english":$(word).find('.englishCol').html()});
                }
            });
            var correctAnswer = updateWord(wordList);
            $('.choice').click(function(){
                console.log("Correct is: " + correctAnswer + " Choice is: " + $(this).html());
               if($(this).html() == correctAnswer){
                    console.log("Correct!");
                    $("#choice-1").css('background-color', '');
                    $("#choice-2").css('background-color', '');
                    $("#choice-3").css('background-color', '');
                    $("#choice-4").css('background-color', '');
                    correctAnswer = updateWord(wordList);
               } 
                else{
                    console.log("Incorrect!");
                    $(this).css('background-color', '#c60c30');
                }
            });
            
        }
        function updateWord(wordBag){
            
            $('#game-pane').fadeOut(100);
            //First, We need to Choose 1 Random Word from our bag to Guess
            var wordBagSize = wordBag.length;
            var wordToGuessIndex = randomIndex(wordBag.length);
            $('#question').html(wordBag[wordToGuessIndex]["korean"]);
            
            var fakeIndexArray = generateFakeIndexArray(wordToGuessIndex, 4, wordBag.length);
            
            //Now, We fill in The Blanks
            $('#choice-1').html(wordBag[fakeIndexArray[0]]["english"]);
            $('#choice-2').html(wordBag[fakeIndexArray[1]]["english"]);
            $('#choice-3').html(wordBag[fakeIndexArray[2]]["english"]);
            $('#choice-4').html(wordBag[fakeIndexArray[3]]["english"]);
            
            var realChoice = Math.floor(Math.random()*4);
            switch(realChoice){
                case 0: $("#choice-1").html(wordBag[wordToGuessIndex]["english"]); break; 
                case 1: $("#choice-2").html(wordBag[wordToGuessIndex]["english"]); break; 
                case 2: $("#choice-3").html(wordBag[wordToGuessIndex]["english"]); break; 
                case 3: $("#choice-4").html(wordBag[wordToGuessIndex]["english"]); break; 

            } 
            $('#game-pane').fadeIn(100);
            return wordBag[wordToGuessIndex]["english"];
            
            
        }
        function randomIndex(wordListSize){
            //Uses Length to Find random number between 0 and length-1.
            return Math.floor(Math.random()*wordListSize);
        }    
        //Creates an Array of Fake Indexes containing all but the Answer.
        function generateFakeIndexArray(anythingButMe, numberOfFakeIndexes, wordListSize){
            var fakeIndexArray = [];        

            while(fakeIndexArray.length != wordListSize-1){

                var newIndex = randomIndex(wordListSize);
                if(arrayContainsIndex(newIndex, fakeIndexArray) || newIndex == anythingButMe){
                    continue;
                }
                else{
                    fakeIndexArray.push(newIndex);
                }
            }
            return fakeIndexArray;
        }
        //Check Index, Makes sure it's unique
        function arrayContainsIndex(index, indexArray){
            for(var indexElement in indexArray){
                if(index == indexArray[indexElement]){
                    return true;
                }
            }
            return false;
        }
    });