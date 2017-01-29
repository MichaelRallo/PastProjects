/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package homework2.ai;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

/**
 *
 * @author Mike
 */
public class AlgorithmIDS {
    
    int nodeCounter = 0;
    public AlgorithmIDS(){/*Constructor*/}

    public StateSpace IterateIDS(StateSpace workingStateSpace){
        
        
        //Create Our Fringe
        List<StateSpace> fringe = new ArrayList<StateSpace>();
        //Add First Node to Fringe
        fringe.add(workingStateSpace);
        
        //While Rooms are Not all Cleaned
        while(workingStateSpace.getDirtyRoomCount() != 0){
            System.out.println("Working Node Number: " + nodeCounter++);
            
            
            //Pop Off the FIRST Node from Fridnge
            workingStateSpace = fringe.get(0);
            fringe.remove(0);
            
            //Print off Current Node
            workingStateSpace.printCurrentRoomLocation();
            
            //Expand Node's Children
            workingStateSpace.generateChildren();
            
            //Add Up Child to the Fringe
            if(workingStateSpace.getChildren().get("upChild") != null){
                fringe.add(workingStateSpace.getChildren().get("upChild"));
            }
            //Add Left Child to the Fringe
            if(workingStateSpace.getChildren().get("leftChild") != null){
                fringe.add(workingStateSpace.getChildren().get("leftChild"));
            }
            //Add Clean Child to the Fringe
            if(workingStateSpace.getChildren().get("cleanChild") != null){
                fringe.add(workingStateSpace.getChildren().get("cleanChild"));
            }
            //Add Right Child to the Fringe
            if(workingStateSpace.getChildren().get("rightChild") != null){
                fringe.add(workingStateSpace.getChildren().get("rightChild"));
            }
            //Add Down Child to the Fringe
            if(workingStateSpace.getChildren().get("downChild") != null){
                fringe.add(workingStateSpace.getChildren().get("downChild"));
            }
 
        }
  
        //Return The Final StateSpace (Which should be have 0 Dirty Rooms)
        System.out.println("Number of Nodes Expanded: " + nodeCounter);
        return workingStateSpace;

    }
}
