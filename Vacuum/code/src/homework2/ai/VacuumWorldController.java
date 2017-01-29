/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package homework2.ai;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.geometry.Insets;
import javafx.scene.control.Button;
import javafx.scene.control.ChoiceBox;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.control.TextArea;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;

/**
 * FXML Controller class
 *
 * @author sugarhryszko
 */
public class VacuumWorldController implements Initializable {

    StateSpace currentStateSpace;
    int rows;
    int columns;
    GridPane grid = new GridPane();
    
    @FXML
    private AnchorPane board;
    @FXML
    private Label costLabel;
    @FXML
    private Label dirtyRoomLabel;
    @FXML
    private Label depthLabel;
    @FXML
    private Label currentRoomLabel;
    @FXML
    private TextArea actionList;
    @FXML
    private AnchorPane gridContainer;
    @FXML
    private Button buttonDFGS;
    @FXML
    private Button buttonIDS;
    @FXML
    private Button buttonAStar;
    @FXML
    private Button buttonToggleRooms;
    @FXML
    private Button buttonReset;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        
        //Default Room
        setRows(4);
        setColumns(4);
        
        //Initialize Rooms Array
        Room[][] rooms = new Room[getRows()][getColumns()];
            
        //Create Our Rooms
        RoomGenerator roomGenerator = new RoomGenerator();
        roomGenerator.createRooms(rooms);
        
        StateSpace workingStateSpace = new StateSpace(rooms, getRows(), getColumns());
        setCurrentState(workingStateSpace);
        
        
        //Set Padding for Grid Cells
        grid.setPadding(new Insets(20,20,20,20)); 

        workingStateSpace.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
        gridContainer.getChildren().add(grid);

    }    
    
       public void setCurrentState(StateSpace workingStateSpace){
        if(workingStateSpace.getDirtyRoomCount()==0){System.out.println("YOU WIN!");}
        this.currentStateSpace = workingStateSpace;
    } 
    public int getRows(){
     return this.rows;   
    }
    public void setRows(int value){
        this.rows = value;
    }
    public int getColumns(){
     return this.columns;   
    }
    public void setColumns(int value){
        this.columns = value;
    }
    
    public StateSpace getCurrentState(){return this.currentStateSpace;}

    @FXML
    private void buttonToggleRoomsFunction(ActionEvent event) {
                if(getRows() == 4){
                    setRows(5);
                    setColumns(6);  
                }
                else{
                    setRows(4);
                    setColumns(4);  
                }
           
                Room[][] rooms = new Room[getRows()][getColumns()];

                RoomGenerator roomGenerator = new RoomGenerator();
                roomGenerator.createRooms(rooms);
        
                //Update State Display
                StateSpace workingStateSpace = new StateSpace(rooms, getRows(), getColumns());
                setCurrentState(workingStateSpace);
           
                if(workingStateSpace!=null){
                    workingStateSpace.generateChildren();
                    workingStateSpace.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
                    setCurrentState(workingStateSpace);       
                }
                else{System.out.println("Cannot Move This Direction.");}
    }

    @FXML
    private void buttonDFGSFunction(ActionEvent event) {
                AlgorithmDFGS startDFGS = new AlgorithmDFGS();
                long startTime = System.nanoTime();
                StateSpace updatedState = startDFGS.IterationDFGS(getCurrentState());
                long endTime = System.nanoTime();
                long duration = (endTime - startTime); 
                System.out.println("*******************************************************************************************");
                System.out.println("Ran in: " + duration/1000000);
                if(updatedState!=null){                   
                    updatedState.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
                    
                    setCurrentState(updatedState);       
                }
                else{System.out.println("Lol gg");}
    }

    @FXML
    private void buttonIDSFunction(ActionEvent event) {
                AlgorithmIDS startIDS = new AlgorithmIDS();
                long startTime = System.nanoTime();
                StateSpace updatedState = startIDS.IterateIDS(getCurrentState());
                long endTime = System.nanoTime();
                long duration = (endTime - startTime); 
                System.out.println("*******************************************************************************************");
                System.out.println("Ran in: " + duration/1000000);
                if(updatedState!=null){                   
                    updatedState.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
                    
                    setCurrentState(updatedState);       
                }
                else{System.out.println("Lol gg");}
    }

    @FXML
    private void butttonAStarFunction(ActionEvent event) {
                AlgorithmAStar startAStar = new AlgorithmAStar();
                long startTime = System.nanoTime();
                StateSpace updatedState = startAStar.IterationAStar(getCurrentState());
                long endTime = System.nanoTime();
                long duration = (endTime - startTime); 
                System.out.println("*******************************************************************************************");
                System.out.println("Ran in: " + duration/1000000);
                if(updatedState!=null){                   
                    updatedState.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
                    
                    setCurrentState(updatedState);       
                }
                else{System.out.println("Lol gg");}
    }

    @FXML
    private void buttonResetFunction(ActionEvent event) {
                //Initialize Rooms Array                
                Room[][] rooms = new Room[getRows()][getColumns()];

                RoomGenerator roomGenerator = new RoomGenerator();
                roomGenerator.createRooms(rooms);
        
                //Update State Display
                StateSpace workingStateSpace = new StateSpace(rooms, getRows(), getColumns());
                setCurrentState(workingStateSpace);
                
                               
                if(workingStateSpace!=null){
                    workingStateSpace.generateChildren();
                    workingStateSpace.updateStateSpaceDisplay(grid, costLabel, dirtyRoomLabel, depthLabel, currentRoomLabel, actionList);
                    setCurrentState(workingStateSpace);       
                }
                else{System.out.println("Cannot Move This Direction.");}
    }
    
}
