/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tictactoerevamped;

import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.EventHandler;
import javafx.scene.Node;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.GridPane;

/**
 *
 * @author Mike
 */
public class PlayerHuman {
    String myMark;
    String opponentsMark;
    boolean myMove;
    
    public PlayerHuman(String myMark){
        this.myMark = myMark;
        if(this.myMark.equals("X")){this.opponentsMark = "O";}
        else{this.opponentsMark = "X";}
        
    }
    
    public boolean getMyTurn(){return this.myMove;}
    public void setMyTurn(boolean value){this.myMove = value;}
    
    public BoardStateSpace doMove(BoardStateSpace StartingStateSpace, GridPane boardDisplayGrid){
        
        System.out.println("Doing Human's Move");
        BoardStateSpace workingStateSpace = new BoardStateSpace();
        workingStateSpace.cloneStateSpace(StartingStateSpace);
        setMyTurn(true);  
        
       boardDisplayGrid.getChildren().clear();
       boardDisplayGrid.setStyle("-fx-background-color: blue; -fx-padding: 2;");
        for(int i = 0; i < 4; i++){
            for(int j = 0; j < 4; j++){
                ImageView mark = new ImageView(new Image("empty.png"));
                                        
                //Add in the current working Room, note parameters are (object, col, row);
                mark.addEventHandler(MouseEvent.MOUSE_CLICKED, new EventHandler<MouseEvent>() {

                    @Override
                    public void handle(MouseEvent event) {
                        System.out.println("Click~");
                        int row = GridPane.getRowIndex((Node)event.getSource());
                        int column = GridPane.getColumnIndex((Node)event.getSource());
                        //Check if it's the Player's Turn...
                        if(getMyTurn()){
                            
                            //Check if Mark Available to Play
                            if(workingStateSpace.board[row][column].tileMark.equals("empty")){
                               
                                System.out.println("Adding...");             

                                //Update Board StateSpace
                                workingStateSpace.board[row][column].setTileMark(myMark);

                                //Update GUI - Add Image                                              
                                ImageView workingImage = (ImageView)event.getSource();   
                                workingImage.setImage(new Image(myMark + ".png"));

                                setMyTurn(false);
                                
                            }
                            else{
                               System.out.println("You Cannot Place a Mark Here!");
                            }                
                        }
                        else{
                            System.out.println("You Must Wait Your Turn!");
                            
                        }            
                    }
                                          
                });
                mark.setStyle("-fx-background-color: whitesmoke; -fx-padding: 2;");
                GridPane.setConstraints(mark, j, i);
                boardDisplayGrid.getChildren().add(mark);
                
            }
        }   
       
        while(getMyTurn() == true){
            try {
                Thread.sleep(2000);
            } catch (InterruptedException ex) {
                Logger.getLogger(PlayerHuman.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
        
        return workingStateSpace;
    }
}
