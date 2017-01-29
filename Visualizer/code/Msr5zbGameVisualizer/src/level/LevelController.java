//Michael Rallo msr5zb 12358133
package level;

import java.io.File;
import java.net.URL;
import java.util.ArrayList;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.event.Event;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Menu;
import javafx.scene.control.MenuItem;
import javafx.scene.control.Slider;
import javafx.scene.layout.AnchorPane;
import javafx.scene.media.Media;
import javafx.scene.media.MediaPlayer;
import javafx.scene.media.MediaView;
import javafx.scene.text.Text;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import javafx.util.Duration;

public class LevelController implements Initializable {
    
    //FXML Linking Variables
    @FXML
    private AnchorPane vizPane;
    
    @FXML
    private MediaView mediaView;
    
    @FXML
    private Text filePathText;
    
    @FXML
    private Text lengthText;
    
    @FXML
    private Text currentText;
    
    @FXML
    private Text bandsText;
    
    @FXML
    private Text levelNameText;
    
    @FXML
    private Text errorText;
    
    @FXML
    private Menu levelsMenu;
    
    @FXML
    private Menu bandsMenu;
    
    @FXML
    private Slider timeSlider;
    
    @FXML
    private Text controls;
      
    @FXML
    private Menu aboutMenu;
    
    @FXML
    AnchorPane mainPane;   
    
    private Media media;
    private MediaPlayer mediaPlayer;
    
    private Integer numBands = 40;
    private Double updateInterval = 0.05;
    
    private ArrayList<LevelStandards> levels;
    private LevelStandards currentLevel;
    private Integer[] bandsList = {1, 2, 4, 8, 16, 20, 40, 60, 100, 120, 140};
    
    private LevelStandards about;
    

    
    @Override
    public void initialize(URL url, ResourceBundle rb) 
    {
        //Handle Presets Here
        
        //Background Image
        String image = Msr5zbGameVisualizer.class.getResource("images/bluebg.gif").toExternalForm();
        try
        {
            mainPane.setStyle("-fx-background-image: url(" + image + "); -fx-background-repeat:stretch"); 
        }
        catch (Exception ex) {
          Logger.getLogger(TechnoLevel.class.getName()).log(Level.SEVERE, null, ex);
        }       
        
        bandsText.setText(Integer.toString(numBands));
        
        //Add Levels To a List
        levels = new ArrayList<>();
        levels.add(new SpaceLevel());
        levels.add(new ForestLevel());
        levels.add(new BonesLevel());
        levels.add(new TechnoLevel());
        levels.add(new About());
        
        //Add Levels To Menu
        for (LevelStandards level : levels) {
            MenuItem menuItem = new MenuItem(level.getName());
            menuItem.setUserData(level);
            menuItem.setOnAction((ActionEvent event) -> {
                selectLevel(event);
            });
            if(level.getName() != "Information")
            levelsMenu.getItems().add(menuItem);
            
            if(level.getName() == "Information")
            aboutMenu.getItems().add(menuItem);   
            
        }

        //Bottom Text
        levelNameText.setText("Please Select A Level~\n"
                + "Then Open A Song~");
        
        //Set/Get Bands
        for (Integer bands : bandsList) {
            MenuItem menuItem = new MenuItem(Integer.toString(bands));
            menuItem.setUserData(bands);
            menuItem.setOnAction((ActionEvent event) -> {
                selectBands(event);
            });
            bandsMenu.getItems().add(menuItem);
        }
        
    }
    
    //Select Level
    private void selectLevel(ActionEvent event) {
        MenuItem menuItem = (MenuItem)event.getSource();
        LevelStandards level = (LevelStandards)menuItem.getUserData();
        changeLevel(level);
    }
    
    //Select Number of Bands
    private void selectBands(ActionEvent event) {
        MenuItem menuItem = (MenuItem)event.getSource();
        numBands = (Integer)menuItem.getUserData();
        if (currentLevel != null) {
            currentLevel.start(numBands, vizPane);
        }
        if (mediaPlayer != null) {
            mediaPlayer.setAudioSpectrumNumBands(numBands);
        }
        bandsText.setText(Integer.toString(numBands));
    }
    
    //Change The Level
    private void changeLevel(LevelStandards level) {
        if (currentLevel != null) {
            currentLevel.end();
        }
       // if(about != null){about.end();}
        currentLevel = level;
        currentLevel.start(numBands, vizPane);
        levelNameText.setText(currentLevel.getName());
        }
    
    //Open Song
    private void openMedia(File file) {
        filePathText.setText("");
        errorText.setText("");
        
        if (mediaPlayer != null) {
            mediaPlayer.dispose();
        }
        
        try {
            media = new Media(file.toURI().toString());
            mediaPlayer = new MediaPlayer(media);
            mediaView.setMediaPlayer(mediaPlayer);
            mediaPlayer.setOnReady(() -> {
                handleReady();
            });
            mediaPlayer.setOnEndOfMedia(() -> {
                handleEndOfMedia();
            });
            mediaPlayer.setAudioSpectrumNumBands(numBands);
            mediaPlayer.setAudioSpectrumInterval(updateInterval);
            mediaPlayer.setAudioSpectrumListener((double timestamp, double duration, float[] magnitudes, float[] phases) -> {
                handleUpdate(timestamp, duration, magnitudes, phases);
            });
            mediaPlayer.setAutoPlay(true);
            filePathText.setText(file.getPath());
            
        } catch (Exception ex) {
            errorText.setText(ex.toString());
        }
    }
    
    private void handleReady() {
        Duration duration = mediaPlayer.getTotalDuration();
        lengthText.setText(duration.toString());
        Duration ct = mediaPlayer.getCurrentTime();
        currentText.setText(ct.toString());
        if(currentLevel != null)
        currentLevel.start(numBands, vizPane);
        timeSlider.setMin(0);
        timeSlider.setMax(duration.toMillis());
    }
    
    private void handleEndOfMedia() {
        mediaPlayer.stop();
        mediaPlayer.seek(Duration.ZERO);
        timeSlider.setValue(0);
        currentLevel.pause();
    }
    
    private void handleUpdate(double timestamp, double duration, float[] magnitudes, float[] phases) {
        Duration ct = mediaPlayer.getCurrentTime();
        currentText.setText(ct.toString());
        timeSlider.setValue(ct.toMillis());
        
        if(currentLevel != null)
        currentLevel.update(timestamp, duration, magnitudes, phases);
        
    }
    
    @FXML
    private void handleOpen(Event event) {
        Stage primaryStage = (Stage)vizPane.getScene().getWindow();
        FileChooser fileChooser = new FileChooser();
        File file = fileChooser.showOpenDialog(primaryStage);
        if (file != null) {
            openMedia(file);
        }
    }
    
    @FXML
    private void handlePlay(ActionEvent event) {
        if (mediaPlayer != null) {
            mediaPlayer.play();
        }
        if(currentLevel != null)
        currentLevel.resume();
        
    }
    
    @FXML
    private void handlePause(ActionEvent event) {
        if (mediaPlayer != null) {
           mediaPlayer.pause(); 
        }
        if(currentLevel != null)
        currentLevel.pause();
    }
    
    @FXML
    private void handleStop(ActionEvent event) {
        if (mediaPlayer != null) {
           mediaPlayer.stop(); 
        }
        if(currentLevel != null)
        currentLevel.pause();
        
    }
  
}
