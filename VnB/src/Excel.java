

import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.IOException;
import java.io.InputStream;
import java.util.ArrayList;
import org.apache.poi.xssf.usermodel.XSSFCell;
import org.apache.poi.xssf.usermodel.XSSFRow;
import org.apache.poi.xssf.usermodel.XSSFSheet;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;

public class Excel {
    
    private String path;
    private ArrayList<Product> products = new ArrayList<>();

    
    public Excel(String path){
        this.path = path;  
        this.products = new ArrayList<>();

    }
    
    public ArrayList<Product> readFile() throws FileNotFoundException, IOException{
        
        InputStream ExcelFileToRead = new FileInputStream(path);
        XSSFWorkbook  wb = new XSSFWorkbook(ExcelFileToRead);
        XSSFSheet sheet = wb.getSheetAt(0);
        XSSFRow row; 
        XSSFCell cell;

        int index = 2;
        row = sheet.getRow(index++);

        while(row != null){

            String productorLN = row.getCell(0).getStringCellValue();
            String productorFN = row.getCell(1).getStringCellValue();
            String name = row.getCell(2).getStringCellValue();
            String origin = row.getCell(3).getStringCellValue();
            double priceHT = row.getCell(4).getNumericCellValue();
            double priceTTC = row.getCell(5).getNumericCellValue();
            double quantity = row.getCell(6).getNumericCellValue();    
                        
            Product product = new Product(productorLN, productorFN, name, origin, priceHT, priceTTC, quantity);            
            products.add(product);
            
            row = sheet.getRow(index++);
            System.out.println(product);
        }      
        System.out.println("\nL'importation a réussie \n");
        
        return products;
    }   
        
}
