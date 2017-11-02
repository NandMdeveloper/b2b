<?php

  //Had to change this path to point to IOFactory.php.
  //Do not change the contents of the PHPExcel-1.8 folder at all.
 date_default_timezone_set('UTC');
  require_once dirname(__FILE__) . '\PHPExcel.php';
  require_once dirname(__FILE__) . '\lib/conecciones.php';
  require_once dirname(__FILE__) . '\lib/class/comision.class.php';

  //Use whatever path to an Excel file you need.
  $inputFileName = 'saldonn.xlsx';

  try {
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($inputFileName);
  } catch (Exception $e) {
    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . 
        $e->getMessage());
  }

  $sheet = $objPHPExcel->getSheet(0);
  $highestRow = $sheet->getHighestRow();
  $highestColumn = $sheet->getHighestColumn();
?>
<table width="100%" border="1"> 


<?php    
  for ($row = 1; $row <= $highestRow; $row++) { 
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, 
                                    null, true, false);

    //Prints out data in each row.
    //Replace this with whatever you want to do with the data.
   
    $documento = $rowData[0][0];
    $emision = $rowData[0][1];
    $vencido = $rowData[0][2];

    $despacho = $rowData[0][3];
    $recepcion = $rowData[0][4];
    $nvencido = $rowData[0][5];

    $cobro = $rowData[0][6];
    $cneg = $rowData[0][7];
    $dias_calles = $rowData[0][8];

    $co_cli = $rowData[0][9];
    $cli_des = addslashes($rowData[0][10]);
    $co_ven = $rowData[0][11];

    $ven_des = addslashes($rowData[0][12]);
    $base = $rowData[0][13];
    $iva = $rowData[0][14];

    $neto = $rowData[0][15];
    $saldo = $rowData[0][16];

    $tipo = "fact";
    $relacion = "";

    if(is_float($rowData[0][1])){
     $emision = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1]));
    }
    if(is_float($rowData[0][2])){
     $vencido = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][2]));
    }
    if(is_float($rowData[0][3])){
     $despacho = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][3]));
    }
  
    if(is_float($rowData[0][4])){
     $recepcion = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][4]));
    }
    if(is_float($rowData[0][5])){
     $nvencido = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][5],false));
    }
    if(is_float($rowData[0][6])){
     $cobro = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][6],false));
    }
      $f = "";
      if (strpos($emision, "/")) {        
         $f = explode( "/", $emision);
         $emision = $f[2]."-".$f[1]."-".$f[0];
      }

      if (strpos($vencido, "/")) {        
         $f = explode( "/", $vencido);
         $vencido = $f[2]."-".$f[1]."-".$f[0];
      }
      if (strpos($despacho, "/")) {        
         $f = explode( "/", $despacho);
         $despacho = $f[2]."-".$f[1]."-".$f[0];
      }

      if (strpos($recepcion, "/")) {        
         $f = explode( "/", $recepcion);
         $recepcion = $f[2]."-".$f[1]."-".$f[0];
      }
      if (strpos($nvencido, "/")) {        
         $f = explode( "/", $nvencido);
         $nvencido = $f[2]."-".$f[1]."-".$f[0];
      }
      if (strpos($cobro, "/")) {        
         $f = explode( "/", $cobro);
         $cobro = $f[2]."-".$f[1]."-".$f[0];
      }

      if (strpos($emision, "ch") or strpos($emision, "CH") ) {        
         $tipo = "cheque";
         $relacion = $vencido;
      }
      if (strpos($emision, "nc") or strpos($emision, "NC")) {        
         $tipo = "ncr";
         $relacion = $vencido;
      }
    $comision = new comision();
     

         $conn = $comision->getConMYSQL();

        $sel="
      INSERT INTO 
    `cmssaldo`(`id`,
             `documento`,
              `emision`,
               `vencimiento`,
                `despacho`,
                 `recepcion`,
                  `nvencimiento`,
                   `cobro`,
                    `nego`,
                     `diascalle`,
                      `co_cli`,
                       `cli_des`,
                        `co_ven`,
                         `ven_des`,
                          `base`,
                           `iva`,
                            `neto`,
                             `saldo`,
                              `estatus`,tipodoc,relacion)
                                 VALUES (
                                 null,
                                 '".$documento."',
                                 '".$emision."',
                                 '".$vencido."',
                                 '".$despacho."',
                                 '".$recepcion."',
                                 '".$nvencido."',
                                 '".$cobro."',
                                 '".$cneg."',
                                 '".$dias_calles."',
                                 '".$co_cli."',
                                 '".$cli_des."',
                                 '".$co_ven."',
                                 '".$ven_des."',
                                 '".$base."',
                                 '".$iva."',
                                 '".$neto."',
                                 '".$saldo."',
                                 'activo',
                                 '".$tipo."',
                                 '".$relacion."'
                               )";
        //$rs = mysqli_query($conn,$sel) or die(mysqli_error($conn));     

   

    ?>
    <tr>
      <td><?php echo $row; ?></td>
      <td><?php echo $emision." ".$tipo; ?></td>
      <td><?php echo $vencido; ?></td>

      <td><?php echo $despacho; ?></td>
      <td><?php echo $recepcion; ?></td>
      <td><?php echo $nvencido; ?></td>

      <td><?php echo $rowData[0][6]; ?></td>
      <td><?php echo $rowData[0][7]; ?></td>
      <td><?php echo $rowData[0][8]; ?></td>
      <td><?php echo $rowData[0][9]; ?></td>
      <td><?php echo $rowData[0][13]; ?></td>
      <td><?php echo $rowData[0][14]; ?></td>
      <td><?php echo $rowData[0][15]; ?></td>
      <td><?php echo $rowData[0][16]; ?></td>
    </tr>
<?php
    
   
  }
  ?>
</table>