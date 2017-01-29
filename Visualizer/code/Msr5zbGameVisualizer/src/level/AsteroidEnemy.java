//Michael Rallo msr5zb 12358133
package level;

import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Platform;
import javafx.geometry.Bounds;
import javafx.scene.image.Image;
import javafx.scene.layout.AnchorPane;
import javafx.scene.paint.ImagePattern;
import javafx.scene.shape.Rectangle;

public class AsteroidEnemy extends Thread 
{
    public Boolean stop = false;
    
    private AnchorPane anchorPane;
    public Double xPosn = 0.0;
    public Double yPosn = 0.0;

    private Rectangle missle;
    private Long sleepTime = 400L;
    public Bounds bounds = null;
    public boolean paused = false;
    
    public AsteroidEnemy(AnchorPane anchorPane, Double xPosn) 
    {
        //Set Pane
        this.anchorPane = anchorPane;
        this.xPosn = xPosn;
        
        //Create Enemy
        Rectangle newMissle = new Rectangle(16, 25);
        missle = newMissle;
        missle.setTranslateX(xPosn);
        missle.setTranslateY(5);
        
        //Fill Enemy With Image
        String imageURL = Msr5zbGameVisualizer.class.getResource("images/asteroid.gif").toExternalForm();
        Image asteroid = new Image(imageURL);
        missle.setFill(new ImagePattern(asteroid, 0, 0, 1, 1, true));
        
        //Add it
        anchorPane.getChildren().add(missle);
    }
    
    @Override
    public void run() 
    {   
        while (stop != true) 
        {
            Platform.runLater(() -> 
            {
                if(paused == false)
                {  //Make Enemy "Fall" At Random Speed
                   Random rand = new Random();
                   int randomNum = rand.nextInt((5 - 0) + 1) + 0;    
                   missle.setTranslateY(missle.getTranslateY() + randomNum);
                   yPosn = missle.getTranslateY();
                   bounds = missle.getBoundsInParent();

                   //Make Enemy Rotate At Random Degree
                   Random rand2 = new Random();
                   int randomNum2 = rand2.nextInt((5 - 0) + 1) + 0; 
                   missle.setRotate(randomNum2*10); 
                }            
            });
                              
            try {
                Thread.sleep(sleepTime);
            } catch (InterruptedException ex) {
                Logger.getLogger(TechnoMissle.class.getName()).log(Level.SEVERE, null, ex);
            }
        }  
   
    }
    
    public void end() 
    {
        //Clean/Stop
        this.stop = true;
        anchorPane.getChildren().remove(missle);        
    }
}
