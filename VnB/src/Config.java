
import java.io.BufferedReader;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.util.ArrayList;
import java.util.NoSuchElementException;
import java.util.Scanner;


public class Config {
    
    private ArrayList<String> lines = new ArrayList <String>();
    Scanner sc = new Scanner(System.in);
    private String path;
    
    public Config(){
        this.lines = new ArrayList<String>();
    }

    public ArrayList<String> getLines() {
        return lines;
    }
      
    public String addConfigFile(){
        
        System.out.println("Veuillez saisir le chemin du fichier de config");
        path  = sc.nextLine();
        
        return path;
    }
    
    public void readConfigFile(String path) throws FileNotFoundException{
        
        try {
            
            File f = new File (path);
            Scanner scanner = new Scanner (f);

            String address;
            String login;
            String password;
 
            while (true)
            {
                try
                {
                    address = scanner.nextLine();
                    lines.add(address);
                    
                    login = scanner.nextLine();
                    lines.add(login);

                    password = scanner.nextLine();
                    lines.add(password);  
                }
                catch (NoSuchElementException exception)
                {
                    break;
                }
            }
            scanner.close();
        }
        catch (FileNotFoundException exception)
        {
            System.out.println ("Le fichier n'a pas été trouvé");
        }
    }
    
}
