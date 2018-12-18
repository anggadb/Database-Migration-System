<?php
    session_start();
    if($_REQUEST['nm_tb'] == ''){
        echo "<script> alert('Anda belum memilih database untuk di convert'); window.location.href='../admin/home_admin.php'</script>";
    } else {
        $db = $_REQUEST['nm_tb'];
        $schema = $_SESSION['ora_schema'];
        $password = $_SESSION['ora_pwd'];
        $host = $_SESSION['ora_host'];
        $conn = oci_connect($schema,$password,$host);
        $query = oci_parse($conn, "SELECT * FROM ".$db);  
        $result = oci_execute($query);
        $jmkl = oci_num_fields($query);
        header('Content-Type: text/csv; charset=utf-8');  
        header('Content-Disposition: attachment; filename='.$db.'.csv');  
        $output = fopen("php://output", "w");
        for ($i=1; $i <= $jmkl; $i++) { 
            $array[$i] = oci_field_name($query, $i);
        }
        fputcsv($output, $array);  
        while($row = oci_fetch_array($query, OCI_ASSOC+OCI_RETURN_NULLS))  
        {  
            fputcsv($output, $row);  
        }  
        fclose($output);
    }  
?>