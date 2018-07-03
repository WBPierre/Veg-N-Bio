
import java.io.FileNotFoundException;
import java.io.IOException;
import java.sql.SQLException;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;


public class Main {
    
    private static int menu;
    private static boolean databaseConnected = false;

    public static void main(String[] args) throws IOException{
        
        Scanner sc = new Scanner(System.in);
        Config config = new Config();
        DatabaseManager db = new DatabaseManager();
        Connection connection = new Connection();
        


        System.out.println("Bienvenue sur VEG-N-BIO Productor\n");
        
        do {
        
            System.out.println("********** Menu **********\n");
            System.out.println("1. Se connecter à l'interface\n2. Importer un fichier de config");
            menu = sc.nextInt();
            
            if(menu == 1 && databaseConnected == true){
                
                User user = connection.createForm();
                
                try {
                    Productor productor = connection.verifyCredentials(db,user);
                    if(productor != null){
                    
                        Profile profile = new Profile(productor);
                        profile.mainProfile(db);
                    }
                } catch (SQLException ex) {
                    Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
                }                              
            } 
            if(menu == 2 ){
               
                String path = config.addConfigFile();
                try {
                    config.readConfigFile(path);
                    databaseConnected = true;
                } catch (FileNotFoundException ex) {
                    Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
                }
                
                System.out.println("\nTentative de connexion à la base de données... \n");

                try {
                    db.connectToDB(
                            config.getLines().get(0),
                            config.getLines().get(1),
                            config.getLines().get(2)  
                    );
                } catch (SQLException ex) {
                    Logger.getLogger(Main.class.getName()).log(Level.SEVERE, null, ex);
                }                                                                               
            }                        
       } while ( menu != 3);
               
        
        
       
    }
    
}
