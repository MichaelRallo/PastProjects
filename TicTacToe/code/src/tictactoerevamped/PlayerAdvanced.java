/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tictactoerevamped;

import java.util.ArrayList;
import java.util.List;
import java.util.Random;

/**
 *
 * @author Mike
 */
public class PlayerAdvanced {
    String myMark;
    String opponentsMark;
    BoardProcessor boardProcessor = new BoardProcessor();
    
    //Contructor Sets the AI's Mark
    public PlayerAdvanced(String myMark){
        this.myMark = myMark;
        if(this.myMark.equals("X")){this.opponentsMark = "O";}
        else{this.opponentsMark = "X";}
    }
  
    public BoardStateSpace doMove(BoardStateSpace originalStateSpace){
        System.out.println("Advanced Move");
        
        //Clone original StateSpace to work with.
        BoardStateSpace workingStateSpace = new BoardStateSpace();
        workingStateSpace.cloneStateSpace(originalStateSpace);
        
        //For Future Children Manipulation
        BoardStateSpace workingChildrenStateSpace = new BoardStateSpace();
        workingChildrenStateSpace.cloneStateSpace(workingStateSpace);
        
        //Chosen Move
        BoardStateSpace chosenMove1st;
        
        //Initial Checks!
        if(this.myMark.equals("X")){
            //Check our Cases
            Tile tileCheck1 = boardProcessor.checkPlayerXPotentialWin(workingStateSpace);
            Tile tileCheck2 = boardProcessor.checkPlayerOPotentialWin(workingStateSpace);
            
            if (tileCheck1 != null){
                workingChildrenStateSpace.board[tileCheck1.row][tileCheck1.column].setTileMark(this.myMark);           
                return workingChildrenStateSpace;
            }
            else if(tileCheck2 != null){
                workingChildrenStateSpace.board[tileCheck2.row][tileCheck2.column].setTileMark(this.myMark);  
                return workingChildrenStateSpace;
            }
        
        }
        else{
            //Check our Cases
            Tile tileCheck1 = new Tile();
            Tile tileCheck2 = new Tile();
            tileCheck1 = boardProcessor.checkPlayerOPotentialWin(workingStateSpace);
            tileCheck2 = boardProcessor.checkPlayerXPotentialWin(workingStateSpace);
            
            if (tileCheck1 != null){
                workingChildrenStateSpace.board[tileCheck1.row][tileCheck1.column].setTileMark(this.myMark);
                return workingChildrenStateSpace;}
            else if(tileCheck2 != null){
                workingChildrenStateSpace.board[tileCheck2.row][tileCheck2.column].setTileMark(this.myMark);
                return workingChildrenStateSpace;
            }
        }        
        
        //Chosen locations
        int chosenLocation = -1;
        
        
        //Children Sets
        workingChildrenStateSpace.generateChildrenStateSpaces(this.myMark);
        List<BoardStateSpace> children = new ArrayList<BoardStateSpace>();
        //Childrens' MoveSets
        List<BoardStateSpace> children2ndMove = new ArrayList<BoardStateSpace>();
        //Childrens' Chosen Moves
        List<BoardStateSpace> chosenMoves = new ArrayList<BoardStateSpace>();
        
        //Generate 1st Gen Children
        children = workingChildrenStateSpace.children;
        System.out.println("Number of Children is: " + children.size());
        for(int i = 0; i < children.size(); i++) {
            //Generate 2nd Gen
            children.get(i).generateChildrenStateSpaces(this.opponentsMark);
            children2ndMove = children.get(i).children;
            chosenMoves.add(min(children2ndMove, this.myMark));
            children2ndMove.clear();
        }
        
        chosenMove1st = max(chosenMoves, this.myMark);
        chosenLocation = chosenMoves.indexOf(chosenMove1st);
        workingStateSpace = children.get(chosenLocation);

        return workingStateSpace;
    }
    
    public BoardStateSpace min(List<BoardStateSpace> children, String playerMark){
        List<BoardStateSpace> randomBag = new ArrayList<BoardStateSpace>();
        BoardStateSpace minChoice;

        //Set First one to Default
        minChoice = children.get(0);

        //Go Through All Children, get the Min Potentials
        for(int i = 0; i < children.size(); i++){
            if(playerMark.equals("O")){
                if(boardProcessor.countPlayerXPotentialWin(minChoice) > boardProcessor.countPlayerXPotentialWin(children.get(i))){
                        minChoice = children.get(i);
                }
            }
            else{
                if(boardProcessor.countPlayerOPotentialWin(minChoice) > boardProcessor.countPlayerOPotentialWin(children.get(i))){
                        minChoice = children.get(i);
                }
            }   
        }
      
        //Now That we Have Node with Max Value, Let's Research The Nodes matching that Value and Make a Random Bag!
        //Go Through All Children, get the Max Potentials
        for(int i = 0; i < children.size(); i++){
            
            if(playerMark.equals("O")){
                if(boardProcessor.countPlayerOPotentialWin(minChoice) == boardProcessor.countPlayerOPotentialWin(children.get(i))){
                        randomBag.add(children.get(i));
                }
            }
            
            else{
                if(boardProcessor.countPlayerXPotentialWin(minChoice) == boardProcessor.countPlayerXPotentialWin(children.get(i))){
                        randomBag.add(children.get(i));
                }
            }   
        }
        
        //If we Only Have one in Our Bag, Return it...
        if(randomBag.size() == 1){
            return randomBag.get(0);
        }

        //Otherwise, Choose a Random Value!
        Random rand = new Random();
        return randomBag.get(rand.nextInt(randomBag.size()));
        
    }
    
    public BoardStateSpace max(List<BoardStateSpace> children, String playerMark){
        List<BoardStateSpace> randomBag = new ArrayList<BoardStateSpace>();
        BoardStateSpace maxChoice;
        
        //Set First one as Default
        maxChoice = children.get(0);
        
        //Go Through All Children, get the Max Potentials
        for(int i = 0; i < children.size(); i++){
            
            if(playerMark.equals("O")){
                if(boardProcessor.countPlayerOPotentialWin(maxChoice) < boardProcessor.countPlayerOPotentialWin(children.get(i))){
                        maxChoice = children.get(i);
                }
            }
            
            else{
                if(boardProcessor.countPlayerXPotentialWin(maxChoice) < boardProcessor.countPlayerXPotentialWin(children.get(i))){
                        maxChoice = children.get(i);
                }
            }   
        }
        
        //Now That we Have Node with Max Value, Let's Research The Nodes matching that Value and Make a Random Bag!
        //Go Through All Children, get the Max Potentials
        for(int i = 0; i < children.size(); i++){
            
            if(playerMark.equals("O")){
                if(boardProcessor.countPlayerOPotentialWin(maxChoice) == boardProcessor.countPlayerOPotentialWin(children.get(i))){
                        randomBag.add(children.get(i));
                }
            }
            
            else{
                if(boardProcessor.countPlayerXPotentialWin(maxChoice) == boardProcessor.countPlayerXPotentialWin(children.get(i))){
                        randomBag.add(children.get(i));
                }
            }   
        }
        
        //If we Only Have one in Our Bag, Return it...
        if(randomBag.size() == 1){
            return randomBag.get(0);
        }
        
        //Otherwise, Choose a Random Value!
        Random rand = new Random();
        return randomBag.get(rand.nextInt(randomBag.size()));
       
    }

}










