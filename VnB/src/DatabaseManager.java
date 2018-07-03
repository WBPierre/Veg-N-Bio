
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;

/**
 *
 * @author tluong
 */

public class DatabaseManager {
        
    
    java.sql.Connection connect  = null;
    ResultSet rs = null;
    Statement  statement;
    
    private String address;
    private String login;
    private String password;

    public DatabaseManager() {

    }
    
    public void connectToDB(String address, String login, String password) throws SQLException {
        this.connect = DriverManager.getConnection("jdbc:mysql://"+ address + "?useUnicode=true&useJDBCCompliantTimezoneShift=true&useLegacyDatetimeCode=false&serverTimezone=UTC", login, password);
        this.statement = (Statement)connect.createStatement();
        System.out.println("La connexion a réussie \n");
    }
    

    
    
  
    public ResultSet selectAll(String request) throws SQLException{
               
        rs = this.statement.executeQuery(request);
        
        return rs;
    }
    
    public void insertProductDB(Productor productor, ArrayList<Product> products) throws SQLException{
        

        
        for(int i = 0; i < products.size(); i++){

            PreparedStatement preparedStmt = connect.prepareStatement("INSERT INTO vnb_offers(id_producer, name, quantity, priceHT, priceTTC, state)"
            + "VALUES (?, ?, ?, ?, ?, ?)");

            preparedStmt.setInt (1, productor.getId());
            preparedStmt.setString(2, products.get(i).getName());   
            preparedStmt.setDouble(3, products.get(i).getQuantity());
            preparedStmt.setDouble(4, products.get(i).getPriceHT());
            preparedStmt.setDouble(5, products.get(i).getPriceTTC());
            preparedStmt.setInt(6, 0);

            // execute the preparedstatement
            preparedStmt.execute();

            
        }
        System.out.println("\nSuccès de l'enregistrement\n");
        
    }
}

