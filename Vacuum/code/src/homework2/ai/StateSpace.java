/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package homework2.ai;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.control.TextArea;
import javafx.scene.layout.GridPane;
import javafx.scene.paint.Color;
import javafx.scene.paint.Paint;
import javafx.scene.shape.Rectangle;

/**
 *
 * @author Mike
 */
public class StateSpace {
    
    //State's Initial Values
    int rows;
    int columns;
    private int depth ;
    
    //State's Rooms
    private Room currentRoom;
    private Room[][] roomsArray;
  
    //State's Details
    StateSpace parentStateSpace;
    List<String> actionList = new ArrayList<String>();
    HashMap<String, StateSpace> children = new HashMap<String, StateSpace>();
    
    //Sets The Rows for the Rooms Array
    public void setRows(int value){this.rows = value;}
    //Gets The Rows for the Rooms Array
    public int getRows(){return this.rows;}
    //Sets The Columns for the Rooms Array
    public void setColumns(int value){this.columns = value;}
    //Gets The Columns for the Rooms Array
    public int getColumns(){return this.columns;}   
    //Sets The Depth of the StateSpace
    public void setDepth(int value){this.depth = value;}
    //Gets The Depth of the StateSpace
    public int getDepth(){return this.depth;}    
    //Sets the Current Room of where the Vacuum is In
    public void setCurrentRoom(){this.currentRoom = findCurrentRoom();this.currentRoom.setVisited(true);}
    //Gets the Current Room of where the Vacuum is In
    public Room getCurrentRoom(){return this.currentRoom;}   
    //Finds and Returns the Current Room
    public Room findCurrentRoom(){
        for(int i = 0; i < this.getRows(); i++){
            for(int j = 0; j < this.getColumns(); j++){
                if(this.roomsArray[i][j].getHasVacuum() == true){
                    return this.roomsArray[i][j];
                }
            }
        }
        return null;
    }
    //Prints out the Current Room that our State has the Vacuum in.
    public void printCurrentRoomLocation(){
        System.out.println("**********CURRENT ROOM IS: " + this.currentRoom.getPositionRow()+ "," + this.currentRoom.getPositionColumn() + "**********");
    }
    //Sets the RoomsArray
    public void setRoomsArray(Room[][] rooms){this.roomsArray = rooms;}
    //Gets the RoomsArray
    public Room[][] getRoomsArray(){return this.roomsArray;}   
    //Returns a Cloned RoomsArray
    public Room[][] cloneRoomsArray(Room[][] originalRoomsArray){
        //Initialize new Cloned Rooms Array
        Room[][] clonedRoomsArray = new Room[originalRoomsArray.length][originalRoomsArray[0].length];
        //Loop Through All Rooms, Cloning them one by one.
        for(int i = 0; i < originalRoomsArray.length; i++){
            for(int j = 0; j < originalRoomsArray[0].length; j++){
                clonedRoomsArray[i][j] = originalRoomsArray[i][j].cloneRoom(originalRoomsArray[i][j]);
            }
        }
        return clonedRoomsArray;   
    }
    //Sets the ParentStateSpace
    public void setParentStateSpace(StateSpace parentStateSpace){this.parentStateSpace = parentStateSpace;}
    //Gets the ParentStateSpace
    public StateSpace getParentStateSpace(){return this.parentStateSpace;}   
    
    //Sets the ActionList
    public void setActionList(List<String> actionList){this.actionList = actionList;}
    //Gets the ActionList
    public List<String> getActionList(){return this.actionList;}  
    
    //Clone an ActionList
    public List<String> cloneList(List<String> originalList) {
       List<String> clonedActionList = new ArrayList<String>();
        for(int i = 0; i < originalList.size(); i++) {
            clonedActionList.add(originalList.get(i));
        }
       return clonedActionList;
   }   
    
