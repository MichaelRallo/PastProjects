//Michael Rallo msr5zb 12358133
package level;

import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.application.Platform;
import javafx.geometry.Bounds;
import javafx.scene.layout.AnchorPane;
import javafx.scene.paint.Color;
import javafx.scene.shape.Rectangle;

public class TechnoMissle extends Thread
{

    public Boolean stop = false;
    
    private AnchorPane anchorPane;
    public Double xPosn = 0.0;
    public Double yPosn = 0.0;

    private Rectangle missle;
    private Long sleepTime = 10L;
    public Bounds bounds = null;
    public boolean paused = false;
    
    
    public TechnoMissle(AnchorPane anchorPane, Double xPosn, Double yPosn) 
    {
        //Set Pane/Positions
        this.anchorPane = anchorPane;
        this.xPosn = xPosn;
        this.yPosn = yPosn;
        
        //Create Missle
        Rectangle newMissle = new Rectangle(2, 12);
        missle = newMissle;
        missle.setTranslateX(xPosn + 10);
        missle.setTranslateY(yPosn - 15);
        missle.setFill(Color.RED);
        
        //Add It
        anchorPane.getChildren().add(missle);
    }
    
    @Override
    public void run() 
    {
        while (missle.getTranslateY() >= 0 && this.stop == false) 
        {
            Platform.runLater(() -> 
            {
                if(paused == false)
                {  //Fire Missle "Upwards"                     
                   missle.setTranslateY(missle.getTranslateY() - 1.5);
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
