/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package homework2.ai;

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author Mike
 */
public class AlgorithmDFGS {
    
    int nodeCounter = 0;
    public AlgorithmDFGS(){/*Default Constructor*/}
 
    //Returns The Goal State if Found, Null Otherwise
    public StateSpace IterationDFGS(StateSpace workingStateSpace){
        //Create Our Fringe
        List<StateSpace> fringe = new ArrayList<StateSpace>();
        //Add First Node to Fringe
        fringe.add(workingStateSpace);
        
        //While Rooms are Not all Cleaned
        while(workingStateSpace.getDirtyRoomCount() != 0){
            System.out.println("Working Node Number: " + nodeCounter++);
            
            //Pop Off the LAST Node from Fridnge
            workingStateSpace = fringe.get(fringe.size()-1);
            fringe.remove(fringe.size()-1);
            
            //Print off Current Node
            workingStateSpace.printCurrentRoomLocation();
            
            //Expand Node's Children
            workingStateSpace.generateChildren();
            
            //ADD NODES TO FRINGE WITH PRIORITY UP, LEFT, CLEAN, RIGHT, DOWN -> We push DOWN, RIGHT, CLEAN, LEFT, and then UP 
            //So That when we take last from our Queue, it grabs UP, then LEFT... etc.
            
            //Add Down Child to the Fringe
            if(workingStateSpace.getChildren().get("downChild") != null){
                fringe.add(workingStateSpace.getChildren().get("downChild"));
            }
            //Add Right Child to the Fringe
            if(workingStateSpace.getChildren().get("rightChild") != null){
                fringe.add(workingStateSpace.getChildren().get("rightChild"));
            }
            //Add Clean Child to the Fringe
            if(workingStateSpace.getChildren().get("cleanChild") != null){
                fringe.add(workingStateSpace.getChildren().get("cleanChild"));
            }
            //Add Left Child to the Fringe
            if(workingStateSpace.getChildren().get("leftChild") != null){
                fringe.add(workingStateSpace.getChildren().get("leftChild"));
            }
            //Add Up Child to the Fringe
            if(workingStateSpace.getChildren().get("upChild") != null){
                fringe.add(workingStateSpace.getChildren().get("upChild"));
            }
 
        }
  
        //Return The Final StateSpace (Which should be have 0 Dirty Rooms)
        System.out.println("Number of Nodes Expanded: " + nodeCounter);
        return workingStateSpace;

    }        


}
