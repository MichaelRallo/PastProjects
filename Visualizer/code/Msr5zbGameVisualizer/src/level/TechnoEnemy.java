//Michael Rallo msr5zb 12358133

package level;

import java.util.Random;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Platform;
import javafx.geometry.Bounds;
import javafx.scene.layout.AnchorPane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Ellipse;
import javafx.scene.shape.Rectangle;

public class TechnoEnemy extends Thread {

    public Boolean stop = false;
    
    private AnchorPane anchorPane;
    public Double xPosn = 0.0;
    public Double yPosn = 0.0;

    private Rectangle missle;
    private Long sleepTime = 400L;
    public Bounds bounds = null;
    public boolean paused = false;
    
    public TechnoEnemy(AnchorPane anchorPane, Double xPosn)
    {   
        //Set Pane
        this.anchorPane = anchorPane;
        this.xPosn = xPosn;

        //Create Enemy
        Rectangle newMissle = new Rectangle(15, 15);
        missle = newMissle;
        missle.setTranslateX(xPosn);
        missle.setTranslateY(5);
        missle.setFill(Color.RED);
        
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
