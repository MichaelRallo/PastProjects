package tictactoerevamped;

import java.util.ArrayList;
import java.util.List;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.GridPane;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author Mike
 */
public class BoardStateSpace {
    
    static int ROWS = 4;
    static int COLUMNS = 4;
    Tile[][] board = new Tile[ROWS][COLUMNS];
    
    int nodeID = 0;
    int parentID = 0;
    int lookAhead = 0;
    int potentialValue = 0;
    int hValue = 0;
        
    BoardStateSpace parent;
    List<BoardStateSpace> children = new ArrayList<BoardStateSpace>();
    
    //Default Constructor, Starts with a Fresh Board!
    public BoardStateSpace(){
        for(int i = 0; i < ROWS; i++){
            for(int j = 0; j < COLUMNS; j++){
                this.board[i][j] = new Tile(i, j, "empty");
            }
        }
    }
    
    //Prints out the Board StateSpace
    public void printBoard(){
        for(int i = 0; i < ROWS; i++){
            for(int j = 0; j < COLUMNS; j++){
                System.out.print(this.board[i][j].tileMark + " ");
            }
            System.out.print("\n");
        }        
    }
    
    //Generates Current Board State Space's Children 
    public void generateChildrenStateSpaces(String mark){
        this.children.clear();
        //Potential Children States
        for(int i = 0; i < 4; i++){
            for(int j = 0; j < 4; j++){
                if(this.board[i][j].tileMark.equals("empty")){
                    //Make it a Child State
                    BoardStateSpace childBoard = new BoardStateSpace();
                    childBoard.cloneBoard(this.board);
                    childBoard.board[i][j].setTileMark(mark);
                    childBoard.parent = this;
                    this.children.add(childBoard);
                }
            }
        }
    }
    
    //Clones a Board State Space
    public void cloneStateSpace(BoardStateSpace stateSpaceToClone){
        this.nodeID = stateSpaceToClone.nodeID;
        this.parentID = stateSpaceToClone.parentID;
        this.lookAhead = stateSpaceToClone.lookAhead;
        for(int i = 0; i < ROWS; i++){
            for(int j = 0; j < COLUMNS; j++){
                this.board[i][j].tileMark = new String(stateSpaceToClone.board[i][j].tileMark);
            }
        }
    
        this.parent = stateSpaceToClone.parent; 
        this.children = stateSpaceToClone.children;
    }
    
    //Clones a Board
    public void cloneBoard(Tile[][] boardToClone){
        for(int i = 0; i < ROWS; i++){
            for(int j = 0; j < COLUMNS; j++){
                this.board[i][j].tileMark = new String(boardToClone[i][j].tileMark);
            }
        }
    }
  
    //Updates the Display of our Grid using curretn StateSpace
    public void updateDisplay(GridPane boardDisplayGrid){  
        
       boardDisplayGrid.getChildren().clear();
       boardDisplayGrid.setStyle("-fx-background-color: gray; -fx-padding: 2;");
        for(int i = 0; i < ROWS; i++){
            for(int j = 0; j < COLUMNS; j++){
                ImageView mark = new ImageView();
                mark.setImage(new Image(this.board[i][j].tileMark + ".png"));
                mark.setStyle("-fx-background-color: whitesmoke; -fx-padding: 2;");
                GridPane.setConstraints(mark, j, i);
                boardDisplayGrid.getChildren().add(mark);
            }
        }
           
    }
    
    //Resets the Board!
    public void resetBoard(){
        for(int i= 0; i < 4; i++){
            for(int j = 0; j < 4; j++){
                this.board[i][j].setTileMark("empty");
            }
        }
    }
    
    
}
