<?php
 echo "<br>getdataerplocalERPPSTMsaArticulo<br>";
$withup="";
//$server = "192.168.0.121";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$server = "192.168.0.10";//LOCAL TEODORA SOFTWARE C.A. RED PRO-HOME
$options = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");

$conn = sqlsrv_connect($server, $options);
if ($conn === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "Conectado a Sql Server 2014 ok <br>";
//sqlsrv_close($conn);	
$sql = "	SELECT   RTRIM(LTRIM(tsa.co_art)) AS co_art , CONVERT (NVARCHAR(100), tsa.fecha_reg) AS fecha_reg, tsa.art_des, tsa.tipo, tsa.anulado, tsa.co_lin, tsa.co_subl, tsa.co_cat, tsa.co_color, tsa.co_ubicacion, tsa.cod_proc, 
			tsa.item, tsa.modelo, tsa.ref, tsa.comentario, tsa.campo1, tsa.campo2, tsa.campo3, tsa.campo4, tsa.campo5, tsa.campo6, 
			tsa.campo7, tsa.campo8, 1 AS PSStatusSinc, 
			--tsc.co_precio, 
			ISNULL((SELECT top 1 RTRIM(LTRIM(tsc.co_precio)) FROM [ACCE].dbo.saArtPrecio tsc 
					WHERE tsa.co_art = tsc.co_art AND tsc.co_precio = 'P1'),'') AS co_precio,
			--tsc.monto, 
			--origi 202016111559 ISNULL((SELECT top 1 tsc.monto FROM [ACCE].dbo.saArtPrecio tsc WHERE tsa.co_art = tsc.co_art AND tsc.co_precio = 'P1'),0) AS monto,
			ISNULL((SELECT top 1 tsc.monto FROM [ACCE].dbo.saArtPrecio tsc WHERE tsa.co_art = tsc.co_art AND tsc.co_precio = 'P1' ORDER BY desde DESC ),0) AS monto,

			--tsd.stock, 
			--ISNULL((SELECT top 1 tsd.stock FROM [ACCE].dbo.saStockAlmacen tsd 	WHERE tsa.co_art = tsd.co_art AND tsd.co_alma = 'P1' AND tsd.tipo = 'ACT'),0) AS stock,

			(ISNULL((SELECT top 1 tsc.stock  FROM [ACCE].dbo.saStockAlmacen tsc WHERE tsa.co_art = tsc.co_art AND tsc.co_alma = 'P1' AND tsc.tipo = 'ACT'),0) - ISNULL((SELECT top 1 tsd.stock  FROM [ACCE].dbo.saStockAlmacen tsd WHERE tsa.co_art = tsd.co_art AND tsd.co_alma = 'P1' AND tsd.tipo = 'COM'),0))  AS stock,
			--tsd.co_alma, 
			ISNULL((SELECT top 1 tsd.co_alma FROM [ACCE].dbo.saStockAlmacen tsd 
					WHERE tsa.co_art = tsd.co_art AND tsd.co_alma = 'P1' AND tsd.tipo = 'ACT'),'') AS co_alma,
			--tsd.tipo AS tipoAlm, 
			ISNULL((SELECT top 1 tsd.tipo FROM [ACCE].dbo.saStockAlmacen tsd 
					WHERE tsa.co_art = tsd.co_art AND tsd.co_alma = 'P1' AND tsd.tipo = 'ACT'),'') AS tipoAlm,
			--tse.co_uni,
			ISNULL((SELECT top 1 tse.co_uni FROM [ACCE].dbo.saArtUnidad tse 
					WHERE tsa.co_art = tse.co_art  AND tse.uni_principal = 1),'') AS co_uni,
			tsa.tipo_imp,
			--tsf.porc_tasa
			ISNULL((SELECT top 1 tsf.porc_tasa FROM [ACCE].dbo.saImpuestoSobreVentaReng tsf
					WHERE tsa.tipo_imp = tsf.tipo_imp  AND fecha = '2009-04-01 00:00:00'),0) AS porc_tasa
		FROM [ACCE].dbo.saArticulo AS tsa ";

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}  
$withup='';
$i=0;
$comma='';
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    if ($i==1) $comma = ",";
    $withup.=   $comma."('".$row['co_art']."',"
                ."'".$row['fecha_reg']."',"
                ."'".$row['art_des']."',"    
                ."'".$row['tipo']."',"
                ."'".$row['anulado']."',"            
                ."'".$row['co_lin']."',"
                ."'".$row['co_subl']."',"
                ."'".$row['co_cat']."',"
                ."'".$row['co_color']."',"
                ."'".$row['co_ubicacion']."',"
                ."'".$row['cod_proc']."',"
                ."'".$row['item']."',"
                ."'".$row['modelo']."',"
                ."'".$row['ref']."',"
                ."'".$row['comentario']."',"
                ."'".$row['campo1']."',"
                ."'".$row['campo2']."',"
                ."'".$row['campo3']."',"
                ."'".$row['campo4']."',"
                ."'".$row['campo5']."',"
                ."'".$row['campo6']."',"
                ."'".$row['campo7']."',"
                ."'".$row['campo8']."',"            
                ."'".$row['PSStatusSinc']."',"
                ."'".$row['co_precio']."',"
                ."'".$row['monto']."',"
                ."'".$row['stock']."',"
                ."'".$row['co_alma']."',"
                ."'".$row['tipoAlm']."',"
                ."'".$row['co_uni']."',"
                ."'".$row['tipo_imp']."',"
                ."'".$row['porc_tasa']."')";
    $i++;
    }
//$withup='0000';
if ($withup!='0000') {
    //INI MY
    $tsid=strftime( "%Y%m%d%H%M%S", time() );
    $randx=  rand(0,100);
    $tsid="t".$randx.$tsid;
  $serverTWO = "192.168.0.11";   //PRO-HOME
    $optionsTWO = array(  "UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "B2BDB");


$connTWO = sqlsrv_connect($serverTWO, $optionsTWO);
if ($connTWO === false) die("<pre>".print_r(sqlsrv_errors(), true));
//echo "<br><br> Conectado a Sql Server 2014 ok PSControlDB <br>";
//CLEAN
        $sqlTWOCLEAN = " DELETE FROM [dbo].[ERPPSTMsaArticulo]";
//        echo '<br>sqlTWO:  '.$sqlTWOCLEAN .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWOCLEAN );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
} 

//INSERT


        $sqlTWO = " INSERT INTO [dbo].[ERPPSTMsaArticulo]
		(co_art, fecha_reg, art_des, tipo, anulado, co_lin, co_subl, co_cat, co_color, co_ubicacion, cod_proc, item, modelo, 
		ref,
		comentario, campo1, campo2, 
		campo3, campo4, campo5, campo6, campo7, campo8, PSStatusSinc, co_precio, monto, stock, co_alma,tipoAlm,co_uni,
		tipo_imp,porc_tasa) ";
        $sqlTWO.=' VALUES '.$withup;
        
//        echo '<br>sqlTWO:  '.$sqlTWO .'<br><br>';
        $stmtTWO = sqlsrv_query( $connTWO, $sqlTWO );
if( $stmtTWO === false) {
    die( print_r( sqlsrv_errors(), true) );
}  
}
else echo "<br>WITHOUT DATA REN:".$withup;
sqlsrv_close($connTWO);
sqlsrv_close($conn);
//------------------------------------------------------------------------------        
echo "<br>END<br>";
?>