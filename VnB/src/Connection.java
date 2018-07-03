
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Scanner;
import org.mindrot.jbcrypt.BCrypt;


public class Connection {
    
    private String email;
    private String password;
    
    public User createForm(){
        
        Scanner sc = new Scanner(System.in);
       
        System.out.println("Veuillez saisir votre adresse e-mail");
        email = sc.nextLine();
       
        System.out.println("Veuillez saisir votre mot de passe");
        password = sc.nextLine();
        
        User user = new User(email, password);
        
        return user;
    }
    
    public Productor verifyCredentials(DatabaseManager db, User user) throws SQLException{
        
        String email = user.getEmail();
        String password = user.getPassword();
        ResultSet result = null;
       
        result = db.selectAll("SELECT * FROM vnb_users");

        while(result.next())
        {                
            if(result.getString(5).equals(email)) {
                
                if(checkPassword(password, result.getString(6))){
                    Productor productor = new Productor(
                            result.getInt(1), 
                            result.getString(2), 
                            result.getString(3), 
                            result.getString(8).charAt(0), 
                            result.getString(5), 
                            result.getString(6)
                    );
                    return productor;
                }
             
            }                               
        }        
        return null;      
    }
    
    public boolean checkPassword(String password, String password_hash) {
                
        boolean password_verified = false;
        
        password_verified = BCrypt.checkpw(password, password_hash);

        return(password_verified);
    }
    
    
   
    
}
