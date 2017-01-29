//Michael Rallo msr5zb 12358133
package level;

import javafx.scene.layout.AnchorPane;

//Set Standards That All Levels Must Implement
public interface LevelStandards 
{
    public void pause();
    public void resume();
    public void start(Integer numBands, AnchorPane vizPane);
    public void end();
    public String getName();
    public void update(double timestamp, double duration, float[] magnitudes, float[] phases);
}
