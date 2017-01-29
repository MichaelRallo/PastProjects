//Michael Rallo msr5zb 12358133 
package level;

import java.io.File;
import static java.lang.Integer.min;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.EventHandler;
import javafx.scene.Node;
import javafx.scene.input.KeyCode;
import javafx.scene.layout.AnchorPane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Ellipse;
import javafx.scene.shape.Rectangle;
import javafx.scene.text.Text;
import javafx.stage.Stage;
import javafx.stage.WindowEvent;

public class BonesLevel implements LevelStandards {
   
    //Tell Which Key Is Currently Pressed
    private HashMap<KeyCode, Boolean> keys = new HashMap<KeyCode, Boolean>();
    
    private String name = "Bones";
    private double phaser = 0;
    private int sec = 0;
    private AnchorPane vizPane;
    private Integer numBands;
    private Double bandHeightPercentage = 1.3;
    private Double minEllipseRadius = 10.0;  // 10.0
    
    private Double width = 0.0;
    private Double height = 0.0;
    
    private Double bandWidth = 0.0;
    private Double bandHeight = 0.0;
    private Double halfBandHeight = 0.0;
    
    private Double startHue = 400.0;
    
    private Rectangle[] rectangles;
    private Node playerRectangle;
    private Ellipse[] phaseEllipses;
    
    private Text scoreOutput;
    private Text highScoreOutput;
    private int highScore = 0;

    private int missleCount = 0;   
    private ArrayList<BonesMissle> missles;
    
    private int enemyCounter= 0;
    private ArrayList<BonesEnemy> enemies;

    private boolean startEnemies = true;

    private int score = 0;
    public boolean paused = false;

    ProcessFile processor;
    File file;
    
    public BonesLevel() {
    }
    
    @Override
    public String getName() {
        return name;
    }
    
    
    public void pause()
    {
           for (BonesEnemy enemy : enemies) 
           {                  
               enemy.paused = true;
           }
           for (BonesMissle missle : missles) 
           {                  
               missle.paused = true;
           } 
    }
 
    public void resume()
    {
           for (BonesEnemy enemy : enemies) 
           {                  
               enemy.paused = false;
           }
           for (BonesMissle missle : missles) 
           {                  
               missle.paused = false;
           } 
    }   
    
