/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package tictactoerevamped;

/**
 *
 * @author Mike
 */
public class BoardProcessor {
        //Deafult Constrauctor
        public BoardProcessor(){}
        
        //Checks if a Winner Exists in the BoardStateSpace
        public boolean checkIfWinner(BoardStateSpace workingStateSpace){
     
        //Check for three in a row
        for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){

                // Left
                if(col-2>=0){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark) && 
                       workingStateSpace.board[row][col-1].tileMark.equals(workingStateSpace.board[row][col-2].tileMark)){
                        return true;
                    }
                }
                //2 Right
                if(col+2<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col+1].tileMark) &&
                       workingStateSpace.board[row][col+1].tileMark.equals(workingStateSpace.board[row][col+2].tileMark)){
                        return true;
                    }
                }

                //1 Left and 1 Right
                if(col-1>=0 && col+1<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark)&&
                       workingStateSpace.board[row][col-1].tileMark.equals(workingStateSpace.board[row][col+1].tileMark)){
                        return true;
                    }   
                }

                //2 Up
                if(row-2>=0){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-1][col].tileMark.equals(workingStateSpace.board[row-2][col].tileMark)){
                        return true;
                    }
                }

                //2 Down
                if(row+2<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)&&
                       workingStateSpace.board[row+1][col].tileMark.equals(workingStateSpace.board[row+2][col].tileMark)){
                        return true;
                    }
                }

                //1 Up 1 Down
                if(row-1>=0 && row+1<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-1][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)){
                        return true;
                    }    
                }

                //2 Diagonal Up-Left
                if(row-2>=0 && col-2>=0){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-1][col-1].tileMark.equals(workingStateSpace.board[row-2][col-2].tileMark)){
                        return true;
                    }    
                }

                //2 Diagonal Up-Right
                if(row-2>=0 && col+2<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-1][col+1].tileMark.equals(workingStateSpace.board[row-2][col+2].tileMark)){
                        return true;
                    }
                }

                //2 Diagonal Down-Left
                if(row+2<4 && col-2>=0){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)&&
                       workingStateSpace.board[row+1][col-1].tileMark.equals(workingStateSpace.board[row+2][col-2].tileMark)){
                        return true;
                    }
                }

                //2 Diagonal Down-Right
                if(row+2<4 && col+2<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)&&
                       workingStateSpace.board[row+1][col+1].tileMark.equals(workingStateSpace.board[row+2][col+2].tileMark)){
                        return true;
                    }
                }


                //1 Diagonal Up-Left][ 1 Diagonal Down-Right
                if(row-1>=0 && row+1<4 && col-1>=0 && col+1<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-1][col-1].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)){
                        return true;
                    }
                }

                //1 Diagonal Up-Right][ 1 Diagonal Down-Left
                if(row-1>=0 && row+1<4 && col-1>=0 && col+1<4){
                    if(!workingStateSpace.board[row][col].tileMark.equals("empty") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-1][col+1].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)){
                        return true;
                    }
                }

            }
        }
        return false;
        
    }
        
    //Find Next Available Empty Tile!  
    public Tile findNextEmpty(BoardStateSpace workingStateSpace){
        for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){
                if(workingStateSpace.board[row][ col].tileMark.equals("empty")){
                    return workingStateSpace.board[row][ col];
                }
            }
        }
        return null;
    }
    
    //Counts Potential Wins for X
    public int countPlayerXPotentialWin(BoardStateSpace workingStateSpace){
       int counter = 0;
       for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){


                //Placements to Check

                //2 Left
                if(col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&     
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark) && 
                       workingStateSpace.board[row][col-2].tileMark.equals("empty")){
                        counter++;
                    }
                }
                //2 Right
                if(col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col+1].tileMark) &&
                       workingStateSpace.board[row][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }


                //2 Up
                if(row-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-2][col].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Down
                if(row+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)&&
                       workingStateSpace.board[row+2][col].tileMark.equals("empty")){
                        counter++;
                    }
                }


                //2 Diagonal Up-Left
                if(row-2>=0 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-2][col-2].tileMark.equals("empty")){
                        counter++;
                    }    
                }

                //2 Diagonal Up-Right
                if(row-2>=0 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-2][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Diagonal Down-Left
                if(row+2<4 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)&&
                       workingStateSpace.board[row+2][col-2].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Diagonal Down-Right
                if(row+2<4 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)&&
                       workingStateSpace.board[row+2][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }
   

            }
        }
        return counter;     
    }

    //Counts Potential Wins for O
    public int countPlayerOPotentialWin(BoardStateSpace workingStateSpace){
        
        int counter = 0;
        for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){


                //Placements to Check

                //2 Left
                if(col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&     
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark) && 
                       workingStateSpace.board[row][col-2].tileMark.equals("empty")){
                        counter++;
                    }
                }
                //2 Right
                if(col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col+1].tileMark) &&
                       workingStateSpace.board[row][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }


                //2 Up
                if(row-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-2][col].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Down
                if(row+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)&&
                       workingStateSpace.board[row+2][col].tileMark.equals("empty")){
                        counter++;
                    }
                }


                //2 Diagonal Up-Left
                if(row-2>=0 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-2][col-2].tileMark.equals("empty")){
                        counter++;
                    }    
                }

                //2 Diagonal Up-Right
                if(row-2>=0 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-2][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Diagonal Down-Left
                if(row+2<4 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)&&
                       workingStateSpace.board[row+2][col-2].tileMark.equals("empty")){
                        counter++;
                    }
                }

                //2 Diagonal Down-Right
                if(row+2<4 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)&&
                       workingStateSpace.board[row+2][col+2].tileMark.equals("empty")){
                        counter++;
                    }
                }
   

            }
        }
        return counter;     
    }    
    
    //Checks Potential Wins for X
    public Tile checkPlayerXPotentialWin(BoardStateSpace workingStateSpace){
        for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){

                //2 Left
                if(col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&     
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark) && 
                       workingStateSpace.board[row][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row][col-2];
                    }
                }
                //2 Right
                if(col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col+1].tileMark) &&
                       workingStateSpace.board[row][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row][col+2];
                    }
                }


                //2 Up
                if(row-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-2][col].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col];
                    }
                }

                //2 Down
                if(row+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)&&
                       workingStateSpace.board[row+2][col].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col];
                    }
                }


                //2 Diagonal Up-Left
                if(row-2>=0 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-2][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col-2];
                    }    
                }

                //2 Diagonal Up-Right
                if(row-2>=0 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-2][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col+2];
                    }
                }

                //2 Diagonal Down-Left
                if(row+2<4 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)&&
                       workingStateSpace.board[row+2][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col-2];
                    }
                }

                //2 Diagonal Down-Right
                if(row+2<4 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("X") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)&&
                       workingStateSpace.board[row+2][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col+2];
                    }
                }
   

            }
        }
        return null;     
    }
    
    //Checks Potential Wins for O
    public Tile checkPlayerOPotentialWin(BoardStateSpace workingStateSpace){

        for(int row = 0; row < 4; row++){
            for(int col = 0; col < 4; col++){
                
                //2 Left
                if(col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&     
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col-1].tileMark) && 
                       workingStateSpace.board[row][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row][col-2];
                    }
                }
                //2 Right
                if(col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row][col+1].tileMark) &&
                       workingStateSpace.board[row][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row][col+2];
                    }
                }


                //2 Up
                if(row-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col].tileMark)&&
                       workingStateSpace.board[row-2][col].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col];
                    }
                }

                //2 Down
                if(row+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col].tileMark)&&
                       workingStateSpace.board[row+2][col].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col];
                    }
                }


                //2 Diagonal Up-Left
                if(row-2>=0 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col-1].tileMark)&&
                       workingStateSpace.board[row-2][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col-2];
                    }    
                }

                //2 Diagonal Up-Right
                if(row-2>=0 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row-1][col+1].tileMark)&&
                       workingStateSpace.board[row-2][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row-2][col+2];
                    }
                }

                //2 Diagonal Down-Left
                if(row+2<4 && col-2>=0){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col-1].tileMark)&&
                       workingStateSpace.board[row+2][col-2].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col-2];
                    }
                }

                //2 Diagonal Down-Right
                if(row+2<4 && col+2<4){
                    if(workingStateSpace.board[row][col].tileMark.equals("O") &&
                       workingStateSpace.board[row][col].tileMark.equals(workingStateSpace.board[row+1][col+1].tileMark)&&
                       workingStateSpace.board[row+2][col+2].tileMark.equals("empty")){
                        return workingStateSpace.board[row+2][col+2];
                    }
                }
   

            }
        }
        return null;     
    }
}
