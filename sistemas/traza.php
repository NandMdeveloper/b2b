<?php
//$con = mysql_connect('localhost', 'root', 'localhost');
$con = mysql_connect('localhost', 'power_db', '#hGbkWpdeSD;');
//mysql_select_db('psdb_bk', $con);
mysql_select_db('b2bfc', $con);

$sql="SELECT * FROM `log_pedidos_despacho` WHERE 
   `user` LIKE '%eliud%' AND `accion` LIKE '%Insercion del pedido%' and (

`fecha` LIKE '%2017-08-15%'
 or `fecha` LIKE '%2017-08-14%'
 or `fecha` LIKE '%2017-08-16%'
 or `fecha` LIKE '%2017-08-17%'
 or `fecha` LIKE '%2017-08-18%' )";
$result=mysql_query($sql);
?>

<table>
    <tr>
        <th>fecha</th>
        <th>Usuario</th>
        <th>Acción Realizada</th>
    </tr>
    <?php while($row=mysql_fetch_array($result)){ ?>
        <tr>
            <td><?php echo $row['fecha']; ?></td>
            <td><?php echo $row['user']; ?></td>
            <td><?php echo $row['accion']; ?></td>
        </tr>
    <?php } ?>
</table>