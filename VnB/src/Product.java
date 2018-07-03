
public class Product {
    
    private String productorLN;
    private String productorFN;
    private String name;
    private String origin;
    private double priceHT;
    private double priceTTC;
    private double quantity;


    
    
    
    Product(String productorLN, String productorFN, String name, String origin, double priceHT, double priceTTC, double quantity){
        this.productorLN = productorLN;
        this.productorFN = productorFN;
        this.name = name;
        this.origin = origin;
        this.priceHT = priceHT;
        this.priceTTC = priceTTC;
        this.quantity = quantity;
    }

    public String getProductorLN() {
        return productorLN;
    }

    public String getProductorFN() {
        return productorFN;
    }

    public String getName() {
        return name;
    }

    public String getOrigin() {
        return origin;
    }

    public double getPriceHT() {
        return priceHT;
    }

    public double getPriceTTC() {
        return priceTTC;
    }
    
    public double getQuantity() {
        return quantity;
    }
    
    @Override
    public String toString() {
        return "Product{" + "productorLN=" + productorLN + ", productorFN=" + productorFN + ", name=" + name + ", origin=" + origin + ", priceHT=" + priceHT + ", priceTTC=" + priceTTC + '}';
    }      
}
