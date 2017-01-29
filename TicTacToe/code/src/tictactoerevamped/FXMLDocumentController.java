/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tictactoerevamped;

import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;
import javafx.scene.text.Font;

/**
 *
 * @author Mike
 */
public class FXMLDocumentController implements Initializable {
    
    //Labels and Stuffs for the Display!
    @FXML
    private AnchorPane boardPane;
    @FXML
    private GridPane board;
    @FXML
    private Button beginnerVsMe;
    @FXML
    private Button beginnerVsAdvanced;
    @FXML
    private Button advancedVsBeginner;
    @FXML
    private Button advancedVsMaster;
    @FXML
    private Button masterVsAdvanced;
    @FXML
    private Label player1Label;
    @FXML
    private Label player2Label;
    
    //The Main StateSpace
    BoardStateSpace currentStateSpace;
    BoardProcessor processBoard = new BoardProcessor();
    boolean gameOver = false;
    
    //Timings~
    long startTime;
    long endTime;
    long duration;
        
    //Used for Beginner vs AI
    boolean aiTurn = true;
    boolean humanTurn = false; 
    @FXML
    private Font x1;
    @FXML
    private Font x2;
    @FXML
    private Label winnerLabel;
         
    //Used for Beginner vs AI.
    public boolean getAiTurn(){return this.aiTurn;}
    public void setAiTurn(boolean value){this.aiTurn = value;}
    public boolean getHumanTurn(){return this.humanTurn;}
    public void setHumanTurn(boolean value){this.humanTurn = value;}
      
