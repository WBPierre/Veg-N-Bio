public class Productor extends User {
    

     private int id;
     private String name;
     private String firstname;
     private char phone;

    public Productor(int id, String name, String firstname, char phone, String email, String password) {
        super(email, password);
        this.id = id;
        this.name = name;
        this.firstname = firstname;
        this.phone = phone;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public String getFirstname() {
        return firstname;
    }

    public char getPhone() {
        return phone;
    }

    @Override
    public String toString() {
        return "Productor{" + "id=" + id + ", name=" + name + ", firstname=" + firstname + ", phone=" + phone + '}';
    }
    
    
    
    
     
    

}
