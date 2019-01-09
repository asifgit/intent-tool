/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ibnapplication;
// Java Program to demonstrate adjacency list  
// representation of graphs 
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
public class GFG {
    static int availableId=0;                            //Represents the available id for mapping
    static HashMap<String,Integer> mapping;              //To store the String-Integer mapping for Vertexes
    static ArrayList<ArrayList<Integer>> adjacencyList;
    static int arch_ID;
       
    // Driver program to test above functions 
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args)throws ClassNotFoundException{
        
       
     Connection conn = null;
     
        String driver   = "com.mysql.jdbc.Driver";
        String db       = "vocabulary-store";
        String tz       = "serverTimezone=UTC";
        String url      = "jdbc:mysql://localhost/" + db + "?" + tz;
        String user     = "root";
        String pass     = "";

        try {
            Class.forName(driver);
            conn = DriverManager.getConnection(url,user,pass);
            System.out.println("Connected to database : " + db);
            //System.out.println("--conn--:"+conn);

            Statement stmt = null;
            String query = "" + 
                "SELECT " + 
                    "cont.`id` AS cont_id, cont.`name`, cont.`arch_id`, cont.`s_nssai`, cont.`uprate`, cont.`downrate`, cont.`unit`, " + 
                    "arch_sup.`description`, " + 
                    "mod_arch.`id` AS mod_id, mod_arch.`node_name`, " + 
                    "mod_rel.`relation_id`, " + 
                    "mod_arch2.`node_name` AS relation_node_name " + 
                "FROM `xontracts` AS cont " + 
                "INNER JOIN `architectures_supported` AS arch_sup " + 
                    "ON arch_sup.id=cont.arch_id " + 
                "INNER JOIN `modules_architecture` AS mod_arch " + 
                    "ON arch_sup.id=mod_arch.arch_id " + 
                "INNER JOIN `modules_relations` AS mod_rel " + 
                    "ON mod_arch.id=mod_rel.mod_id " + 
                "INNER JOIN `modules_architecture` AS mod_arch2 " + 
                    "ON mod_rel.relation_id=mod_arch2.id " + 
                "ORDER BY cont.id, mod_arch.id, mod_rel.relation_id "; 
            try {
                stmt = conn.createStatement();
                ResultSet rs = stmt.executeQuery(query);

                int ctr = 0;
                int ctr1=0;
                /**/
                adjacencyList = new ArrayList<ArrayList<Integer>>();
                mapping  = new HashMap<String,Integer>();

                String graphVertexes[] = {"UE","eNB","vMME","NSSF","vHSS","vSPGWC","vSPGWU"};

                for(String vertex : graphVertexes)
                {
                    addNewVertex(vertex);
                }
                System.out.println("cont_id" + ":" + "name" + "\t" + "mod_id" + ":" + "node_name" + "\t" + "relation_id" +"\t" + "arch_id" +"\t"+"\t" + "S_NSSAI" + "\n");
                   
         
                while (rs.next()) {

                    int cont_id = rs.getInt("cont_id");
                    String name = rs.getString("name");
                    int arch_id = rs.getInt("arch_id");
                    int s_nssai = rs.getInt("s_nssai");
                    int uprate = rs.getInt("uprate");
                    int downrate = rs.getInt("downrate");
                    String unit = rs.getString("unit");
                    int mod_id = rs.getInt("mod_id");
                    String node_name = rs.getString("node_name");
                    int relation_id = rs.getInt("relation_id");
                    String relation_node_name = rs.getString("relation_node_name");

                    addEdgeBetween(node_name, relation_node_name);

                    System.out.println(cont_id + ":" + name + "\t"+"\t" + mod_id + ":"+ "\t" + node_name + "\t"+ "\t" + relation_id +"\t"+"\t" + arch_id+ "\t"+"\t"+ s_nssai);
                    ++ctr;
                    arch_ID=arch_id;
                }
                 System.out.println();
                 

                printList();

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
        
        
        
        
        
        
    // Conflict Manager:: From here::
    //1:creating object
     Conflict_Manager c1= new Conflict_Manager();
     //calling for fecth sNSSAI:::  set no.of.Slices
     c1.Fetch_SNSSAI(arch_ID);
   System.out.print("ArchID"+" :" +c1.archID + "\t"+ "No Of Slices   "+ c1.no_of_slices +" :"+"\t"+ "SNSSAI"+ " :");
     c1.print_snssai(); 
     //seting required no_of instances::
     c1.set_required_instances();
      System.out.println("Required Instances"+" :" +c1.required_no_instances + "\t");
      System.out.println("Max  small Can be provisioned"+" :" +c1.max_small_instances() + "\t");
      System.out.println("Max  medium Can be provisioned"+" :" +c1.max_medium_instances() + "\t");
      System.out.println("Max  Large Can be provisioned"+" :" +c1.max_large_instances() + "\t");
      System.out.println("Image Size"+" :" +c1.set_image_size() + "\t");
      
      c1.print_QoS();
    } 

    private static void printList()
    {
        for(String vertex : mapping.keySet()) {
            int index = mapping.get(vertex);
            System.out.println("\n"+vertex+" Sequence #: "+index);
            System.out.println("\tList: "+adjacencyList.get(index));
        }
    }
    private static void addEdgeBetween(String vertex1, String vertex2) {
        //get both indexes
        int index1 = mapping.get(vertex1);
        int index2 = mapping.get(vertex2);

        //add index2 into the arraylist of index1 
        adjacencyList.get(index1).add(index2);
    }

    private static void addNewVertex(String vertex) {

        if(!mapping.containsKey(vertex))
        {  
            //assign available ID
            mapping.put(vertex,availableId);
            availableId++;                                   //make increment in available id
            adjacencyList.add(new ArrayList<Integer>());     //Add an Empty ArrayList
        }
        
    }
    
}
