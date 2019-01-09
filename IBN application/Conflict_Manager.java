/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package ibnapplication;

import static ibnapplication.GFG.adjacencyList;
import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.SQLException;
import java.sql.Statement;
import java.sql.ResultSet;

import java.util.ArrayList;
import java.util.HashMap;

import java.util.LinkedList;

/**
 *
 * @author user
 */
public class Conflict_Manager{
    public static int archID;
    public static int []S_NSSAI = new int[8];
     public static int []UP_RATE = new int[8];
     public static int []DOWN_RATE = new int[8];
    public static int no_of_slices;
    public static String  image_size;
    public static int required_no_instances;
    public static int canProvide;
    public static int vCPU=16; //IF vCPU per CORE is 4
    public static int RAM=16; // RAM avaible in CiaB Compute Node
    
    
    
    
    //this function print s_nnssai
public static void print_snssai(){
    for(int i=0; i< no_of_slices;i++)
    {
            System.out.print(S_NSSAI[i] +" \t");
    }
    System.out.println();
} 

   //this function print QoS Per Contract and Slice
public static void print_QoS(){
    for(int i=0; i< no_of_slices;i++)
    {
            System.out.println("S_NSSAI : " + S_NSSAI[i]+"\t" + "DOWN_RATE : " + DOWN_RATE[i]+" \t" +"UP_RATE : " + UP_RATE[i] +" \t");
    }
    System.out.println();
} 



//this function will calculate to no.of required instances
public static void set_required_instances(){
required_no_instances=4+(2*no_of_slices);
}
public static int get_required_instances(){
return required_no_instances;
}
public static void print_required_instances(){
System.out.println("required No of Instances: "+required_no_instances+"\t" +"Where Required No of slices = "+ no_of_slices);
}






// max no of instances can be provisioned :: Small, Max , Min ::
public static int max_small_instances(){

    int cpu= vCPU/2;
    int ram= RAM/1;
    
    return min(cpu,ram);
}
public static int max_medium_instances(){

    int cpu= vCPU/4;
    int ram= RAM/2;
    
    return min(cpu,ram);
}
public static int max_large_instances(){

    int cpu= vCPU/6;
    int ram= RAM/3;
    
    return min(cpu,ram);
}
public static int min (int a, int b){
if(a<b){return a;}
else {return b;}
}




//decision making for selecting proper image size :::
public static String set_image_size(){
if(required_no_instances<=max_large_instances()){
image_size="LARGE";
return "LARGE";
}
else if(required_no_instances<=max_medium_instances()){
image_size="MEDIUM";
return "MEDIUM";
}
else if(required_no_instances<=max_small_instances()){
image_size="SMALL";
return "SMALL";
}
else
    slicesharing();
    image_size="SMALL";
      return "SMALL";  
}



//Slice Sharing resources
public static void slicesharing(){
int extra_instances= required_no_instances-max_small_instances();
int extraslices = extra_instances/2;

for(int i=0; i<extraslices; i++){
    S_NSSAI[i]=(S_NSSAI[i]*10)+(S_NSSAI[no_of_slices-1]); //merging formula for slices where unit digit will be last slice and ten didgit will be first slice similarly for third slice
    //merge(S_NSSAI[extraslices],S_NSSAI[i]);
    S_NSSAI[no_of_slices-1]= 0;
    no_of_slices--;   // this will decrement the total no of slices
    UP_RATE[i]=40;    //maximum because of sharing
    DOWN_RATE[i]=40;  // maximum because of sharing
    
}    
}



//This will Fetch how many S-NSSAI are Require and will set No Of required Slices
public static void Fetch_SNSSAI(int archid) throws ClassNotFoundException{    
    System.out.println("\n"+"\n"+"\n"+"\n"+"\n"+ "Starting Conflict Management");
    
    System.out.print("1234");
    archID=archid;
    Connection conn = null;
     
        String driver   = "com.mysql.jdbc.Driver";
        String db       = "vocabulary-store";
        String tz       = "serverTimezone=UTC";
        String url      = "jdbc:mysql://localhost/" + db + "?" + tz;
        String user     = "root";
        String pass     = "";

       try{
            Class.forName(driver);
            conn = DriverManager.getConnection(url,user,pass);
            System.out.println("Connected to database : " + db);
            //System.out.println("--conn--:"+conn);

            Statement stmt = null;
       
            String query = "" + 
                "SELECT `s_nssai` , `uprate` , `downrate`  FROM `xontracts` WHERE `arch_id` = 1"; 
                //+ "ORDER BY arch_iD, s-nssai "; 
            try {
                stmt = conn.createStatement();
                ResultSet rs = stmt.executeQuery(query);

               
                /**/
               // adjacencyList = new ArrayList<ArrayList<Integer>>();
                //mapping  = new HashMap<String,Integer>();

                
               // System.out.println("cont_id" + ":" + "name" + "\t" + "arch_id" +"\t"+"\t" + "S_NSSAI" + "\n");
                    int ctr=0;
                        
                while (rs.next()) {

                   // int cont_id = rs.getInt("cont_id");
                    //String name = rs.getString("name");
                    //int arch_id = rs.getInt("arch_id");
                    int s_nssai = rs.getInt("s_nssai");
                    int uprate = rs.getInt("uprate");
                    int downrate = rs.getInt("downrate");
                    
                    //System.out.println( "\t"+"\t"+ s_nssai);
                   // archID= arch_id;
                    S_NSSAI[ctr]= s_nssai;
                    UP_RATE[ctr]=uprate;
                    DOWN_RATE[ctr]=downrate;
                    ++ctr;
                }
                no_of_slices=ctr;
                 System.out.println();
                 
                

                //printList();

            } catch (SQLException e) {
                System.out.println("qry-SQLException: "+e.getMessage());
                System.out.println("qry-SQLState: "+e.getSQLState());
                System.out.println("qry-VendorError: "+e.getErrorCode());
            } finally {
                if (stmt != null) { 
                    stmt.close(); 
                }
            }
        } catch (SQLException e) {
            System.out.println("conn-SQLException: "+e.getMessage());
            System.out.println("conn-SQLState: "+e.getSQLState());
            System.out.println("conn-VendorError: "+e.getErrorCode());
        }
    } 
}