    @Override
    public void start(Integer numBands, AnchorPane vizPane) 
    {
        end(); //To Prevent Dups/Resets
        Stage primaryStage = (Stage)vizPane.getScene().getWindow();
        
        //Be Sure To End All Threads On Sudden Close
        primaryStage.setOnCloseRequest(new EventHandler<WindowEvent>() 
        {
            public void handle(WindowEvent we) 
            {
                System.out.println("Stage is closing");
                for (BonesEnemy enemy : enemies) {
                    enemy.end();
                }
                for (BonesMissle missle : missles) {
                    missle.end();
                }
            }
        });       
         
               
        //Background Image
        String image = Msr5zbGameVisualizer.class.getResource("images/bones.gif").toExternalForm();
        try
        {
              vizPane.setStyle("-fx-background-image: url(" + image + ")"); 
        }
        catch (Exception ex) {
          Logger.getLogger(TechnoLevel.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        this.numBands = numBands;
        //Set Pane
        this.vizPane = vizPane;
        
        height = vizPane.getHeight();
        width = vizPane.getWidth();
        
        //Prevent Pane Clipping
        Rectangle clip = new Rectangle(width, height);
        clip.setLayoutX(0);
        clip.setLayoutY(0);
        vizPane.setClip(clip);
        
        bandWidth = width / numBands;
        bandHeight = height * bandHeightPercentage;
        halfBandHeight = bandHeight / 2;
        
        //Create Shape Arrays (Rectangle Bands & Ellipse Radi Count)
        rectangles = new Rectangle[numBands];
        phaseEllipses = new Ellipse[numBands];
        
        //Create Text 
        this.scoreOutput = new Text();
        scoreOutput.setText("");
        
        //Create HighScore
        this.highScoreOutput = new Text();
        highScoreOutput.setText("");     
        
        //Add Score Counter
        scoreOutput.setId("fancytextBones");
        scoreOutput.setLayoutX(380);
        scoreOutput.setLayoutY(390);
        vizPane.getChildren().add(scoreOutput);
  
        //Add HighScore Counter
        highScoreOutput.setId("fancytextBones");
        highScoreOutput.setLayoutX(10);
        highScoreOutput.setLayoutY(390);
        vizPane.getChildren().add(highScoreOutput);
        
        //Lists To Hold Enemies/Missles 
        missles = new ArrayList<>();
        enemies = new ArrayList<>();
        
        //File I/O To Update/Read-In/Save Scores
        this.processor = new ProcessFile();
        String fileName = name +".txt";
        this.file = new File(fileName);
        highScore = processor.processFile(file);
        
        
        //For Rectangles
        for (int i = 0; i < numBands; i++) 
        {
            Rectangle rectangle = new Rectangle();
    
            rectangle.setX(bandWidth/4+ bandWidth * i );
            rectangle.setY(height / 2);
            rectangle.setHeight(minEllipseRadius);
            rectangle.setWidth(bandWidth / 2);

            //Starting Color
            rectangle.setFill(Color.WHITE);
            vizPane.getChildren().add(rectangle);
            rectangles[i] = rectangle;    
            
        }
        

        //For Phase Circles
        for (int i = 0; i < numBands; i++) {
            Ellipse Ellipse = new Ellipse();
            Ellipse.setCenterX(width/2);
            Ellipse.setCenterY(height/4);
            Ellipse.setRadiusX(0);
            Ellipse.setRadiusY(0);
            Ellipse.setFill(Color.TRANSPARENT);
            Ellipse.setStroke(Color.WHITE);
            Ellipse.setStrokeWidth(.8);
            vizPane.getChildren().add(Ellipse);
            phaseEllipses[i] = Ellipse;
        }      
        
        
        //Create Player Rectangle
        playerRectangle = createEntity(265, 185, 20, 10, Color.WHITE);

        //Start All Amounts Fresh 
        missleCount = 0;
        startEnemies = true;
        enemyCounter = 0;

        //Tell What Key Is Pressed
        vizPane.getScene().setOnKeyPressed(event -> keys.put(event.getCode(), true));
        //Say is unpressed
        vizPane.getScene().setOnKeyReleased(event -> keys.put(event.getCode(), false));

    }
  
    @Override
    public void end() 
    {
        //Remove All Children (Clears Pane)
         if (rectangles != null) 
         {
            for (int i = 0; i < rectangles.length; i++) 
            {
                vizPane.getChildren().remove(rectangles[i]);
                vizPane.getChildren().remove(phaseEllipses[i]);
            
            }   
   
            for (BonesEnemy enemy : enemies) 
           {                  
               enemy.end();
           }   
                        
            vizPane.getChildren().remove(scoreOutput);
            vizPane.getChildren().remove(highScoreOutput);
            vizPane.getChildren().remove(playerRectangle);
            
            for (BonesMissle missle : missles) 
            {                  
                missle.end();
            }     
            
            scoreOutput.setText("");
            rectangles = null;
            phaseEllipses = null;
            scoreOutput = null;
            vizPane.setStyle("");  
            
        } 
    }
    

     
    @Override
    public void update(double timestamp, double duration, float[] magnitudes, float[] phases) 
    {
        if ((rectangles == null)) {
            return;
        }
        
        //Display current Minute/Second of song
        sec = (int) (timestamp%60);
        
        //Update/Display Scores
        scoreOutput.setText("Score:" + Integer.toString(score));   
        highScoreOutput.setText("HighScore:" + Integer.toString(highScore));
        
        //If New HighScore, Display It
        if(score > highScore)
        {
            highScore = score;
            processor.setNewHighScore(highScore, file);
        }
        
        //Enemies
        if(startEnemies == true)
        {
          for (BonesEnemy enemy : enemies) 
          {  
              enemy.start();
          } 
          startEnemies = false;
        }
        
        //Enemy Spawner
        if(sec%5 == 0 && enemyCounter < 8)
        {
            Random rand = new Random();
            int randomNum = rand.nextInt((500 - 50) + 1) + 50;
            
            BonesEnemy enemy = new BonesEnemy(vizPane, (double)randomNum); 
            enemies.add(enemy);
            enemy.start();
            enemyCounter++;
        }
        

        //Move Right
        if(isPressed(KeyCode.A))
        {   System.out.println("A is being Pressed!");
            movePlayerX(-2);
          
        }
        
        //Move Left
        if(isPressed(KeyCode.D))
        {   System.out.println("D is being Pressed!");
            movePlayerX(2);
          
        }     

        //Shoot Missle
        if(isPressed(KeyCode.W) && missleCount < 1)
        {   System.out.println("W is being Pressed!");
            BonesMissle missle = new BonesMissle(vizPane, playerRectangle.getTranslateX(), playerRectangle.getTranslateY()); 
            missles.add(missle);
            missle.start();
            missleCount++;              
        }
        
        //If Player Outside Map For Some Reason...
        if(playerRectangle.getTranslateX() <= 0 || playerRectangle.getTranslateX() >= 530)
        {
            playerRectangle.setTranslateX(265);
        }
        
        //Check To See If Time To Clean Missle
        for(BonesMissle missle : missles) 
        {   
            if(missle != null && missle.stop ==false)
            {
                if(missle.yPosn <= 5 )
                {
                  missle.end();  
                  missleCount--;
                  System.out.println("Count is: " + missleCount);
                }
                
           
                //Check To See If Missles Hit A Bone Enemy!
                for(BonesEnemy enemy : enemies) 
                {  
                   if(enemy != null && enemy.stop == false && missle.bounds != null && enemy.bounds != null)
                   {
                       if(missle.bounds.intersects(enemy.bounds))
                       {
                         System.out.println("Hit!");
                         enemy.end();
                         enemyCounter--;
                         score++;                            
                       }
                   }
                }      
            }            
        }
       
       //Check To See If Bones Made It Behind Line
       for(BonesEnemy enemy : enemies) 
       {  
             if(enemy != null && enemy.stop ==false && enemy.yPosn != null)
            {
                if(enemy.yPosn >= 178)
                {
                  enemy.end();  
                  score = score - 5;
                  enemyCounter--;
                }           
              }
       }  
   
        
        //Loop through number of desired bands
        Integer num = min(rectangles.length, magnitudes.length);
        for (int i = 0; i < num; i++) 
        {
            //Rectangle Bands
            double scaler = ((60.0 + magnitudes[i])/60.0) * halfBandHeight + minEllipseRadius;
            if (scaler >= height) scaler = height;
            rectangles[i].setHeight(scaler);
            rectangles[i].setFill(Color.hsb(startHue - (magnitudes[i] * -6.0), 1.0, 1.0, 1.0));
            
            //
            phaser = 5 + phases[i]*5;
            phaseEllipses[i].setRadiusY(phaser*5);
            phaseEllipses[i].setRadiusX(phaser*5);
            phaseEllipses[i].setStroke(Color.hsb(startHue - (magnitudes[i] * -6.0), 1.0, 1.0, 1.0));
        } 
    }
    
    //Creates Player Rectangle
    private Node createEntity(int x, int y, int w, int h, Color color)
    {
        Rectangle entity = new Rectangle(w, h);
        entity.setTranslateX(x);
        entity.setTranslateY(y);
        entity.setFill(color);
        vizPane.getChildren().add(entity);
        
        return entity;
    }
    

    
    //Move Player Rectangle Left/Right
    private void movePlayerX(int value)
    {
        boolean movingRight = value > 0;
        
        for(int i = 0; i < Math.abs(value); i++)
        {
            if(playerRectangle.getTranslateX() > 520 || playerRectangle.getTranslateX() < 10)
            {
                 playerRectangle.setTranslateX(playerRectangle.getTranslateX() + (movingRight ? -6.5: 6.5));
            }
            
            else
            {
                playerRectangle.setTranslateX(playerRectangle.getTranslateX() + (movingRight ? 1.5: -1.5));
            }            
        }            
    }
    
    //See Which Button is Being Pressed
    private boolean isPressed(KeyCode key)
    {
        return keys.getOrDefault(key, false);
    }  
    
  
}