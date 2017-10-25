<?php
session_start();
session_unset();
session_destroy();
require_once('../../conex.php');
conectar();
//var_dump($_POST); exit();
if($_POST){
            $usuario=strip_tags($_POST['usuario']);
            $pass=$_POST['pass'];
            unset($_POST);
            if(($usuario==true) || ($usuario!=" ")){
                $sQuery=@mysql_query("SELECT * FROM usuario WHERE uname='$usuario'");
                if(mysql_num_rows($sQuery) == 1){
                    $fila_usuario=mysql_fetch_array($sQuery);
                    $fecha = getdate();
                    $hoy=($fecha["year"]."-".$fecha["mon"]."-".$fecha["mday"]." ".$fecha["hours"].":".$fecha["minutes"].":".$fecha["seconds"]);
                    $segundos=strtotime($fila_usuario['lastchance']) - strtotime('now');
                    $dias=intval($segundos/60/60/24);
                    if($fila_usuario['intent'] < 3){
                        if(password_verify($pass, $fila_usuario['passwd'])){
                            $tipo_ingreso= $fila_usuario['tipo'];
                            if($tipo_ingreso=='12'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                $_SESSION["emailS"] = 'b2bfc@fcbyfauci.com.ve';
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../aud/clientescartera.php";</script>
                                <?php
                        
                            }
                            if($tipo_ingreso=='11'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                $_SESSION["emailS"] = 'b2bfc@fcbyfauci.com.ve';
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../tel/evento.php";</script>
                                <?php
                        
                            }if($tipo_ingreso=='7'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                $_SESSION["emailS"] = 'b2bfc@fcbyfauci.com.ve';
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../cxc/adminT.php?status=r";</script>
                                <?php
                            }if($tipo_ingreso=='9'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                $_SESSION["emailS"] = 'b2bfc@fcbyfauci.com.ve';
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../aud/adminT.php?status=e";</script>
                                <?php
                            }if($tipo_ingreso=='6'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../des/pedidosDesA.php";</script>
                                <?php
                            }if($tipo_ingreso=='3'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../ent/adminT.php?status=e";</script>
                                <?php
                            }if($tipo_ingreso=='2'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../enc/home.php?status=e";</script>
                                <?php
                            }
                            if($tipo_ingreso=='Eventual'){
                                session_start();
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['nombre'];
                                $_SESSION["tipo"] = $fila_usuario['tipo'];
                                $_SESSION["user"] = $fila_usuario['uname'];
                                $_SESSION["email"] = $fila_usuario['email'];
                                @mysql_query("UPDATE authuser SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                                ?>
                                <script language="javascript" type="text/javascript">window.location="../../../ev/evento.php";</script>
                                <?php
                        
                            }else{
                            ?>
                            <script type="text/javascript">alert("Usuario No esta Asignado al Sistema B2B Cyberlux - Admin");window.location="../../../index.php";</script>
                            <?php
                            }
                        }else{
                             @mysql_query("UPDATE authuser SET lastchance='".$hoy."', intent=intent+1 WHERE id=".$fila_usuario['id']);
                                         
                             $cn = @mysql_query("SELECT * FROM authuser WHERE id=".$fila_usuario['id']);
                             $rs= mysql_fetch_array($cn);
                             echo '<script type="text/javascript">alert("Clave incorrecta. Este es su intento fallido N° '.$rs['intent'].' || Al 3er intento su cuenta sera bloqueada");window.location="../../../index.php";</script>';
                         }
                     }else{
                         if($dias!=0){
                             @mysql_query("UPDATE authuser SET intent='0' WHERE id=".$fila_usuario['id']);
                             ?>
                                <script language="javascript" type="text/javascript">alert("Su cuenta ha sido desbloqueada, intente nuevamente");window.location="../../../index.php";</script>
                              <?php
                          }else{
                              ?>
                                <script language="javascript" type="text/javascript">alert("Cuenta bloqueada");window.location="../../../index.php";</script>
                              <?php
                          }
                     }
                }else{
                    ?>
                      <script language="javascript" type="text/javascript">alert("Usuario incorrecto");window.location="../../../index.php";</script>
                    <?php
                }
            }else{
                ?>
                  <script language="javascript" type="text/javascript">window.location="../../../index.php";</script>
                <?php
            }
        }else{
            
            header("Location: ../../../index.php");
        }
?>