$(function() {
    
    
 function preloader() {
        if (document.images) {
            var img1 = new Image();
            var img2 = new Image();
            var img3 = new Image();
            var img4 = new Image();

            img1.src = "images/musicPlayerWarrior.jpg";
            img2.src = "images/musicPlayerArcher.jpg";
            img3.src = "images/musicPlayerSorceress.jpg";
            img4.src = "images/musicPlayerCleric.jpg";
           
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
    
    //***********************Handle Song Selection/Audio***********************//
	var audio, dir, ext, mylist;
	dir = "audio/";
	ext = ".mp3";
	// Audio Object
	audio = new Audio();
    var ctx = new AudioContext();
    var audioSrc = ctx.createMediaElementSource(audio);
    var analyser = ctx.createAnalyser();
    // we have to connect the MediaElementSource with the analyser 
    audioSrc.connect(analyser);
    audioSrc.connect(ctx.destination);
	// Event Handling
	//classSelection = document.getElementById("classSelection");
	classSelection = document.getElementsByClassName("classSelection");
    for(var i=0; i<classSelection.length; i++) { 
      classSelection[i].addEventListener("click", changeTrack);
    }
	//classSelection.addEventListener("click", changeTrack);
    
	//***********************Functions***********************//
	//***********************Selecting Visualizer***********************//
	function changeTrack(event){
        audio.src = dir+event.target.attributes.value.value+ext;
        var musicContainer = document.getElementById('musicContainer');
        musicContainer.style.backgroundSize = '100%';
        while (musicContainer.firstChild) {
            musicContainer.removeChild(musicContainer.firstChild);
        }
        
        musicContainer.style.backgroundSize = '100%';
        
        var overlay = document.createElement('div');
        overlay.setAttribute("id", 'overlay');
        musicContainer.appendChild(overlay);

        switch(event.target.attributes.value.value){
            case 'warrior':
                musicContainer.style.backgroundImage = "url('images/musicPlayerWarrior.jpg')";
                warriorVisualizer(); 
                break;
            case 'archer': 
                musicContainer.style.backgroundImage = "url('images/musicPlayerArcher.jpg')";
                archerVisualizer(); 
                break;
            case 'cleric': 
                musicContainer.style.backgroundImage = "url('images/musicPlayerCleric.jpg')";
                clericVisualizer(); 
                break;
            case 'sorceress': 
                musicContainer.style.backgroundImage = "url('images/musicPlayerSorceress.jpg')";
                sorceressVisualizer(); 
                break;  
        }
        
        
        //***********************Warrior Visualizer***********************//
        function warriorVisualizer(){
                    
            var warriorBarsContainer = document.createElement('div');
            warriorBarsContainer.setAttribute("id", 'warriorBarsContainer');
            overlay.appendChild(warriorBarsContainer);

            
            // frequencyBinCount tells you how many values you'll receive from the analyser
            var frequencyData = new Uint8Array(300);

              var svgHeight = '500';
              var svgWidth = '1200';
              var barPadding = '1';

              function createSvg(parent, height, width) {
                return d3.select(parent).append('svg').attr('height', height).attr('width', width);
              }

              var svg = createSvg(warriorBarsContainer, svgHeight, svgWidth);
                
              // Create our initial D3 chart.
              svg.selectAll('rect')
                 .data(frequencyData)
                 .enter()
                 .append('rect')
                 .attr('x', function (d, i) {
                    return i * (svgWidth / frequencyData.length);
                 })
                 .attr('width', svgWidth / frequencyData.length - barPadding);
                
    
            var bgChange = 0;
            function renderFrame() {
                if(document.getElementById('warriorBarsContainer') == null) return;
                if(document.getElementById('warriorBarsContainer') != null){
                    requestAnimationFrame(renderFrame);
                    analyser.getByteFrequencyData(frequencyData);
     
                    bgChange++;
                    if(bgChange%200 == 0)
                    {
                        var a = Math.floor(Math.random() * 256);
                        var b = Math.floor(Math.random() * 256);
                        var c = Math.floor(Math.random() * 256);
                        overlay.style.backgroundColor = 'rgba(' + a + ',' + b + ',' + c + ',0.2)';
                    }
                    if(bgChange%380 == 0)
                    {
                        var sizeChange = Math.floor((Math.random() * 130) + 90);
                        musicContainer.style.backgroundSize = sizeChange + '%';
                    }

                   // Update d3 chart with new data.
                     svg.selectAll('rect')
                        .data(frequencyData)
                        .attr('y', function(d) {
                           return svgHeight - d*2;
                        })
                        .attr('height', function(d) {
                           return d*2;
                        })
                        .attr('fill', function(d) {
                           return 'rgb(232, 232, ' + d + ')';
                        });
                }   
            }
            audio.play();
            renderFrame();
        }       
        //****************************************************************//
        
        //***********************Cleric Visualizer***********************//
        function clericVisualizer(){
                    
            var clericCirclesContainer = document.createElement('div');
            clericCirclesContainer.setAttribute("id", 'clericCirclesContainer');
            overlay.appendChild(clericCirclesContainer);

            // frequencyBinCount tells you how many values you'll receive from the analyser
            var frequencyData = new Uint8Array(16);

            // a full circle
            var twoPi = 2*Math.PI;
            var objectsCount = 16;
            var circleCounter = 0;
            var radius = 100;

            var change = twoPi/objectsCount;
    
            for (var i=0; i < twoPi; i+=change) {
                var x = radius*Math.cos(i);
                var y = radius*Math.sin(i);
                var z = x*y/20;
                // rotation of object in radians
                var rotation = i;

                var clericCircle = document.createElement('div');
                clericCircle.className = 'clericCircle';
                clericCircle.setAttribute("id", 'clericCircle'  + circleCounter++);
                clericCircle.style.width = z + 'px';
                clericCircle.style.height = z + "px";        
                document.getElementById('clericCirclesContainer').appendChild(clericCircle);
            }
            
             // frequencyBinCount tells you how many values you'll receive from the analyser
            var clericCirclesContainer2 = document.createElement('div');
            clericCirclesContainer2.setAttribute("id", 'clericCirclesContainer2');
            overlay.appendChild(clericCirclesContainer2);
            
            // a full circle
            var twoPi = 2*Math.PI;
            var objectsCount = 8;
            var circleCounter = 0;
            var radius = 30;

            var change = twoPi/objectsCount;
    
            for (var i=0; i < twoPi; i+=change) {
                var x = radius*Math.cos(i);
                var y = radius*Math.sin(i);
                var z = x*y/20;
                // rotation of object in radians
                var rotation = i;

                var clericCircle2 = document.createElement('div');
                clericCircle2.className = 'clericCircle2';
                clericCircle2.setAttribute("id", 'clericCircle2'  + circleCounter++);
                clericCircle2.style.width = z + 'px';
                clericCircle2.style.height = z + "px";        
                document.getElementById('clericCirclesContainer2').appendChild(clericCircle2);
            }
            
            
    
            var bgChange = 0;
            function renderFrame() {
                if(document.getElementById('clericCirclesContainer') == null || document.getElementById('clericCirclesContainer2') == null) return;
                if(document.getElementById('clericCirclesContainer') != null || document.getElementById('clericCirclesContainer2') != null){
                    requestAnimationFrame(renderFrame);
                    analyser.getByteFrequencyData(frequencyData);
     
                    bgChange++;
                    if(bgChange%200 == 0)
                    {
                        var a = Math.floor(Math.random() * 256);
                        var b = Math.floor(Math.random() * 256);
                        var c = Math.floor(Math.random() * 256);
                        overlay.style.backgroundColor = 'rgba(' + a + ',' + b + ',' + c + ',0.2)';
                    }
                    if(bgChange%380 == 0)
                    {
                        var sizeChange = Math.floor((Math.random() * 130) + 90);
                        musicContainer.style.backgroundSize = sizeChange + '%';
                    }

                    for(var j = 0; j < frequencyData.length; j++){     
                        document.getElementById('clericCircle' + j)
                            .style.boxShadow='0px 0px 8px 8px rgba(' 
                            + frequencyData[j]*j + ',' + frequencyData[j]*j + ',' + frequencyData[j]/4*j + ',1.0)';

                        document.getElementById('clericCircle' + j).style.transform = 'scale(' + frequencyData[j]/300 + ')';  
                        
                        if(j < (frequencyData.length/2)){
                            document.getElementById('clericCircle2' + (j))
                                .style.boxShadow='0px 0px 8px 8px rgba(' 
                                + frequencyData[j]*j + ',' + frequencyData[j/2]*j + ',' + frequencyData[j]/4*j + ',1.0)';

                            document.getElementById('clericCircle2' + (j)).style.transform = 'scale(' + frequencyData[j]/300 + ')'; 
                        }
                    }
                }   
            }
            audio.play();
            renderFrame();
        }         
        //****************************************************************//
        
        
        
            
        //***********************Archer Visualizer***********************//
        function archerVisualizer(){
                    
          
            var archerBarsContainer = document.createElement('div');
            archerBarsContainer.setAttribute("id", 'archerBarsContainer');
            overlay.appendChild(archerBarsContainer);

            
            // frequencyBinCount tells you how many values you'll receive from the analyser
            var frequencyData = new Uint8Array(300);

              var svgHeight = '500';
              var svgWidth = '1200';
              var barPadding = '1';

              function createSvg(parent, height, width) {
                return d3.select(parent).append('svg').attr('height', height).attr('width', width);
              }

              var svg = createSvg(archerBarsContainer, svgHeight, svgWidth);
                
              // Create our initial D3 chart.
              svg.selectAll('rect')
                 .data(frequencyData)
                 .enter()
                 .append('rect')
                 .attr('x', function (d, i) {
                    return i * (svgWidth / frequencyData.length);
                 })
                 .attr('width', svgWidth / frequencyData.length - barPadding);
                
    
            var bgChange = 0;
            function renderFrame() {
                if(document.getElementById('archerBarsContainer') == null) return;
                if(document.getElementById('archerBarsContainer') != null){
                    requestAnimationFrame(renderFrame);
                    analyser.getByteFrequencyData(frequencyData);
     
                    bgChange++;
                    if(bgChange%200 == 0)
                    {
                        var a = Math.floor(Math.random() * 256);
                        var b = Math.floor(Math.random() * 256);
                        var c = Math.floor(Math.random() * 256);
                        overlay.style.backgroundColor = 'rgba(' + a + ',' + b + ',' + c + ',0.2)';
                    }
                    
                   // Update d3 chart with new data.
                     svg.selectAll('rect')
                        .data(frequencyData)
                        .attr('y', function(d) {
                           return svgHeight - d*2;
                        })
                        .attr('height', function(d) {
                           return d*2;
                        })
                        .attr('fill', function(d) {
                           return 'rgb(6, 232, ' + d + ')';
                        });
                }   
            }
            audio.play();
            renderFrame();
        }         
        //****************************************************************//
        
            
        
        //***********************Sorceress Visualizer***********************//
        function sorceressVisualizer(){
                    
            var sorceressCirclesContainer = document.createElement('div');
            sorceressCirclesContainer.setAttribute("id", 'sorceressCirclesContainer');
            overlay.appendChild(sorceressCirclesContainer);

            // frequencyBinCount tells you how many values you'll receive from the analyser
            var frequencyData = new Uint8Array(16);

            // a full circle
            var twoPi = 2*Math.PI;
            var objectsCount = 16;
            var circleCounter = 0;
            var radius = 100;

            var change = twoPi/objectsCount;
    
            for (var i=0; i < twoPi; i+=change) {
                var x = radius*Math.cos(i);
                var y = radius*Math.sin(i);
                var z = x*y/20;
                // rotation of object in radians
                var rotation = i;

                var sorceressCircle = document.createElement('div');
                sorceressCircle.className = 'sorceressCircle';
                sorceressCircle.setAttribute("id", 'sorceressCircle'  + circleCounter++);
                sorceressCircle.style.width = z + 'px';
                sorceressCircle.style.height = z + "px";        
                document.getElementById('sorceressCirclesContainer').appendChild(sorceressCircle);
            }
    
            var bgChange = 0;
            function renderFrame() {
                if(document.getElementById('sorceressCirclesContainer') == null) return;
                if(document.getElementById('sorceressCirclesContainer') != null){
                    requestAnimationFrame(renderFrame);
                    analyser.getByteFrequencyData(frequencyData);
     
                    bgChange++;
                    if(bgChange%200 == 0)
                    {
                        var a = Math.floor(Math.random() * 256);
                        var b = Math.floor(Math.random() * 256);
                        var c = Math.floor(Math.random() * 256);
                        overlay.style.backgroundColor = 'rgba(' + a + ',' + b + ',' + c + ',0.2)';
                    }
                    if(bgChange%380 == 0)
                    {
                        var sizeChange = Math.floor((Math.random() * 120) + 80);
                        musicContainer.style.backgroundSize = sizeChange + '%';
                    }
                    
                    
                    

                    for(var j = 0; j < frequencyData.length; j++){
                        document.getElementById('sorceressCircle' + j)
                            .style.boxShadow='0px 0px 8px 8px rgba(' 
                            + frequencyData[j]/3 + ',' + frequencyData[j]*j + ',' + frequencyData[j]*j + ',1.0)';

                        document.getElementById('sorceressCircle' + j).style.transform = 'scale(' + frequencyData[j]/300 + ')'; 
                    }
                }   
            }
            audio.play();
            renderFrame();
        }         
        //****************************************************************//
	}
    
});