    //Prints out the Action List of the Current State
    public void printActionList(List<String> actionList){
        for(int i = 0; i < actionList.size(); i++) {
            System.out.println(actionList.get(i));
        }
    }
    //Sets the Children
    public void setChildren(HashMap<String, StateSpace> newChildren){this.children = newChildren;}
    //Adds a Child
    public void addChildren(String Action, StateSpace Child){this.children.put(Action, Child);}
    //Gets the Children
    public HashMap<String, StateSpace> getChildren(){return this.children;}     
    //Prints the Children
    public void printChildren(HashMap<String, StateSpace> children){
        if(this.getParentStateSpace() != null){System.out.println("Parent: " + this.getParentStateSpace().getCurrentRoom().getPositionRow() +","+ this.getParentStateSpace().getCurrentRoom().getPositionColumn());}
        else{System.out.println("Parent: Null");} 
        //this.printCurrentRoomLocation();
        
        if(this.children.get("cleanChild") != null){System.out.println("Clean Child: " + this.children.get("cleanChild").getCurrentRoom().getPositionRow() +","+ this.children.get("cleanChild").getCurrentRoom().getPositionColumn());}
        else{System.out.println("Clean Child: Null");}
        if(this.children.get("leftChild") != null){System.out.println("Left Child: " + this.children.get("leftChild").getCurrentRoom().getPositionRow() +","+ this.children.get("leftChild").getCurrentRoom().getPositionColumn());}
        else{System.out.println("Left Child: Null");} 
        if(this.children.get("rightChild") != null){System.out.println("Right Child: " + this.children.get("rightChild").getCurrentRoom().getPositionRow() +","+ this.children.get("rightChild").getCurrentRoom().getPositionColumn());}
        else{System.out.println("Right Child: Null");}
        if(this.children.get("upChild") != null){System.out.println("Up Child: " + this.children.get("upChild").getCurrentRoom().getPositionRow() +","+ this.children.get("upChild").getCurrentRoom().getPositionColumn());}
        else{System.out.println("Up Child: Null");}
        if(this.children.get("downChild") != null){System.out.println("Down Child: " + this.children.get("downChild").getCurrentRoom().getPositionRow() +","+ this.children.get("downChild").getCurrentRoom().getPositionColumn());}
        else{System.out.println("Down Child: Null");}    
        
        
    }
    //Returns the number of Dirty Rooms
    public int getDirtyRoomCount(){
        int numberOfDirtyRooms = 0;
        for(int i = 0; i < this.getRows(); i++){
            for(int j = 0; j < this.getColumns(); j++){
                if(this.roomsArray[i][j].getDirty() == true){
                    numberOfDirtyRooms++;
                }
            }
        }    
        return numberOfDirtyRooms;
    }
    
    //Calculates and Returns the Score
    public double getScore(){
        double score = 0;
        for (int i = 0; i < this.actionList.size(); i++) {
            switch(this.actionList.get(i)){
                case "clean" : score+=0;break;
                case "up" : score+=1.3;break;
                case "down" : score+=1.3;break;
                case "left" : score+=1;break;
                case "right" : score+=1;break;
            }        
        }
        return score;
    }

    //Constructor for Original Node
    public StateSpace(Room[][] rooms, int rows, int columns){
        this.setRows(rows);
        this.setColumns(columns);
        
        this.setRoomsArray(rooms);
        this.setCurrentRoom();

        this.setDepth(0);
        this.setParentStateSpace(null);
        this.actionList.add("Start");
        this.children.clear();
    }
  
    //Constructor for Child Nodes
    public StateSpace(StateSpace parentStateSpace){  
        this.setRows(parentStateSpace.getRows());
        this.setColumns(parentStateSpace.getColumns());
        this.setRoomsArray(parentStateSpace.cloneRoomsArray(parentStateSpace.getRoomsArray()));
        this.setCurrentRoom();

        this.setDepth(parentStateSpace.getDepth()+1);
        this.setParentStateSpace(parentStateSpace);
         
        this.actionList = this.cloneList(parentStateSpace.getActionList());
        
        this.children.clear();
    }

