//Michael Rallo msr5zb 12358133
package level;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.io.UnsupportedEncodingException;

public class ProcessFile
{
    private int highScore = 0;

    public int processFile(File file)
    {           
        //If No File For HighScores For Level Exists... Make it
        if (file == null || !file.exists()) 
        {
            System.out.println("Making File...");
            PrintWriter writer = null;
            try {
                writer = new PrintWriter(file.toString(), "UTF-8");
                //Default Score To 0
                writer.println("0");
                //Close Write
                writer.close();
            } catch (FileNotFoundException ex) {
            System.out.println("File Not Found...");
            } catch (UnsupportedEncodingException ex) {
            System.out.println("Not A Valid File...");                        
            } 
        }

        else
        {
            //Read In HighScore
            try {   System.out.println("Processing File...");
                    readFile(file);
            } catch (IOException e) {
                    System.out.println("IOException when reading file");
                    e.printStackTrace();
                    return 0;
            }
        }

        return highScore;
    }

    private void readFile(File file) throws IOException 
    {	
        BufferedReader br = new BufferedReader(new FileReader(file));

        String line = null;
        while ((line = br.readLine()) != null)
        { 	//Grab data line by line from file
                //Throw details into parser
                highScoreParser(line);

        }
        
        //Close File Reader
        br.close();
    }
    
    //Parse File To Grab HighScore
    private void highScoreParser(String line) 
    {   
        line = line.trim();
        this.highScore = Integer.parseInt(line);

    }

    //Used To Set/Create File For New HighScore
    public void setNewHighScore(int newHighScore, File file)
    {
        System.out.println("Making File...");
        PrintWriter writer = null;
        try {
            writer = new PrintWriter(file.toString(), "UTF-8");
            writer.println(newHighScore);
            writer.close();
        } catch (FileNotFoundException ex) {
        System.out.println("File Not Found...");
        } catch (UnsupportedEncodingException ex) {
        System.out.println("File Type Not Supported...");                        
        }  
    }
}
