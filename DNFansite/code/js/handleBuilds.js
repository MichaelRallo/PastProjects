$(function() {

    
       function preloader() {
        if (document.images) {
            var img1 = new Image();
            var img2 = new Image();
            var img3 = new Image();
            var img4 = new Image();
            var img5 = new Image();
            var img6 = new Image();
            var img7 = new Image();
            var img8 = new Image();
            var img9 = new Image();
            var img10 = new Image();
            var img11 = new Image();
            var img12 = new Image();
            var img13 = new Image();
            var img14 = new Image();
            var img15 = new Image();
            var img16 = new Image();
            var img17 = new Image();
            var img18 = new Image();
            var img19 = new Image();
            var img20 = new Image();
            var img21 = new Image();
            var img22 = new Image();
            var img23 = new Image();
            var img24 = new Image();
            var img25 = new Image();
            var img26 = new Image();
            var img27 = new Image();
            var img28 = new Image();
            var img29 = new Image();
            var img30 = new Image();
            var img31 = new Image();
            var img32 = new Image();
            var img33 = new Image();
            var img34 = new Image();
            var img35 = new Image();
            var img36 = new Image();
            var img37 = new Image();
            var img38 = new Image();
            var img39 = new Image();
            var img40 = new Image();
            var img41 = new Image();
            var img42 = new Image();
            var img43 = new Image();
            var img44 = new Image();
            var img45 = new Image();
            var img46 = new Image();
            var img47 = new Image();
            var img48 = new Image();

            
            

            img1.src = "images/builds/cleric/saint1.jpg";
            img2.src = "images/builds/cleric/saint2.jpg";
            img3.src = "images/builds/cleric/saint3.jpg";
            img4.src = "images/builds/cleric/inq1.jpg";
            img5.src = "images/builds/cleric/inq2.jpg";
            img6.src = "images/builds/cleric/inq3.jpg";
            img7.src = "images/builds/cleric/guard1.jpg";
            img8.src = "images/builds/cleric/guard2.jpg";
            img9.src = "images/builds/cleric/guard3.jpg";
            img10.src = "images/builds/cleric/crus1.jpg";
            img11.src = "images/builds/cleric/crus2.jpg";
            img12.src = "images/builds/cleric/crus3.jpg";
            
            img13.src = "images/builds/warrior/barb1.jpg";
            img14.src = "images/builds/warrior/barb2.jpg";
            img15.src = "images/builds/warrior/barb3.jpg";
            img16.src = "images/builds/warrior/dest1.jpg";
            img17.src = "images/builds/warrior/dest2.jpg";
            img18.src = "images/builds/warrior/dest3.jpg";
            img19.src = "images/builds/warrior/glad1.jpg";
            img20.src = "images/builds/warrior/glad2.jpg";
            img21.src = "images/builds/warrior/glad3.jpg";
            img22.src = "images/builds/warrior/lunarknight1.jpg";
            img23.src = "images/builds/warrior/lunarknight2.jpg";
            img24.src = "images/builds/warrior/lunarknight3.jpg";
            
            img25.src = "images/builds/archer/sniper1.jpg";
            img26.src = "images/builds/archer/sniper2.jpg";
            img27.src = "images/builds/archer/sniper3.jpg";
            img28.src = "images/builds/archer/tempest1.jpg";
            img29.src = "images/builds/archer/tempest2.jpg";
            img30.src = "images/builds/archer/tempest3.jpg";
            img31.src = "images/builds/archer/warden1.jpg";
            img32.src = "images/builds/archer/warden2.jpg";
            img33.src = "images/builds/archer/warden3.jpg";
            img34.src = "images/builds/archer/windwalker1.jpg";
            img35.src = "images/builds/archer/windwalker2.jpg";
            img36.src = "images/builds/archer/windwalker3.jpg";
            
            img37.src = "images/builds/sorceress/chaos1.jpg";
            img38.src = "images/builds/sorceress/chaos2.jpg";
            img39.src = "images/builds/sorceress/chaos3.jpg";
            img40.src = "images/builds/sorceress/ice1.jpg";
            img41.src = "images/builds/sorceress/ice2.jpg";
            img42.src = "images/builds/sorceress/ice3.jpg";
            img43.src = "images/builds/sorceress/pyro1.jpg";
            img44.src = "images/builds/sorceress/pyro2.jpg";
            img45.src = "images/builds/sorceress/pyro3.jpg";
            img46.src = "images/builds/sorceress/war1.jpg";
            img47.src = "images/builds/sorceress/war2.jpg";
            img48.src = "images/builds/sorceress/war3.jpg";
            
            
            
            
            
        }
    }
    function addLoadEvent(func) {
        var oldonload = window.onload;
        if (typeof window.onload != 'function') {
            window.onload = func;
        } else {
            window.onload = function() {
                if (oldonload) {
                    oldonload();
                }
                func();
            }
        }
    }
    addLoadEvent(preloader); 
    
    

       classSelection = document.getElementsByClassName("classBuild")
        for(var i=0; i<classSelection.length; i++) { 
            classSelection[i].addEventListener("click", changeBuild);
        }
    
	//***********************Functions***********************//
    function changeBuild() {
        
        document.getElementById('threeBuilds').style.visibility = "visible";
        classBuild = event.target.text;
        switch(classBuild){
            case'Gladiator':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Warrior';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/warrior/glad1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Sword Master';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/warrior/glad2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Gladiator';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/warrior/glad3.jpg')";
                break;    
            case'Lunar Knight':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Warrior';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/warrior/lunarknight1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Sword Master';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/warrior/lunarknight2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Lunar Knight';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/warrior/lunarknight3.jpg')";
                break;     
            case'Barbarian':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Warrior';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/warrior/barb1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Mercenary';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/warrior/barb2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Barbarian';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/warrior/barb3.jpg')";
                break;    
            case'Destroyer':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Warrior';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/warrior/dest1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Mercenary';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/warrior/dest2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Destroyer';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/warrior/dest3.jpg')";
                break;    
                
            case'Sniper':  
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Archer';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/archer/sniper1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Sharpshooter';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/archer/sniper2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Sniper';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/archer/sniper3.jpg')";
                break;              
            case'Warden':  
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Archer';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/archer/warden1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Sharpshooter';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/archer/warden2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Warden';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/archer/warden3.jpg')";
                break;            
                
            case'Tempest':    
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Archer';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/archer/tempest1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Acrobat';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/archer/tempest2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Tempest';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/archer/tempest3.jpg')";
                break; 
            case'Windwalker': 
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Archer';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/archer/windwalker1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Acrobat';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/archer/windwalker1.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Tempest';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/archer/windwalker3.jpg')";
                break; 
            
            case'Pyromancer':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Sorceress';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/sorceress/pyro1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Elementalist';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/sorceress/pyro2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Pyromancer';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/sorceress/pyro3.jpg')";
                break; 
            case'Ice Witch':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Sorceress';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/sorceress/ice1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Elementalist';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/sorceress/ice2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Ice Witch';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/sorceress/ice3.jpg')";
                break;                             
             case'War Mage':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Sorceress';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/sorceress/war1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Mystic';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/sorceress/war2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'War Mage';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/sorceress/war3.jpg')";
                break; 
             case'Chaos Mage':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Sorceress';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/sorceress/chaos1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Mystic';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/sorceress/chaos2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Chaos Mage';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/sorceress/chaos3.jpg')";
                break;   
                
             case'Guardian':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Cleric';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/cleric/guard1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Paladin';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/cleric/guard2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Guardian';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/cleric/guard3.jpg')";
                break;   
              case'Crusader':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Cleric';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/cleric/crus1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Paladin';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/cleric/crus2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Crusader';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/cleric/crus3.jpg')";
                break;  
              case'Saint':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Cleric';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/cleric/saint1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Preist';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/cleric/saint2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Saint';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/cleric/saint3.jpg')";
                break; 
              case'Inquisitor':
                document.getElementById('firstSkillBuildColumnBanner').innerHTML = 'Cleric';
                document.getElementById('firstBuild').style.backgroundImage = "url('images/builds/cleric/inq1.jpg')";
                document.getElementById('secondSkillBuildColumnBanner').innerHTML = 'Preist';
                document.getElementById('secondBuild').style.backgroundImage = "url('images/builds/cleric/inq2.jpg')";
                document.getElementById('thirdSkillBuildColumnBanner').innerHTML = 'Inquisitor';
                document.getElementById('thirdBuild').style.backgroundImage = "url('images/builds/cleric/inq3.jpg')";
                break; 
        }
        
        

    }
  	
    
});