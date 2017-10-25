<?php
class BdQuery {
  var $consulta;
	function Query_Select($tabla,$where,$order){
		mssql_query('Set ansi_nulls on');
		mssql_query('Set ansi_warnings on');
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		$sQuery = "SELECT * FROM $tabla $where $order";
//		echo "<br><br>Query_Select </b>".$sQuery."<br><br>";
		$result = mssql_query($sQuery) or die(mysql_min_error_severity());
		$r = mssql_fetch_array($result);
		return $r;
	}
		function Query_Select_col($select,$tabla,$where,$order){
		mysql_query('Set ansi_nulls on');
		mysql_query('Set ansi_warnings on');
		if($select=='') $select = "*";
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		$sQuery = "SELECT $select FROM $tabla $where $order";
//       echo "<br><br>Query_Select_campos </b>".$sQuery."<br><br>";
//		$r = $sQuery;
		$result = mysql_query($sQuery) or die(mysql_error());
		$r = mysql_fetch_array($result);
		return $r;
        }        
//	function Query_Select_campos($select,$tabla,$where,$order){
////		mssql_query('Set ansi_nulls on');
////		mssql_query('Set ansi_warnings on');
////		if($select=='') $select = "*";
////		if($where!='') $where = "WHERE ".$where;
////		if($order!='') $order = "ORDER BY ".$order;
////		$sQuery = "SELECT $select FROM $tabla $where $order";
////       //echo "<br><br>Query_Select_campos </b>".$sQuery."<br><br>";
//////		$r = $sQuery;
////		$result = mssql_query($sQuery) or die(mssql_min_error_severity());
////		$r = mssql_fetch_array($result);
////		return $r;
//	}
	
	function Query_Select_while($tabla,$where,$order){
		mssql_query ('SET ANSI_NULLS ON');
                mssql_query('SET ANSI_WARNINGS ON');
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		$sQuery = "SELECT * FROM $tabla $where $order";
		//echo "<br><br>Query_Select_while: ".$sQuery."<br><br>";
		$result = mssql_query($sQuery) or die(mssql_min_error_severity());
		return $result;
	}
	
	function Query_Select_while2($tabla,$select,$where,$order){
            mysql_query ('SET ANSI_NULLS ON');
                mysql_query('SET ANSI_WARNINGS ON');
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		$sQuery = "SELECT $select FROM $tabla $where $order";
     //echo "<br><br>Consulta BDQUERY: ".$sQuery."<br><br>";  
		$result = mysql_query($sQuery) or die(mysql_error());
		return $result;            
            
            
//		mssql_query ('SET ANSI_NULLS ON');
//                mssql_query('SET ANSI_WARNINGS ON');
//		if($where!='') $where = "WHERE ".$where;
//		if($order!='') $order = "ORDER BY ".$order;
//		$sQuery = "SELECT $select FROM $tabla $where $order";
//     echo "<br><br>Consulta BDQUERY: ".$sQuery."<br><br>";
//		$result = mssql_query($sQuery) or die(mssql_min_error_severity());
//		return $result;
	}

	function Select_Query($query){
		mysql_query ('SET ANSI_NULLS ON');
        mysql_query('SET ANSI_WARNINGS ON');
        $result = mysql_query($query) or die(mysql_error);
        return $result;
	}

	function Query_Select_while3($tabla,$select,$where,$order,$group){
		mysql_query ('SET ANSI_NULLS ON');
        mysql_query('SET ANSI_WARNINGS ON');
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		if($group!='') $group = "GROUP BY ".$group;
		$sQuery = "SELECT $select FROM $tabla $where $group $order";
//		echo "<br><br>Consulta BDQUERY: ".$sQuery."<br><br>";
                $result = mysql_query($sQuery) or die(mysql_error);
                
                
		//$result = mysql_query($sQuery) or die(mysql_min_error_severity());
		return $result;
	}
	
	function Query_Insert($tabla,$campos,$valores){
		if($campos!=''){ $values = " ($campos)	VALUES	($valores)";}
		else{ $values = " VALUES	($valores)";}
		$sQuery = "INSERT INTO $tabla $values;";
       //echo "<br><br>INSERT BDQUERY: ".$sQuery."<br><br>";
       //die();
		$result = mysql_query($sQuery);
                        //or die(mysql_min_error_severity());
		//$this->consulta=  $sQuery;
		return $result;
	}