    public void generateChildren(){
        this.children.clear();
        System.out.println("Generating Children...");
        //If Dirty, Make a New Child State with Cleaned Room
        if(this.canClean() == true){           
            StateSpace childNode1 = this.cleanCurrentRoom();
            this.addChildren("cleanChild",childNode1);
        } else{this.addChildren("cleanChild",null);}
        
        //If Can move Left, Make a New Child State That has Moved Left
        if(this.canMoveLeft() == true){
            StateSpace childNode2 = this.move("left");
            this.addChildren("leftChild",childNode2);
        } else{this.addChildren("leftChild",null);}
        
        
        //If Can move Right, Make a New Child State That has Moved Right
        if(this.canMoveRight()== true){
            StateSpace childNode3 = this.move("right");
            this.addChildren("rightChild",childNode3);
        } else{this.addChildren("rightChild",null);}
        
        //If Can move Up, Make a New Child State That has Moved Up
        if(this.canMoveUp()== true){
            StateSpace childNode4 = this.move("up");
            this.addChildren("upChild",childNode4);
        } else{this.addChildren("upChild",null);}
        
        //If Can move Down, Make a New Child State That has Moved Down
        if(this.canMoveDown()== true){
            StateSpace childNode5 = this.move("down");
            this.addChildren("downChild",childNode5);
        } else{this.addChildren("downChild",null);}
        
        this.printChildren(this.getChildren());
    }
     


    public boolean canClean(){
        if(this.getCurrentRoom().getDirty() == true){return true;}
        else{return false;}
    }
 


    public StateSpace cleanCurrentRoom(){
        
        StateSpace childStateSpace = new StateSpace(this);
        if(this.canClean()){
            childStateSpace.getCurrentRoom().setDirty(false);
            childStateSpace.getActionList().add("clean");
            return childStateSpace;
        }
        else{childStateSpace = null;return childStateSpace;}
    }
    
    public boolean canMoveLeft(){
        if(this.getCurrentRoom().getPositionColumn() != 0){
            if(this.roomsArray[this.getCurrentRoom().getPositionRow()][(this.getCurrentRoom().getPositionColumn()-1)].getVisited()== false){return true;}
            else{System.out.println("Left Room was Already Visited");return false;}
        }
        else{System.out.println("Hit the Left Wall!");return false;}
    }
    
    public boolean canMoveRight(){
        if(this.getCurrentRoom().getPositionColumn() != this.getColumns()-1){
            if(this.roomsArray[this.getCurrentRoom().getPositionRow()][(this.getCurrentRoom().getPositionColumn()+1)].getVisited()== false){return true;}
            else{System.out.println("Right Room was Already Visited");return false;}
        }
        else{System.out.println("Hit the Right Wall!");return false;}
    }
    
