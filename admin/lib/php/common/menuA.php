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
                <a class="navbar-brand" href="adminT.php?status=r"><img class="col-xs-8" src="../../image/logo_b2b.svg" style="width: 100px; margin-top: 8px;"/></a>
            </div>
            <!-- /.navbar-header -->
            <div id="user-nav">
            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i>Perfil de Usuario</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i>Opciones</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="../lib/php/common/logout.php"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            </div>

            <div class="navbar-default sidebar" role="navigation">
                <div id="sidebar" class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <?php $us = $_SESSION['user']; ?>
                     <?php if ($us=="javier"or $us=="njose" or $us=="jvera") { ?>
                        <li>
                            <a href="#"><i class="fa fa-user "></i> <span>Usuarios</span>
                            </a>
                           <ul class="nav nav-second-level">
                           <li><a href="usuarioshome.php"><i class="fa fa-user-plus "></i> Creacion de Usuario</a></li>
                           </ul>
                           </li>  
                            <?php } ?>  
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i><span> Pedidos</span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="adminT.php?status=e"><span>En Espera</span></a></li>
                                <li><a href="adminT.php?status=r"><span>Pre-Aprobados</span></a></li>
                                <li><a href="adminT.php?status=a"><span>Aprobados</span></a></li>
                                <li><a href="adminT.php?status=n"><span>Clientes Nuevos</span></a></li>
                                <li><a href="adminT.php?status=l"><span>Anulados</span></a></li>
                                <li><a href="pedidosDes.php"><span>Aprobar Facturacion</span></a></li>
                                <li><a href="pedidosDesA.php"><span>Para Facturar</span></a></li>
                                <li><a href="pedidosDesF.php"><span>Para Despachar</span></a></li>
                                <li><a href="pedidosDesD.php"><span>Despachados</span></a></li>
                                <li><a href="pedidosDesR.php"><span>Entregados</span></a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="reporteAnalisis.php"><i class="fa fa-files-o fa-fw"></i><span> Reporte analisis vencimiento</span></a>
                            
                            <!-- /.nav-second-level -->
                        </li>
						<li>
                            <a href="excelPedidos.php"><i class="fa fa-files-o fa-fw"></i><span> Listado de Pedidos</span></a>
                            
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-calculator fa-fw"></i><span> Comisiones</span></a>
                            <ul class="nav nav-second-level">
                               <li><a href="comisionActividad.php">Actividad Vendedores</a></li>
                                <li><a href="comisionrango.php"><span>Comisiones I</span></a></li>
                                <li><a href="comisionsaldos.php"><span>Saldos</span></a></li>
					            <!-- <li><a href="comisionagregargerenteregional.php">Gerente Regional</a></li> -->
					            <li><a href="comisionagregargerenteventa.php">Gerente Ventas</a></li> 
                                <li><a href="comisonparametros.php"><span>Parametros Básicos</span></a></li>
                                <li><a href="comisionMetaClave.php">Presupuesto Claves</a></li> -->
                                 <li><a href="comisionMetaVendedor.php"><span>Presupuesto Vendedores</span></a></li>
                                <li><a href="comisionesRegiones.php"><span>Presupuesto vs Ventas</span></a></li>
          						  <li><a href="comisionregion.php">Regiones</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li class="treeview">
                          <a href="#"><i class="fa fa-briefcase"></i> <span>Clientes</span>
                            <span class="pull-right-container">
                              <i class="fa fa-angle-left pull-right"></i>
                            </span>
                          </a>
                           <ul class="treeview-menu">
                             <li><a href="clientescartera.php">Clientes</a></li>
                             <li><a href="clientestendencia.php">Tendencia</a></li>
                             <!-- <li><a href="clientesAcuales.php">Clientes Registros</a></li> -->
                            <!--  <li><a href="clientesActivos.php">Clientes - ventas</a></li> -->
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
    </div>
    <!-- /#wrapper -->