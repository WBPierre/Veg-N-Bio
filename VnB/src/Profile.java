
import java.io.IOException;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;


public class Profile {
    
    Scanner sc = new Scanner(System.in);
    Productor productor;
    ArrayList<Product> products;
    
    private int menu;
    
    public Profile(Productor productor){
        this.productor = productor;
    }
    
    public void mainProfile(DatabaseManager db) throws IOException, SQLException{
                
        System.out.println("\nBienvenue dans votre espace Personnel\n");

        do {
        
            System.out.println("********** Menu **********\n");
            System.out.println("1. Importer un fichier\n2. Envoyer le fichier à Veg-n-Bio\n3. Se déconnecter\n");
            
            menu = sc.nextInt();
            
            if(menu == 1){
                
                String path;
                
                System.out.println("\nVeuillez saisir le chemin du fichier Excel : ");
                path = sc.next();
                Excel excel = new Excel(path);
                products = excel.readFile();     
            } 
            if(menu == 2){             
                db.insertProductDB(productor, products);                         
            }
            
        } while(menu != 3);
    }
    
}
