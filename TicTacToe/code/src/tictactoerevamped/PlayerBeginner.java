/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tictactoerevamped;

import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.GridPane;

/**
 *
 * @author Mike
 */
public class PlayerBeginner {
    
    String myMark;
    String opponentsMark;
    
    //Contructor Sets the AI's Mark
    public PlayerBeginner(String myMark){
        this.myMark = myMark;
        if(this.myMark.equals("X")){this.opponentsMark = "O";}
        else{this.opponentsMark = "X";}
        
    }
    
    //The AI of Beginner
    public BoardStateSpace doMove(BoardStateSpace startingStateSpace){
        System.out.println("Beginner Move");
        
        //Copy the Original StateSpace
        BoardStateSpace workingStateSpace = new BoardStateSpace();
        workingStateSpace.cloneStateSpace(startingStateSpace);
        
        BoardProcessor processBoard = new BoardProcessor();
        
        if(this.myMark.equals("X")){
            //Check Our Cases
            Tile tileCheck1 = processBoard.checkPlayerXPotentialWin(workingStateSpace);
            Tile tileCheck2 = processBoard.checkPlayerOPotentialWin(workingStateSpace);
            Tile tileCheck3 = processBoard.findNextEmpty(workingStateSpace);
            
            if (tileCheck1 != null){tileCheck1.setTileMark("X");}
            else if(tileCheck2 != null){tileCheck2.setTileMark("X");}
            else if(tileCheck3 != null){tileCheck3.setTileMark("X");}
            else{System.out.println("Cats Game");}
        
        }
        else{
            //Check Our Cases
            Tile tileCheck1 = processBoard.checkPlayerOPotentialWin(workingStateSpace);
            Tile tileCheck2 = processBoard.checkPlayerXPotentialWin(workingStateSpace);
            Tile tileCheck3 = processBoard.findNextEmpty(workingStateSpace);
            
            if (tileCheck1 != null){tileCheck1.setTileMark("O");}
            else if(tileCheck2 != null){tileCheck2.setTileMark("O");}
            else if(tileCheck3 != null){tileCheck3.setTileMark("O");}
            else{System.out.println("Cats Game");}
        }
        
        //workingStateSpace.printBoard();
        return workingStateSpace;

    }
    
    //We Had to Add Another Function to for Beginner's AI Behave Friendly with our GUI.
    //The Logic's the Same, just with a slightly different Approach.
    public void doMoveGUIFriendly(GridPane gridBoard, BoardStateSpace workingStateSpace, String playerMark){
        System.out.println("AI's Move");
        
        BoardProcessor processBoard = new BoardProcessor();
        
        Tile foundTile;
        ImageView mark = new ImageView();
        
        if(playerMark.equals("X")){
            //Check our Cases
            Tile tileCheck1 = processBoard.checkPlayerXPotentialWin(workingStateSpace);
            Tile tileCheck2 = processBoard.checkPlayerOPotentialWin(workingStateSpace);
            Tile tileCheck3 = processBoard.findNextEmpty(workingStateSpace);
            
            if (tileCheck1 != null){
                tileCheck1.setTileMark("X");
                foundTile = tileCheck1;
            }
            else if(tileCheck2 != null){
                tileCheck2.setTileMark("X");
                foundTile = tileCheck2;
            }
            else if(tileCheck3 != null){
                tileCheck3.setTileMark("X");
                foundTile = tileCheck3;
            }
            else{
                System.out.println("CATS GAME! LOL");
                foundTile = null;
            }
            mark.setImage(new Image("X.png"));
            mark.setStyle("-fx-background-color: whitesmoke; -fx-padding: 2;");
        
            //workingStateSpace.setPlayer1Turn(false);
        }
        else{
            //Check our Cases
            Tile tileCheck1 = processBoard.checkPlayerOPotentialWin(workingStateSpace);
            Tile tileCheck2 = processBoard.checkPlayerXPotentialWin(workingStateSpace);
            Tile tileCheck3 = processBoard.findNextEmpty(workingStateSpace);
            
            if (tileCheck1 != null){
                tileCheck1.setTileMark("O");
                foundTile = tileCheck1;
            }
            else if(tileCheck2 != null){
                tileCheck1.setTileMark("O");
                foundTile = tileCheck2;
            }
            else if(tileCheck3 != null){
                tileCheck3.setTileMark("O");
                foundTile = tileCheck3;
            }
            else{
                System.out.println("CATS GAME! LOL");
                foundTile = null;
            }
            mark.setImage(new Image("O.png"));
            mark.setStyle("-fx-background-color: whitesmoke; -fx-padding: 2;");
        }
     
        if(foundTile != null){
            GridPane.setConstraints(mark, foundTile.column, foundTile.row);
            gridBoard.getChildren().add(mark);
        }
        else{
             gridBoard.getChildren().clear();
        }
        
        
        
    }
    
}
