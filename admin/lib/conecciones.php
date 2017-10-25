<?php
function conectarHost(){


		$host = "grupopro.com.ve"; //198.252.100.226 grupopro.com.ve
		$usuario = "grupopro_correo"; //power_db
		$clave = "50#mr8@OulKz"; //Cyber.2016
		$bd = "grupopro_nt"; //psdb

	$conexion = mysqli_connect($host, $usuario,$clave,$bd) or die(mysql_error());
	return $conexion;
}
function conectarServ($servidor){

	if ($servidor) {	

		$host = "192.168.0.134"; //200.71.189.252    127.0.0.1
		$usuario = "power_db"; //power_db
		$clave = "#hGbkWpdeSD;"; //Cyber.2016
		$bd = "b2bfc"; //psdb

	} else {

		$host = "localhost";
		$usuario = "root";
		$clave = "";
		$bd = "b2bfc"; //psdb
	}

	$conexion = mysqli_connect($host, $usuario,$clave,$bd) or die(mysqli_error($conexion));

	return $conexion;
}

function conectarExterno($host,$bd,$usuario,$clave){
	$conexion = mysqli_connect($host, $usuario,$clave,$bd) or die(mysql_error());
	return $conexion;
}
function conectarSQlSERVER(){
	//SRVGPAP001/Administrador
	$server = "192.168.0.10";
    $options = array("UID" => "ps",  "PWD" => "#hGbkWpdeSD;",  "Database" => "ACCE");
    $conn = sqlsrv_connect($server, $options);
    /* Iniciar la transacción. */
	if(!$conn){
		die( print_r( sqlsrv_errors(), true ));
		
	}	
    if ( sqlsrv_begin_transaction( $conn ) === false ) {
        die( print_r( sqlsrv_errors(), true ));
    }
	
	return $conn;
}

function conectarODBC(){
	$server = '192.168.0.10';
    $user = 'ps';
    $pass = '#hGbkWpdeSD;';
    //Define Port
    $port='Port=1433';
    $database = 'pruebaHM';

    $connection_string = "DRIVER={SQL Server};SERVER=$server;$port;DATABASE=$database";
    $conn = odbc_connect($connection_string,$user,$pass);
    if ($conn) {
        echo "Connection established.";
    } else{
        die("Connection could not be established.");
    }
}
function tablas(){
	
	?>
		<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Tablas</h3>
		</div>
		<div class="panel-body">
		<table class="table table-striped table-hover ">
		  <thead>
			<tr>
			  <th>#</th>
			</tr>
		  </thead>
		  <tbody>
			<?php
			$actual_link = "pruebaServer.php";
			$conexion = conectar();
			$sql = "show TABLES";
			$tablas = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
			if(mysqli_num_rows($tablas)){
			
			while($tabla = mysqli_fetch_array($tablas)){
				?>
				
				<tr>
				  <td><a href="<?php echo $actual_link; ?>?tabla=<?php echo $tabla[0]; ?>"><?php echo $tabla[0]; ?></a></td>
				</tr>
				<?php
			}
			
			}
			?>
		</tbody>
		</table> 
	</div>
	</div>
	<?php
}
function tablasSqlServer($tablaBuscar){
	$actual_link = "tablasSQLSER.php";
	$conn = conectarSQlSERVER();
	
	
	$sel="select * from sys.tables order by name;";
	
	if($tablaBuscar!= null){
		$sel="SELECT * FROM SYS.TABLES WHERE NAME LIKE '%".$tablaBuscar."%'  order by name;";
	}
	$res= sqlsrv_query($conn,$sel);			
	$cant = sqlsrv_num_rows($res);
	
	?>
		<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Tablas (<?php echo $cant; ?>)</h3>
		</div>
		<div class="panel-body">
		<table class="table table-striped table-hover ">
		  <thead>
			<tr>
			  <th>#</th>
			</tr>
		  </thead>
		  <tbody>
			<?php
						
			while($tabla = sqlsrv_fetch_array($res)){
				?>				
				<tr>
				  <td><a href="<?php echo $actual_link; ?>?tabla=<?php echo $tabla[0]; ?>"><?php echo $tabla[0]; ?></a></td>
				</tr>
				<?php
			}			
			?>
		</tbody>
		</table> 
	</div>
	</div>
	<?php
}
function camposSqlServer($buscar){
	$actual_link = "tablasSQLSER.php";
	$conn = conectarSQlSERVER();
	
	
	$sel="select * from sys.tables order by name;";
	
	if($buscar!= null){
		$sel="SELECT TABLE_NAME,COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE COLUMN_NAME LIKE '%".$buscar."%';";
	}
	$res= sqlsrv_query($conn,$sel);			
	//$cant = sqlsrv_num_rows($res);
	
	?>
		<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Tablas </h3>
		</div>
		<div class="panel-body">
		<table class="table table-striped table-hover ">
		  <thead>
			<tr>
			  <th>#</th>
			</tr>
		  </thead>
		  <tbody>
			<?php
						
			while($tabla = sqlsrv_fetch_array($res)){
				//var_dump($tabla);
				?>				
				<tr>
				  <td><a href="<?php echo $actual_link; ?>?tabla=<?php echo $tabla[0]; ?>">
					<span class="glyphicon glyphicon-hdd text-info"></span> 
					<?php echo $tabla[0]; ?> 
					<span class="glyphicon glyphicon-list-alt text-warning"></span> 
					<?php echo $tabla[1]; ?>
					
				  </a></td>
				</tr>
				<?php
			}			
			?>
		</tbody>
		</table> 
	</div>
	</div>
	<?php
}

function detalletabla($nombretabla){
	$conexion = conectar();
	$sql = "describe $nombretabla";
	$tablas = mysqli_query($conexion,$sql) or die(mysqli_error($conexion));
	?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $nombretabla; ?></h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover ">
			  <thead>
				<tr>
				  <th>Id nombre</th>
				  <th>Tipo</th>
				  <th>Extra</th>
				</tr>
			  </thead>
			  <tbody>			
				<?php
				
				while($tabla = mysqli_fetch_array($tablas)){
					?>
					<tr>	
						
						<td><?php echo $tabla[0]; ?></td>
						<td><?php echo $tabla[1]; ?></td>
						<td><?php echo $tabla[3]; ?></td>
					</tr>	
						<?php
					}
				?>				
				</tbody>
			</table> 
		</div>
	</div>	
	<?php
	
}
function detalletablaSQLSER($nombretabla){
	$conn = conectarSQlSERVER();
	$sel = " sp_columns  '$nombretabla' ";	
	$tablas=sqlsrv_query($conn,$sel);	
	?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo $nombretabla; ?> <a href="select.php?tabla=<?php echo $nombretabla; ?>" class="btn btn-default btn-sm pull-right"><span class="glyphicon glyphicon-th-list"></span></a></h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover ">
			  <thead>
				<tr>
				  <th>Id nombre</th>
				  <th>Tipo</th>
				  <th>Extra</th>
				</tr>
			  </thead>
			  <tbody>			
				<?php
				
				while($tabla = sqlsrv_fetch_array($tablas)){
					//var_dump($tabla);
					?>
					
					<tr>	
						
						<td><?php echo $tabla[3]; ?></td>
						<td><?php echo $tabla[5]; ?></td>
						<td><?php echo $tabla[5]; ?></td>
					</tr>	
						<?php
					}
				?>				
				</tbody>
			</table> 
		</div>
	</div>	
	<?php
	
}
?>