        //LIKE THE FIRST, BUT WITHOUT THE PARENTHESES, USED IN MULTIPLE VALUES INSERTED
        	function Query_InsertMV($tabla,$campos,$valores){
		if($campos!=''){ $values = " ($campos)	VALUES	$valores";}
		else{ $values = " VALUES  $valores  ";}
		$sQuery = "INSERT INTO $tabla $values;";
       //echo "<br><br>INSERT BDQUERY: ".$sQuery."<br><br>";
       //die();
		$result = mysql_query($sQuery);
                        //or die(mysql_min_error_severity());
		//$this->consulta=  $sQuery;
		return $result;
	}

        
	function Query_Insert_Esp($tabla,$campos,$valores,$otros){
		if($campos!=''){ $values = " ($campos)	VALUES	($valores)";}
		else{ $values = " VALUES	($valores)";}
		$sQuery = "INSERT INTO $tabla $values $otros;";
//				echo "<br><br>INSERT BDQUERY: ".$sQuery."<br><br>";
                $result=mssql_query($sQuery) or die(mysql_min_error_severity());
		//$this->consulta=  $sQuery;
//		echo "<br><br>INSERT BDQUERY: ".$sQuery."<br><br>";

		return $result;
	}
	
        
//         //LIKE THE FIRST, BUT WITHOUT THE PARENTHESES, USED IN MULTIPLE VALUES INSERTED
        function Query_Insert_SELECT($tabla,$campos,$valores){
		if($campos!=''){ $values = " ($campos)	$valores";}
		else{ $values = "   $valores  ";}
		$sQuery = "INSERT INTO $tabla $values;";
//               echo "<br><br>INSERT Query_Insert_SELECT: ".$sQuery."<br><br>";
                //die();
		$result = mysql_query($sQuery)or die("mysql_error");
                        //or die(mysql_min_error_severity());
		//$this->consulta=  $sQuery;
		return $result;
	}
	function Query_Update($tabla,$values,$where){
		if($where!='') $where = "WHERE ".$where;
		$sQuery = "UPDATE $tabla SET $values $where;";
//        $this->consulta= "<br><br>Consulta BDQUERY: ".$sQuery."<br><br>";
               // echo "<br><br>UPDATE BDQUERY: ".$sQuery."<br><br>";
//                die();

		$result=mysql_query($sQuery); //or die("mysql_error");
//		$result = $sQuery;
		return $result;	
	}
	
	function Query_NRow($tabla,$where){
		if($where!='') $where = "WHERE ".$where;
        $sQuery = "SELECT * FROM $tabla $where";
  //     echo "<br>Query_NRow: ".$sQuery."<br><br>";
		$result = mssql_query($sQuery); //or die(mssql_min_error_severity());
		$r = mssql_num_rows($result);
		return $r;
	}

    	function Query_NRow2($tabla,$where){//REN16062014 ENHANCED
		if($where!='') $where = "WHERE ".$where;
		$sQuery = "SELECT COUNT(1) AS TQuantity FROM $tabla $where";
              //  echo "<br>Query_NRow2: ".$sQuery."<br><br>";
                $result = mysql_query($sQuery) or die(mysql_min_error_severity());
		$r = mysql_fetch_array($result);
        
		return $r;
	}
    
	
	function Query_NColumn($tabla){
		if($where!='') $where = "WHERE ".$where;
		$sQuery = "select top 1 * FROM $tabla $where";
		$result = mssql_query($sQuery) or die(mysql_min_error_severity());
		$r = mssql_num_fields($result);
		return $r;
	}
	
	function Query_Delete($tabla,$where){
		if($where!=''){ 
			$where = "WHERE ".$where;
			$sQuery = "DELETE FROM $tabla $where";
//			$result = mssql_query($sQuery);
	//echo "<br><br>DELETE BDQUERY: ".$sQuery."<br><br>";
			$result = mysql_query($sQuery) or die(mysql_min_error_severity());
		}else{ $result='Error: where no puede ser vacio.';}
			return $result;
	}

//ren2508201101
	function Query_SelectLis($tabla,$where,$order){
		$result=mssql_query('Set ansi_nulls on');
		$result=mssql_query('Set ansi_warnings on');
		if($where!='') $where = "WHERE ".$where;
		if($order!='') $order = "ORDER BY ".$order;
		$result=$sQuery = "SELECT * FROM $tabla $where $order";
		//die ($sQuery); 		
        //echo ($sQuery);
		$result = mysql_query($sQuery)  or die(mysql_error);
		$i=0;
		while($row=mssql_fetch_array($result)){
			foreach($row as $key=>$value){
				$res_array[$i][$key]=$value;
				}
			$i++;
		}
		return($res_array);
	}
    function get_consulta(){
      return $this->consulta;
    }
    function Query_prcdr($prodedure,$values){
            $query = mssql_init($prodedure);
            $VALOR_PARAM=explode('|',$values);
            //$VALOR_PARAM=$values;
//            echo "<br>".$VALOR_PARAM;
            mssql_bind($query, "@Action", $VALOR_PARAM[0], SQLVARCHAR); // SQLVARCHAR para una cadena de texto variable
            mssql_bind($query, "@CodId", $VALOR_PARAM[1], SQLVARCHAR); // SQLVARCHAR para una cadena de texto variable
            //mssql_bind($query, "@a4", $VALOR_PARAM[2], SQLVARCHAR); // SQLVARCHAR para una cadena de texto variable
            $result = mssql_execute($query);
            return $result;	
            }	
    
}

?>