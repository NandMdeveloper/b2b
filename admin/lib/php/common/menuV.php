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