    //Setting and Getting Main StateSpace
    private void setCurrentStateSpace(BoardStateSpace newStateSpace){this.currentStateSpace = newStateSpace;}
    private BoardStateSpace getCurrentStateSpace(){return this.currentStateSpace;}
    
     
    
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        //On Start, Create the Main StateSpace and Set it.
        BoardStateSpace workingStateSpace = new BoardStateSpace();
        setCurrentStateSpace(workingStateSpace);       
    }    

    @FXML
    private void beginnerVsMeClick(MouseEvent event) {
        //Set Things Up
        System.out.println("Setting Beginner vs. Me!");
        player1Label.setText("Beginner - X's");
        player2Label.setText("Me - O's");
        getCurrentStateSpace().resetBoard();
        getCurrentStateSpace().updateDisplay(board);
        
        //Make Players
        PlayerBeginner playerBeginner = new PlayerBeginner("X");
        
        //UI Board Clear
        board.getChildren().clear();
        board.setStyle("-fx-background-color: gray; -fx-padding: 2;");
        for(int i = 0; i < 4; i++){
            for(int j = 0; j < 4; j++){
                ImageView mark = new ImageView(new Image("empty.png"));
                long startTime;                        
                //Add in the current working Room, note parameters are (object, col, row);
                mark.addEventHandler(MouseEvent.MOUSE_CLICKED, new EventHandler<MouseEvent>() {

                    @Override
                    public void handle(MouseEvent event) {
                        
                        int row = GridPane.getRowIndex((Node)event.getSource());
                        int column = GridPane.getColumnIndex((Node)event.getSource());
                        //Check if it's the Player's Turn...
                        if(getHumanTurn()){
                           
                           //Check if Mark Available to Play
                           if(getCurrentStateSpace().board[row][column].tileMark.equals("empty")){

                                //Update Board StateSpace
                                getCurrentStateSpace().board[row][column].setTileMark("O");
                                
                                //Update GUI - Add Image                                              
                                ImageView workingImage = (ImageView)event.getSource();   
                                workingImage.setImage(new Image("O.png"));
                                
                                //Check if Win
                                if(processBoard.checkIfWinner(getCurrentStateSpace())){
                                    System.out.println("Winner is: Human!");
                                    winnerLabel.setText("Winner is: Human!");
                                    //End Game 
                                    setAiTurn(false);
                                    setHumanTurn(false);
                                }
                                else{
                                    //Do Opponent's Move
                                    long specialStartTime = System.nanoTime();
                                    playerBeginner.doMoveGUIFriendly(board, getCurrentStateSpace(), "X");
                                    long specialEndTime = System.nanoTime();
                                    long specialDuration = (specialEndTime - specialStartTime); 
                                    System.out.println("Move ran in: " + specialDuration/1000000);
                                    
                                    setHumanTurn(true);
                                    if(processBoard.checkIfWinner(getCurrentStateSpace())){
                                        System.out.println("Winner is: Beginner!");
                                        winnerLabel.setText("Winner is: Beginner!");
                                        //End Game 
                                        setAiTurn(false);
                                        setHumanTurn(false);
                                    }
                                }
                           }
                           else{}           
                        }
                        else{
                            System.out.println("Game is Over...!");
                        }
                    }
                });
                mark.setStyle("-fx-background-color: whitesmoke; -fx-padding: 2;");
                GridPane.setConstraints(mark, j, i);
                board.getChildren().add(mark);
            }
        }   
        //Do Opponent's Move
        long specialStartTime = System.nanoTime();
        playerBeginner.doMoveGUIFriendly(board, getCurrentStateSpace(), "X");
        long specialEndTime = System.nanoTime();
        long specialDuration = (specialEndTime - specialStartTime); 
        System.out.println("Beginner Move Duration: " + specialDuration/1000000);
        
        setHumanTurn(true);
        if(processBoard.checkIfWinner(getCurrentStateSpace())){
            System.out.println("Winner is: Beginner!");
            winnerLabel.setText("Winner is: Beginner!");
            //End Game 
            setAiTurn(false);
            setHumanTurn(false);

        }
    }
    
    

    @FXML
    private void beginnerVsAdvancedClick(MouseEvent event) {
        //Set Things Up
        System.out.println("Setting Beginner vs. Advanced!");
        player1Label.setText("Beginner - X's");
        player2Label.setText("Advanced - O's");
        getCurrentStateSpace().resetBoard();
        getCurrentStateSpace().updateDisplay(board);
        
        //Careate Players!
        PlayerBeginner playerBeginner = new PlayerBeginner("X");
        PlayerAdvanced playerAdvanced = new PlayerAdvanced("O");
        gameOver = false;
        
        while(!gameOver){

            //Beginner's Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerBeginner.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Beginner Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
            
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Beginner!");
                winnerLabel.setText("Winner is: Beginner!");
                gameOver = true;
                break;
            }
                        
            //Advanced Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerAdvanced.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Advanced Move Duration: " + duration/1000000);
            
            //Update board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
               
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Advanced!");
                winnerLabel.setText("Winner is: Advanced!");
                gameOver = true;
                break;
            }
        }       
    }

    @FXML
    private void advancedVsBeginnerClick(MouseEvent event) {
        //Set Things Up
        System.out.println("Setting Advanced vs. Beginner!");
        player1Label.setText("Advanced - X's");
        player2Label.setText("Beginner - O's");
        getCurrentStateSpace().resetBoard();
        getCurrentStateSpace().updateDisplay(board);      

        //Create Players!
        PlayerAdvanced playerAdvanced = new PlayerAdvanced("X");
        PlayerBeginner playerBeginner = new PlayerBeginner("O");
        gameOver = false;
                
        while(!gameOver){
            
            //Advanced Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerAdvanced.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Advanced Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
               
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Advanced!");
                winnerLabel.setText("Winner is: Advanced!");
                gameOver = true;
                break;
            }
            
            //Beginner Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerBeginner.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Beginner Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
            
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Beginner!");
                winnerLabel.setText("Winner is: Beginner!");
                gameOver = true;
                break;
            }
        }  
    }

    @FXML
    private void advancedVsMasterClick(MouseEvent event) {
        //Set Things Up
        System.out.println("Setting Advanced vs. Master!");
        player1Label.setText("Advanced - X's");
        player2Label.setText("Master - O's");
        getCurrentStateSpace().resetBoard();
        getCurrentStateSpace().updateDisplay(board);   

        //Create Players! 
        PlayerAdvanced playerAdvanced = new PlayerAdvanced("X");
        PlayerMaster playerMaster = new PlayerMaster("O");
        gameOver = false;
        
        while(!gameOver){
            
            //Advanced Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerAdvanced.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Advaned Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
               
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Advanced!");
                winnerLabel.setText("Winner is: Advanced!");
                gameOver = true;
                break;
            }
            
            
            //Master Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerMaster.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Master Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
            
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Master!");
                winnerLabel.setText("Winner is: Master!");
                gameOver = true;
                break;
            }
        }      
    }

    @FXML
    private void masterVsAdvancedClick(MouseEvent event) {
        //Set Things Up
        System.out.println("Setting Master vs. Advanced!");
        player1Label.setText("Master - X's");
        player2Label.setText("Advanced - O's");
        getCurrentStateSpace().resetBoard();
        getCurrentStateSpace().updateDisplay(board); 
        
        //Create Players! 
        PlayerMaster playerMaster = new PlayerMaster("X");
        PlayerAdvanced playerAdvanced = new PlayerAdvanced("O");
        gameOver = false;
        
        while(!gameOver){
            
            //Master Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerMaster.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Master move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
            
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Master!");
                winnerLabel.setText("Winner is: Master!");
                gameOver = true;
                break;
            }
            
            
            //Advanced Does Move
            startTime = System.nanoTime();
            setCurrentStateSpace(playerAdvanced.doMove(getCurrentStateSpace()));
            endTime = System.nanoTime();
            duration = (endTime - startTime); 
            System.out.println("Advanced Move Duration: " + duration/1000000);
            
            //Update Board
            getCurrentStateSpace().updateDisplay(board);
            getCurrentStateSpace().printBoard();
            
            //Check if Won
            if(processBoard.checkIfWinner(getCurrentStateSpace())){
                System.out.println("Winner is: Advanced!");
                winnerLabel.setText("Winner is: Advanced!");
                gameOver = true;
                break;
            }
        }
        
    }
    
}
