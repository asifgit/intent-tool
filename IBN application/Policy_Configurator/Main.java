/* Replaces all tags related to [nodename] in TOSCA configuration templates


 */

import java.io.*;
import java.nio.charset.Charset;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardOpenOption;
import java.util.*;

public class Main {
    /*Function that finds a TAG in a file and replaces with specific TEXT, then appends text to new file*/
    static void replaceTag(String filename, String tag, String nodename, String toFileName) throws IOException {
        Path path = Paths.get(filename);
        Path toPath = Paths.get(toFileName);
        Charset charset = Charset.forName("UTF-8");
        Integer marker = 0;
        try(BufferedWriter writer =
                    Files.newBufferedWriter(toPath, charset, StandardOpenOption.APPEND)) {
            Scanner scanner =  new Scanner(path, charset.name());
            String line;
            while (scanner.hasNextLine()){
                line = scanner.nextLine();
                if (line.contains(tag.toLowerCase())) {
                    line = line.replaceAll(tag, nodename.toLowerCase());
                    writer.write(line);
                    writer.newLine();
                    marker = 1;
                }
                else if (line.contains(tag.toUpperCase()) || marker == 1) {
                    line = line.replaceAll(tag.toUpperCase(), nodename);
                    writer.write(line);
                    writer.newLine();
                    marker = 1;
                }
            }
            scanner.close();
            writer.close();

        }catch (Exception e) {
            BufferedWriter writer =
                    Files.newBufferedWriter(toPath, charset);
            Scanner scanner =  new Scanner(path, charset.name());
            String line;
            while (scanner.hasNextLine()){
                line = scanner.nextLine();
                if (line.contains(tag.toLowerCase())) {
                    line = line.replaceAll(tag, nodename.toLowerCase());
                    writer.write(line);
                    writer.newLine();
                }
                else if (line.contains(tag.toUpperCase())|| marker == 0) {
                    line = line.replaceAll(tag.toUpperCase(), nodename);
                    writer.write(line);
                    writer.newLine();

                }

            }
            scanner.close();
            writer.close();
        }

    }
    static void copyToFile(String file, String toFile) throws IOException {
        Path path = Paths.get(file);
        Path toPath = Paths.get(toFile);
        Charset charset = Charset.forName("UTF-8");
        BufferedWriter writer = Files.newBufferedWriter(toPath, charset, StandardOpenOption.CREATE, StandardOpenOption.APPEND);
        Scanner scanner = new Scanner(path, charset);
        String line;
        while (scanner.hasNextLine()){
            line = scanner.nextLine();
            writer.write(line);
            writer.newLine();

        }
        scanner.close();
        writer.close();

    }

    static void defineIP(String tag){






    }
    public static void main(String[] args) throws IOException {
       List<String> nodes = new ArrayList<String>();
       //add nodes for test
        nodes.add("eNB");
        nodes.add("vMME");
        nodes.add("NSSF");
        nodes.add("vHSS");
        nodes.add("SPGWC");
        nodes.add("SPGWU");

        /*Service Graph TOSCA File Templates for SERVICE GRAPH */
        List<String> templateList = new ArrayList<String>();
        // add 3 templates in order.
        templateList.add("imports");
        templateList.add("services");
        templateList.add("dependencies");

        /*Service Graph TOSCA File Templates for Networks */
        List<String> templateList2 = new ArrayList<String>();
        // add 3 templates in order.
        templateList2.add("addressmanager");
        templateList2.add("serviceaddresses");
        templateList2.add("privatenetworks");

        /*Service Graph TOSCA File Templates for Service Instances */
        List<String> templateList3 = new ArrayList<String>();
        // add 3 templates in order.
        templateList3.add("importsservices");
        templateList3.add("servicenetworks");
        templateList3.add("serviceclass");
        templateList3.add("serviceslice");
        templateList3.add("privateslice");
        templateList3.add("managementslice");
        templateList3.add("serviceinstances");

        /*List of Config Files to be appended into a FINAL TOSCA FILE for SERVICE GRAPH*/
        List<String> TOSCAList = new ArrayList<String>();
        // add 4 templates in order.
        TOSCAList.add("C:\\Users\\user\\Documents\\mcord-oai-service-graph.yml.j2");
        TOSCAList.add("C:\\Users\\user\\Documents\\imports2.txt");
        TOSCAList.add("C:\\Users\\user\\Documents\\services2.txt");
        TOSCAList.add("C:\\Users\\user\\Documents\\dependencies2.txt");

        /*List of Config Files to be appended into a FINAL TOSCA FILE  for NETWORKS*/
        List<String> TOSCAList2 = new ArrayList<String>();
        // add 4 templates in order.
        TOSCAList2.add("C:\\Users\\user\\Documents\\oai-net.yaml.j2");
        TOSCAList2.add("C:\\Users\\user\\Documents\\addressmanager2.txt");
        TOSCAList2.add("C:\\Users\\user\\Documents\\serviceaddresses2.txt");
        TOSCAList2.add("C:\\Users\\user\\Documents\\privatenetworks2.txt");
        TOSCAList2.add("C:\\Users\\user\\Documents\\ender.txt");

        /*List of Config Files to be appended into a FINAL TOSCA FILE  for SERVICE INSTANCES*/

        List<String> TOSCAList3 = new ArrayList<String>();
        // add 4 templates in order.
        TOSCAList3.add("C:\\Users\\user\\Documents\\mcord-oai-services.yml.j2");
        TOSCAList3.add("C:\\Users\\user\\Documents\\importsservices2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\servicenetworks2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\serviceclass2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\serviceslice2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\privateslice2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\managementslice2.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\publicslice.txt");
        TOSCAList3.add("C:\\Users\\user\\Documents\\serviceinstances2.txt");


        /*Creates proper sections of SERVICE GRAPH TOSCA*/

        for (String temp : templateList){
            for (String n : nodes) {
                // Replaces tags in files and creates new template files with node information
                replaceTag("C:\\Users\\user\\Documents\\"+ temp +".txt",
                        "%nodename%", n,
                        "C:\\Users\\user\\Documents\\" + temp + "2.txt");
            }

        }

        /*APPENDS sections into FINAL TOSCA file*/
        for (String temp : TOSCAList) {
            copyToFile( temp, "C:\\Users\\user\\Documents\\TOSCAFILE.yml.j2" );
        }

        /*Creates proper sections of Networks*/
        for (String temp : templateList2){
            for (String n : nodes) {
                // Replaces tags in files and creates new template files with node information
                replaceTag("C:\\Users\\user\\Documents\\"+ temp +".txt",
                        "%nodename%", n,
                        "C:\\Users\\user\\Documents\\" + temp + "2.txt");
            }

        }

        /*APPENDS sections into FINAL TOSCA file*/

        for (String temp : TOSCAList2) {
            copyToFile( temp, "C:\\Users\\user\\Documents\\TOSCAFILE2.yml.j2" );
        }

        /*Creates proper sections of SERVICE INSTANCES*/
        for (String temp : templateList3){
            for (String n : nodes) {
                // Replaces tags in files and creates new template files with node information
                replaceTag("C:\\Users\\user\\Documents\\"+ temp +".txt",
                        "%nodename%", n,
                        "C:\\Users\\user\\Documents\\" + temp + "2.txt");
            }

        }
        /*APPENDS sections into FINAL TOSCA file*/

        for (String temp : TOSCAList3) {
            copyToFile( temp, "C:\\Users\\user\\Documents\\TOSCAFILE3.yml.j2" );
        }
    }
}