    public boolean canMoveUp(){
        if(this.getCurrentRoom().getPositionRow() != 0){
            if(this.roomsArray[this.getCurrentRoom().getPositionRow()-1][(this.getCurrentRoom().getPositionColumn())].getVisited()== false){return true;}
            else{System.out.println("Up Room was Already Visited");return false;}
        }
        else{System.out.println("Hit the Up Wall!");return false;}
    }
    public boolean canMoveDown(){
        if(this.getCurrentRoom().getPositionRow() != this.getRows()-1){
            if(this.roomsArray[this.getCurrentRoom().getPositionRow()+1][(this.getCurrentRoom().getPositionColumn())].getVisited()== false){return true;}
            else{System.out.println("Down Room was Already Visited");return false;}
        }
        else{System.out.println("Hit the Down Wall!");return false;}
    }
    
    
    //Returns True on Successful Move. False otherwise. Cannot move to already visited rooms.
    public StateSpace move(String direction){
        StateSpace childStateSpace = new StateSpace(this);
        switch(direction){
            case "left": if(this.canMoveLeft()){
                            //If Can Move, Remove Vacuum from the Room
                            childStateSpace.getCurrentRoom().setHasVacuum(false);
                            //Place Vacuum in next Room
                            childStateSpace.getRoomsArray()[childStateSpace.getCurrentRoom().getPositionRow()]
                                                           [childStateSpace.getCurrentRoom().getPositionColumn()-1].setHasVacuum(true);
                            //Adjust The Current Room
                            childStateSpace.setCurrentRoom();
                            //Update Action List
                            childStateSpace.actionList.add("left");
                            return childStateSpace;
                         } else{childStateSpace = null; return null; }
            
            case "right": if(this.canMoveRight()){
                            //If Can Move, Remove Vacuum from the Room
                            childStateSpace.getCurrentRoom().setHasVacuum(false);
                            //Place Vacuum in next Room
                            childStateSpace.getRoomsArray()[childStateSpace.getCurrentRoom().getPositionRow()]
                                                           [childStateSpace.getCurrentRoom().getPositionColumn()+1].setHasVacuum(true);
                            //Adjust The Current Room
                            childStateSpace.setCurrentRoom();
                            //Update Action List
                            childStateSpace.actionList.add("right");
                            return childStateSpace;
                         } else{childStateSpace = null; return null; }
            
            case "up": if(this.canMoveUp()){
                            //If Can Move, Remove Vacuum from the Room
                            childStateSpace.getCurrentRoom().setHasVacuum(false);
                            //Place Vacuum in next Room
                            childStateSpace.getRoomsArray()[childStateSpace.getCurrentRoom().getPositionRow()-1]
                                                           [childStateSpace.getCurrentRoom().getPositionColumn()].setHasVacuum(true);
                            //Adjust The Current Room
                            childStateSpace.setCurrentRoom();
                            //Update Action List
                            childStateSpace.actionList.add("up");
                            return childStateSpace;
                         } else{childStateSpace = null; return null; }
            
            case "down": if(this.canMoveDown()){ //Check if it'll be in bounds
                            //If Can Move, Remove Vacuum from the Room
                            childStateSpace.getCurrentRoom().setHasVacuum(false);
                            //Place Vacuum in next Room
                            childStateSpace.getRoomsArray()[childStateSpace.getCurrentRoom().getPositionRow()+1]
                                                           [childStateSpace.getCurrentRoom().getPositionColumn()].setHasVacuum(true);
                            //Adjust The Current Room
                            childStateSpace.setCurrentRoom();
                            //Update Action List
                            childStateSpace.actionList.add("down");
                            return childStateSpace;
                         } else{childStateSpace = null; return null; }
            default: childStateSpace = null; return null;           
        }
    }

 

    

    
    //Displays out the Current StateSpace
    public void updateStateSpaceDisplay(GridPane grid, Label costLabel, Label dirtyRoomLabel, Label depthLabel, Label currentRoomLabel, TextArea actionListTextArea){
        
        //Labels n Stuffs
        costLabel.setText("Cost: " + getScore());
        dirtyRoomLabel.setText("Dirty Rooms: " + this.getDirtyRoomCount());
        
        depthLabel.setText("Depth: " + this.getDepth());
        currentRoomLabel.setText("Vacuum Location: " + this.getCurrentRoom().getPositionRow() + "," + this.getCurrentRoom().getPositionColumn());
        
        actionListTextArea.setText("");
        for(int i = 0; i < this.actionList.size(); i++) {
            actionListTextArea.appendText(this.actionList.get(i) + "\n");
        }  
   
        grid.getChildren().clear();
        for(int i = 0; i < rows; i++){
            for(int j = 0; j < this.columns; j++){
                Button roomButton = new Button("Room: (" 
                        + this.getRoomsArray()[i][j].getPositionRow() + "," 
                        + this.getRoomsArray()[i][j].getPositionColumn() + ")\n"
                        + "Dirty: " + this.getRoomsArray()[i][j].getDirty()+ "\n"
                        + "Vacuum: " + this.getRoomsArray()[i][j].getHasVacuum());
                if(this.getRoomsArray()[i][j].getHasVacuum()== true){
                    roomButton.setStyle("-fx-base: #b6e7c9;");
                }
                else if(this.getRoomsArray()[i][j].getVisited()== true){
                    roomButton.setStyle("-fx-base: brown;");
                }
                //Add in the current working Room, note parameters are (object, col, row);
                GridPane.setConstraints(roomButton, j, i);
                grid.getChildren().add(roomButton);
            }
        }   
        
           
        
        
        
    }
    
 

    



  
}
