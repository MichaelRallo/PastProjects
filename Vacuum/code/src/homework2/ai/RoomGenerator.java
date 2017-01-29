/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package homework2.ai;

/**
 *
 * @author Mike
 */
public class RoomGenerator {
 
    
    public RoomGenerator(){}
    
    public void createRooms(Room[][] rooms){
        int rows = rooms.length;
        int columns = rooms[0].length;
        
        //Create Rooms
        for(int i = 0; i < rows; i++){
            for(int j = 0; j < columns; j++){
                rooms[i][j] = new Room(i,j);
            }
        }        
        
        if(rows == 4){
            //Place Initial Dirt
            rooms[0][1].setDirty(true);
            rooms[0][3].setDirty(true);
            rooms[1][1].setDirty(true);
            rooms[1][2].setDirty(true);
            rooms[2][0].setDirty(true);
            rooms[3][1].setDirty(true);
            rooms[3][3].setDirty(true);

            //Set Initial Vacuum
            rooms[2][1].setHasVacuum(true);  
        }
        
        else if(rows == 5){
            rooms[0][1].setDirty(true);
            rooms[0][3].setDirty(true);
            rooms[0][5].setDirty(true);
            rooms[1][0].setDirty(true);
            rooms[1][2].setDirty(true);
            rooms[1][3].setDirty(true);
            rooms[2][0].setDirty(true);
            rooms[2][4].setDirty(true); 
            rooms[2][5].setDirty(true); 
            rooms[3][1].setDirty(true); 
            rooms[3][3].setDirty(true);
            rooms[4][2].setDirty(true);
            rooms[4][3].setDirty(true);
            rooms[4][5].setDirty(true);
            
            
            rooms[2][1].setHasVacuum(true); 
            
        }
        else{
            System.out.println("ERROR: Invalid Room Default Size");
        }
    }
    
    
    
}
