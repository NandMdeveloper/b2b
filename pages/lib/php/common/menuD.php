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
                <a class="navbar-brand" href="adminD.php?status=c"><img class="col-xs-8" src="../image/logo_b2b.svg" style="width: 100px; margin-top: 8px;"/></a>
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
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i>Salir</a>
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
                        
                        <li>
                            <a href="#"><i class="fa fa-dashboard fa-fw"></i><span> Inicio</span></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i><span> Pedidos</span></a>
                            <ul class="nav nav-second-level">
                                
                                <li>
                                    <a href="adminD.php?status=c"><span>Confirmados</span></a>
                                </li>
                                <li>
                                    <a href="adminD.php?status=d"><span>Despachados</span></a>
                                </li>
                                <li>
                                    <a href="adminD.php?status=l"><span>Anulados</span></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bullhorn fa-fw"></i><span> Promociones</span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#"><span>Cyberlux</span></a>
                                </li>
                                <li>
                                    <a href="#"><span>Frigilux</span></a>
                                </li>
                                
                            </ul>
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
