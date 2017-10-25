<?php
require_once("../lib/seg.php");
require_once('../lib/conex.php');
conectar();

$nombre=$_SESSION["nombre"];
$team=$_SESSION["team"];
$user=$_SESSION["user"];

?>
<!DOCTYPE html>
<html lang="es">
<?php require_once('../lib/php/common/head.php'); ?>
<body>
<?php require_once('../lib/php/common/menu.php'); ?>
        <div id="content">
                <div class="col-lg-12">
                    <h1 class="page-header">Crear Pedido</h1>
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                        <div class="success-messages"></div> <!--/success-messages-->   
                        </div>
                        <form role="form" name="Form" action="procesarP.php" method="POST" id="createOrderForm">
                        <!-- /.panel-heading -->
                        <div class="row">
                            <div class="col-xs-12 form-group">
                                <div class="col-xs-6"><h3>Clientes: </h3>
                                <select id="cliente" name="cliente" class="selectpicker form-control" data-size="6" data-live-search="true" title="Seleccione Cliente..." data-width="100%"  required>
                                    <optgroup label="Regulares">
                                <?php
                                    $query5 = "SELECT clientes.co_cli,clientes.cli_des FROM clientes WHERE co_ven='$user'";
                                    $result5 = @mysql_query($query5);
                                    while ($row5 = mysql_fetch_array($result5)) {
                                        echo '<option value="'.$row5["co_cli"].'">'.$row5["cli_des"].'</option>';
                                    }
                                ?>
                                    </optgroup>
                                    <optgroup label="Nuevos">
                                <?php
                                    $query6 = "SELECT cliente_evento.rif,cliente_evento.nombre_emp FROM cliente_evento WHERE co_ven='$user'";
                                    $result6 = @mysql_query($query6);
                                    while ($row6 = mysql_fetch_array($result6)) {
                                        echo '<option value="'.$row6["rif"].'">'.$row6["nombre_emp"].'</option>';
                                    }
                                ?>
                                    </optgroup>
                                </select>
                                </div>
                            </div>
                        <div class="col-xs-12">
                            <hr>
                            <table class="table" id="productTable">
                <thead>
                    <tr>                        
                        <th style="width:35%;">Producto</th>
                        <th style="width:5%;">Apl.</th>
                        <th style="width:15%;">Precio</th>
                        <th style="width:10%;">Cantidad</th>
                        <th style="width:10%;">U. Emp.</th>
                        <th style="width:15%;">Total</th>                       
                        <th style="width:5%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $arrayNumber = 0;
                    for($x = 1; $x < 2; $x++) { ?>
                        <tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">                          
                            <td>
                                <div class="form-group">
                                <select id="productName<?php echo $x; ?>" name="productName[]" class="selectpicker form-control" data-live-search="true" data-width="400px" data-size="5" onchange="getProductData(<?php echo $x; ?>)" required>
                                <option value="0"> Seleccione Producto</option>
                                    <?php
                                        $sQuery="SELECT art.co_art,art.art_des,art.monto,art.stock FROM art WHERE art.stock > 0 AND art.monto > 0";
                                        $result=mysql_query($sQuery) or die(mysql_error());
                                        while($row=mysql_fetch_array($result)) {
                                            echo '<option data-monto="'.$row["monto"].'" value="'.$row["co_art"].'" id="changeProduct'.$row['co_art'].'">'.$row["co_art"].' | '.$row["monto"].' Bs.F. | Stock:'.$row["stock"].' | '.$row["art_des"].'</option>';
                                            
                                        } // /while 
                                    ?>
                                </select>
                                </div>
                            </td>
                            <td>
                                <div id="apl<?php echo $x; ?>"></div>
                            </td>
                            <td>                             
                                <input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />                              
                                <input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />                              
                            </td>
                            <td>
                                <div class="form-group">
                                <input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                <select id="unidad<?php echo $x; ?>" name="unidad[]" class="form-control" required onchange="mult(<?php echo $x; ?>)">
                                    <option value="">Seleccione</option>
                                </select>
                                </div>
                            </td>
                            <td>                             
                                <input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />                                
                                <input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />                                
                            </td>
                            <td>
                                <button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
                            </td>
                        </tr>
                    <?php
                    $arrayNumber++;
                    } // /for
                    ?>
                </tbody>                
              </table>
              </div>
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="descuento" class="col-sm-3 control-label">Descuento</label>
                    <div class="col-sm-9">
                        <select id="descuento" name="descuento" class="form-control" required disabled onchange="des()">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                </div> <!--/form-group-->
                <div class="form-group">
                    <label for="subTotal" class="col-sm-3 control-label">Sub total</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
                      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
                    </div>
                  </div> <!--/form-group-->           
                  <div class="form-group">
                    <label for="vat" class="col-sm-3 control-label">IVA 12%</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="vat" name="vat" disabled="true" />
                      <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
                    </div>
                  </div> <!--/form-group-->           
                  <div class="form-group">
                    <label for="totalAmount" class="col-sm-3 control-label">Total neto</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" />
                      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
                    </div>
                  </div>                 
              </div> <!--/col-md-6-->

              <div class="form-group submitButtonFooter">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="button" class="btn btn-default" onclick="addRow();" id="addRowBtn" data-loading-text="Cargando..."><i class="glyphicon glyphicon-plus-sign"></i> Añadir Producto </button>

                  <button type="submit" id="createOrderBtn" data-loading-text="Cargando..." class="btn btn-success" disabled><i class="glyphicon glyphicon-ok-sign"></i> Generar Pedido</button>

                  <button type="reset" class="btn btn-default" onclick="resetOrderForm();"><i class="glyphicon glyphicon-erase"></i> Limpiar</button>
                </div>
              </div>
            </form>
            
            </div>
        </div>
        <!-- /.row -->
    </div>
    <div class="modal fade modal-app" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" style="padding: 20px;">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <h3 class="text-center">Unidad de Empaque y Aplicaciones</h3>
            <p class="text-center" id="datos"></p>
            <p class="text-center"><button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Aceptar</button></p>
          </div>
      </div>
    </div>
        <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.js"></script>

    <script src="custom/js/order.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <script src="../../dist/boostrap-select-1.12/js/bootstrap-select.js"></script>
    
    <script>
    function modal(x){
        var id =document.getElementById("dd"+x).value;
        document.getElementById("datos").innerHTML=id;
        $('.modal-app').modal('show');
    return;
    }
    
</script>
</body>

</html>
