<?php
session_start();
session_unset();
session_destroy();
require_once('../../conex.php');
conectar();
if($_POST){
            $usuario=strip_tags($_REQUEST['rif']);
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
                             session_start();
                                $sQuery2=@mysql_query("SELECT * FROM clientes WHERE rif='$usuario'");
                                $row2= mysql_fetch_array($sQuery2);
                                $_SESSION["co_cli"] = $row2['co_cli'];
                                $_SESSION["cli_des"] = $row2['cli_des'];
                                $_SESSION["tipo_cli"] = $row2['tipo_cli'];
                                $_SESSION["co_zon"] = $row2['co_zon'];
                                $_SESSION["co_ven"] = $row2['co_ven'];
                                $_SESSION["direc"] = $row2['direc'];
                                $_SESSION["telefonos"] = $row2['telefonos'];
                                $_SESSION["rif"] = $row2['rif'];
                                $_SESSION["contrib"] = $row2['contrib'];
                                $_SESSION["email"] = $row2['email'];
                                $_SESSION["ciudad"] = $row2['ciudad'];
                                $_SESSION["co_pais"] = $row2['co_pais'];
                                $_SESSION['autentica'] = "SIP";
                                $_SESSION["nombre"] = $fila_usuario['uname'];
                                
                               @mysql_query("UPDATE usuario SET lastlogin='".$hoy."', intent=0, logincount=logincount+1 WHERE id=".$fila_usuario['id']);
                               ?>
                                    <script language="javascript" type="text/javascript">window.location="../../../home.php";</script>
                                <?php
                        }else{
                            @mysql_query("UPDATE usuario SET lastchance='".$hoy."', intent=intent+1 WHERE id=".$fila_usuario['id']);
                                         
                            $cn = @mysql_query("SELECT * FROM usuario WHERE id=".$fila_usuario['id']);
                            $rs= mysql_fetch_array($cn);
                            echo '<script type="text/javascript">alert("Clave incorrecta. Este es su intento fallido N° '.$rs['intent'].' || Al 3er intento su cuenta sera bloqueada");window.location="../../../index.php";</script>';
                         }
                     }else{
                         if($dias!=0){
                             @mysql_query("UPDATE usuario SET intent='0' WHERE id=".$fila_usuario['id']);
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