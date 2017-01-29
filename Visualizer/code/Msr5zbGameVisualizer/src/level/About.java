//Michael Rallo msr5zb 12358133 
package level;

import javafx.scene.layout.AnchorPane;
import javafx.scene.text.Text;


public class About implements LevelStandards 
{   
    private String name = "Information";
    
    private Double width = 0.0;
    private Double height = 0.0;
 
    private Text header;
    private Text body;
    private Text footer;

    public About() {
    }
    
    @Override
    public String getName() {
        return name;
    } 
         
    @Override
    public void start(Integer numBands, AnchorPane vizPane) 
    {
        end(); //To Prevent Dups/Resets

        //Create Texts
        this.header = new Text();
        this.body = new Text();
        this.footer = new Text();

        header.setTranslateX(50);
        header.setTranslateY(40);
        header.setText("~Information Page~");
        header.setId("fancytextAbout");

        body.setTranslateX(10);
        body.setTranslateY(60);
        body.setText("\n To Begin, Go To File and then Open a Song you would like to play~"
                + "\n While The Song Is Playing, Choose Which Level You'd Like To Play On "
                + "\n Level HighScores Are Indepent, But Level Switching is Fluid!"
                + "\n "
                + "\n There Are 4 Levels To Choose From~"
                + "\n Feel Free To InterChange Between Them While Your Song Is Playing"
                + "\n HighScores Will Be Saved Dynamically, No Worries !"
                + "\n"
                + "\n Each Level Has Different Enemies That Fall/Spawn At Different Rates"
                + "\n The Shoot Also Changes With Levels"
                + "\n"
                + "\n If Enemies Make It To The Music Line, You Will Lose Some Points!"
                + "\n"
                + "\n I Included Some Music In The Music Folder For You To Use~"
                + "\n Enjoy~");

        footer.setTranslateX(10);
        footer.setTranslateY(350);       
        footer.setText("\n -Created By Mike-! (Msr5zb)"
                + "\n For His Java Final Project");

        vizPane.getChildren().add(header);
        vizPane.getChildren().add(body);
        vizPane.getChildren().add(footer);

    }

    @Override
    public void end() 
    {
        //Clear Pane~
        if(header != null){
        header.setText("");
        header = null;
        }
                
        if(body != null){
        body.setText("");
        body = null;
        }
        
        if(footer != null){
        footer.setText("");
        footer = null;
        }        
    }
    

     
    @Override
    public void update(double timestamp, double duration, float[] magnitudes, float[] phases) 
    {
        //Nothing Needs Updating~
        //Note, I Treated This As A Level So It Will Be Easier 
        //To Scene Switch/Clear Panes/Add It To Program.
        
    }
    
    public void pause()
    {
    }
 
    public void resume()
    {
    }  
}