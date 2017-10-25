<?php
$btnRturn = '<button type="button" class="btn btn-inverse" onClick="javascript:history.go(-1);"><i class="fa fa-chevron-left" aria-hidden="true"></i> Regresar</button>';
$qc = "SELECT art.art_des,art.monto FROM art INNER JOIN reng_pedido_temp ON art.co_art = reng_pedido_temp.co_art WHERE reng_pedido_temp.co_cli = $co_cli ORDER BY reng_pedido_temp.fecha DESC LIMIT 0, 4;";
$rc = @mysql_query($qc);
$qc2 = "SELECT * FROM reng_pedido_temp WHERE co_cli='$co_cli';";
$rc2 = @mysql_query($qc2);
?>
<div id="wrapper">

        <!-- Navigation -->
        <nav id="header" class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="home.php"><img class="col-xs-8" src="../image/logo_b2b.svg" style="width: 100px; margin-top: 8px;"/></a>
                
            </div>
            <!-- /.navbar-header -->
            <div id="user-nav">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        
                        <i class="fa fa-shopping-cart fa-fw"></i><span>(<?php echo $o=mysql_num_rows($rc2);?>)</span>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts dropdown-tasks-mod">
                        <?php
                        if($o!=0){
                            while ($roc = mysql_fetch_array($rc)) {
                                echo '<li>
                                    <a href="#">
                                        <div>
                                            '.$roc['art_des'].'
                                            <span class="pull-right text-muted small">Bs.F '.number_format($roc["monto"], 2, ",", ".").'</span>
                                        </div>
                                    </a>
                                </li>
                                <li class="divider"></li>';
                            }
                            ?>
                        <li>

                            <a class="text-link-mod-r invalida-activo" href="procesarcar.php">
                                <span>Procesar Pedido</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                        <?php
                        }else{
                           ?>
                            <li>
                            <a class="text-link-mod-r invalida-activo" href="#">
                                <span>Sin Productos</span>
                            </a>
                            </li>
                           <?php 
                        }
                        ?>
                        
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i><span> Pedidos</span>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks dropdown-tasks-mod">
                        <?php
                        $sql="SELECT * FROM pedidos WHERE co_cli = ".$co_cli." ORDER BY doc_num DESC LIMIT 4";
                        $result = @mysql_query($sql);
                        while ($row = mysql_fetch_array($result)) {
                            switch($row["status"]){
                                case "1":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">En Espera</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                    <span class="sr-only">20% Completo (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                                case "2":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">Pre Aprobado</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                    <span class="sr-only">40% Completo (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                                case "3":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">Aprobado</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                    <span class="sr-only">60% Completo (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                                case "4":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">Confirmado</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                    <span class="sr-only">80% Completo (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                                case "5":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">Despachado</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only">100% Completo (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                                case "6":
                                    echo '<li>
                                    <a href="detallePedido.php?id='.$row["doc_num"].'">
                                    <div>
                                    <p>
                                    <strong>Pedido #'.$row["doc_num"].'</strong>';
                                    echo '<span class="pull-right text-muted">Anulado</span>
                                    </p>
                                    <div class="progress progress-mod">
                                    <div class="progress-bar progress-bar-default" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                    <span class="sr-only">No Completado (success)</span>
                                    </div>';
                                    echo '</div>
                                    </div>
                                    </a>
                                    </li>
                                    <li class="divider"></li>';
                                break;
                            }
                        }
                    ?>
                        
                        <li>
                            <a class="text-link-mod-r invalida-activo" href="pedidos.php">
                                <span>Histórico de Pedidos</span>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user dropdown-tasks-mod">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i><span>Perfil de Usuario</span></a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i><span>Opciones</span></a>
                        </li>
                        <li class="divider"></li>
                        <li><a class="text-link-mod-r" href="lib/php/common/logout.php"><i class="fa fa-sign-out fa-fw"></i><span>Salir</span></a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            </div>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div id="sidebar" class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i><span> Inicio</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i><span> Pedidos</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="pedidos.php?status=e"><span>En Espera</span></a>
                                </li>
                                <li>
                                    <a href="pedidos.php?status=r"><span>Pre-Aprobados<span></a>
                                </li>
                                <li>
                                    <a href="pedidos.php?status=a"><span>Aprobados</span></a>
                                </li>
                                <li>
                                    <a href="pedidos.php?status=c"><span>Confirmados</span></a>
                                </li>
                                <li>
                                    <a href="pedidos.php?status=d"><span>Despachados</span></a>
                                </li>
                                <li>
                                    <a href="pedidos.php?status=l"><span>Anulados</span></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="inventario.php"><i class="fa fa-table fa-fw"></i><span> Productos Disponibles</span></a>
                        </li>
                        <li>
                            <a href="procesarcar.php"><i class="fa fa-edit fa-fw"></i><span> Procesar Pedido</span></a>
                        </li>
                        <!--<li>
                            <a href="#"><i class="fa fa-envelope-o fa-fw"></i><span> Mensajería Interna</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="mensajedist.php?para=t"><span>Telemarketing</span></a>
                                </li>
                                
                            </ul>
                             /.nav-second-level 
                        </li>-->
                        <li>
                            <a href="#"><i class="fa fa-bullhorn fa-fw"></i><span> Promociones</span></a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i><span> Manual de Usuario</span></a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
         </div>
    <!-- /#wrapper -->