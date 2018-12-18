<?PHP
  session_start();
  if($_REQUEST['nm_tb'] == ''){
        echo "<script> alert('Anda belum memilih database untuk di convert'); window.location.href='../admin/home_admin.php'</script>";
  } else {
  $schema = $_SESSION['ora_schema'];
  $password = $_SESSION['ora_pwd'];
  $host = $_SESSION['host'];
  $con = oci_connect($schema,$password,$host);
  $db = $_REQUEST['nm_tb'];
  function cleanData(&$str)
  {
    $str = preg_replace("/\t/", "\\t", $str);
    $str = preg_replace("/\r?\n/", "\\n", $str);
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }
  $filename = $db.".xls";
  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: application/vnd.ms-excel");

  $flag = false;
  $result = oci_parse($con, "SELECT * FROM ".$db);
  oci_execute($result);
  while(false !== ($row = oci_fetch_array($result, OCI_ASSOC + OCI_RETURN_NULLS))) {
    if(!$flag) {
      // display field/column names as first row
      echo implode("\t", array_keys($row)) . "\r\n";
      $flag = true;
    }
    array_walk($row, __NAMESPACE__ . '\cleanData');
    echo implode("\t", array_values($row)) . "\r\n";
  }
  exit;
}
?>