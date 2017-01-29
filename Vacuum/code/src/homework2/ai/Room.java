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
public class Room {
    
    private int positionRow;
    private int positionColumn;
    private boolean hasVacuum = false;
    private boolean dirty = false;
    private boolean visited = false;    

    //Constructor, Creates Room Object placing it's Coords
    public Room(int row, int column){
        this.setPositionRow(row);
        this.setPositionColumn(column);
        this.setHasVacuum(false);
        this.setDirty(false);
        this.setVisited(false);
    } 
    
    //Sets Position of Room's Row
    public void setPositionRow(int value){this.positionRow = value;}
    //Gets Position of Room's Row
    public int getPositionRow(){return this.positionRow;}
    //Sets Position of Room's Column
    public void setPositionColumn(int value){this.positionColumn = value;}
    //Gets Position of Room's Column
    public int getPositionColumn(){return this.positionColumn;}  
    //Sets Value of Vacuum
    public void setHasVacuum(boolean value){this.hasVacuum = value;}
    //Gets Value of Vacuum
    public boolean getHasVacuum(){return this.hasVacuum;}  
    //Sets Value of Dirty
    public void setDirty(boolean value){this.dirty = value;}
    //Gets Value of Dirty
    public boolean getDirty(){return this.dirty;} 
    //Sets Value of Visited
    public void setVisited(boolean value){this.visited = value;}
    //Gets Value of Visited
    public boolean getVisited(){return this.visited;} 
    
    //Clones a Room
    public Room cloneRoom(Room original){
        Room clonedRoom = new Room(original.getPositionRow(), original.getPositionColumn());
        clonedRoom.setHasVacuum(original.getHasVacuum());
        clonedRoom.setDirty(original.getDirty());
        clonedRoom.setVisited(original.getVisited());
        
        return clonedRoom;
    }

}
