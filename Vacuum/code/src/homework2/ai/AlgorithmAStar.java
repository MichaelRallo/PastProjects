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
public class AlgorithmAStar {
    
    int nodeCounter = 0;
    public AlgorithmAStar(){/*Default Constructor*/}
    
    public StateSpace IterationAStar(StateSpace workingStateSpace){
     
        //Create Our Fringe
        List<StateSpace> fringe = new ArrayList<StateSpace>();
        //Add First Node to Fringe
        fringe.add(workingStateSpace);
        
        //While Rooms are Not all Cleaned
        while(workingStateSpace.getDirtyRoomCount() != 0){
            System.out.println("Working Node Number: " + nodeCounter++);
            
            //Get Lowest Cost Node from Fringe
            workingStateSpace = getLowestCost(fringe);
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

    //Returns Lowest Cost Node in a Fringe
    public StateSpace getLowestCost(List<StateSpace> fringe){
        
        //Our Heuristic Values were calculated based off the Manhatten Distance + Number of Dirty Rooms.
        StateSpace lowestCostStateSpace;
        lowestCostStateSpace = fringe.get(0);
        int lowestCostIndex = 0;
        
        //Loops Through Fringe
        for(int i = 0; i < fringe.size(); i++) {
            //Find Lowest and Set it.
            if((lowestCostStateSpace.getScore() +  lowestCostStateSpace.getDirtyRoomCount()) > (fringe.get(i).getScore() + fringe.get(i).getDirtyRoomCount())){
                lowestCostStateSpace = fringe.get(i);
                lowestCostIndex = i;
            }
        } 
        
        //Return the Lowest
        fringe.remove(lowestCostIndex);
        return lowestCostStateSpace;
    }
    


}
