<?php
class TSBdQueryProcedure {
    var $sQuery;
    //TS funtion main insert update delete data
    function TSBdQueryProcedureMain($sUp){
        $r=true;
        $ObjBdQ2= new BdQuery(); 
        switch ($sUp){
////////////////////////////////////////////////////////////////////////////////
case 'art':{
    $table2="art";    
    $select2="co_art,art_des,co_lin,co_cat,co_subl,co_color,ref,modelo,comentario,co_prov,tipo,prec_vta1,prec_vta2,prec_vta3,prec_vta4,prec_vta5,stock_act,co_us_mo,uni_venta,uni_venta2,equi_uni1,equi_uni2,campo1,campo2,campo3,
              campo4,campo5,campo6,campo7,campo8,ubicacion,co_precio,monto,tipo_imp,co_alma,stock,tipoAlm,anulado,cod_proc,item,co_uni,porc_tasa,fecha_reg,tssit"; 
    $values2="SELECT art_control.co_art, art_control.art_des, art_control.co_lin, art_control.co_cat, art_control.co_subl, art_control.co_color, art_control.ref, art_control.modelo, art_control.comentario, art_control.co_prov,
                    art_control.tipo, art_control.prec_vta1, art_control.prec_vta2, art_control.prec_vta3, art_control.prec_vta4, art_control.prec_vta5, art_control.stock_act, art_control.co_us_mo, art_control.uni_venta, 
                    art_control.uni_venta2, art_control.equi_uni1, art_control.equi_uni2, art_control.campo1, art_control.campo2, art_control.campo3, art_control.campo4, art_control.campo5, art_control.campo6, art_control.campo7,
                    art_control.campo8, art_control.ubicacion, art_control.co_precio, art_control.monto, art_control.tipo_imp, art_control.co_alma, art_control.stock, art_control.tipoAlm, art_control.anulado, art_control.cod_proc,
                    art_control.item, art_control.co_uni, art_control.porc_tasa, art_control.fecha_reg, art_control.tssit
                FROM art_control LEFT JOIN art ON art_control.co_art = art.co_art
                WHERE  art.co_art IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$values2);//into bd
        
    //ONLY UPDATE art
    $table2 = " art, art_control";
    $values2 =" art.art_des = art_control.art_des, art.co_art = art_control.co_art, art.art_des = art_control.art_des,
                art.co_lin = art_control.co_lin, art.co_cat = art_control.co_cat, art.co_subl = art_control.co_subl,
                art.co_color = art_control.co_color, art.ref = art_control.ref, art.modelo = art_control.modelo,
                art.comentario = art_control.comentario, art.co_prov = art_control.co_prov, art.tipo = art_control.tipo,
                art.prec_vta1 = art_control.prec_vta1,art.prec_vta2 = art_control.prec_vta2,
                art.prec_vta3 = art_control.prec_vta3,art.prec_vta4 = art_control.prec_vta4,
                art.prec_vta5 = art_control.prec_vta5,art.stock_act = art_control.stock_act,
                art.co_us_mo = art_control.co_us_mo,art.uni_venta = art_control.uni_venta,
                art.uni_venta2 = art_control.uni_venta2,art.equi_uni1 = art_control.equi_uni1,
                art.equi_uni2 = art_control.equi_uni2,art.campo1 = art_control.campo1,art.campo2 = art_control.campo2,
                art.campo3 = art_control.campo3,art.campo4 = art_control.campo4,art.campo5 = art_control.campo5,
                art.campo6 = art_control.campo6, art.campo7 = art_control.campo7, art.campo8 = art_control.campo8,
                art.ubicacion = art_control.ubicacion, art.co_precio = art_control.co_precio,
                art.monto = art_control.monto, art.tipo_imp = art_control.tipo_imp, art.co_alma = art_control.co_alma,
                art.stock = art_control.stock, art.tipoAlm = art_control.tipoAlm, art.anulado = art_control.anulado,
                art.cod_proc = art_control.cod_proc, art.item = art_control.item, art.co_uni = art_control.co_uni,
                art.porc_tasa = art_control.porc_tasa, art.fecha_reg = art_control.fecha_reg,
                art.tssit = art_control.tssit";
    $where2 = "(TSSincStatus = 1) AND "
            . "(art_control.co_art = art.co_art) AND 
               (art_control.art_des <> art.art_des OR art_control.co_art <> art.co_art OR 
                art_control.art_des <> art.art_des OR art_control.co_lin <> art.co_lin OR
                art_control.co_cat <> art.co_cat OR art_control.co_subl <> art.co_subl OR 
                art_control.co_color <> art.co_color OR art_control.ref <> art.ref OR 
                art_control.modelo <> art.modelo OR art_control.comentario <> art.comentario OR 
                art_control.co_prov <> art.co_prov OR art_control.tipo <> art.tipo OR 
                art_control.prec_vta1 <> art.prec_vta1 OR art_control.prec_vta2 <> art.prec_vta2 OR
                art_control.prec_vta3 <> art.prec_vta3 OR art_control.prec_vta4 <> art.prec_vta4 OR
                art_control.prec_vta5 <> art.prec_vta5 OR art_control.stock_act <> art.stock_act OR
                art_control.co_us_mo <> art.co_us_mo OR art_control.uni_venta <> art.uni_venta OR
                art_control.uni_venta2 <> art.uni_venta2 OR art_control.equi_uni1 <> art.equi_uni1 OR
                art_control.equi_uni2 <> art.equi_uni2 OR art_control.campo1 <> art.campo1 OR
                art_control.campo2 <> art.campo2 OR art_control.campo3 <> art.campo3 OR
                art_control.campo4 <> art.campo4 OR art_control.campo5 <> art.campo5 OR
                art_control.campo6 <> art.campo6 OR art_control.campo7 <> art.campo7	OR
                art_control.campo8 <> art.campo8 OR art_control.ubicacion <> art.ubicacion OR
                art_control.co_precio <> art.co_precio OR art_control.monto <> art.monto OR
                art_control.tipo_imp <> art.tipo_imp OR art_control.co_alma <> art.co_alma OR
                art_control.stock <> art.stock OR art_control.tipoAlm <> art.tipoAlm OR
                art_control.anulado <> art.anulado OR art_control.cod_proc <> art.cod_proc OR
                art_control.item <> art.item OR art_control.co_uni <> art.co_uni OR
                art_control.porc_tasa <> art.porc_tasa OR art_control.fecha_reg <> art.fecha_reg OR
                art_control.tssit <>	art.tssit ) ";

    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
    
    //BEGIN INSERT-UPDATE ANDROID TABLE-----------------------------------------
    //REN INSERT:)
    $table2="tmitem";    
    $select2="tmitem.ItemCode, tmitem.ItemDesc,  tmitem.ItemUnit, tmitem.ItemRefe, tmitem.ItemStatus, tmitem.ItemPrec1,
        tmitem.ItemPrec2, tmitem.ItemPrec3, tmitem.ItemActCost, tmitem.ItemAverCost, tmitem.ItemLateCost, 
        tmitem.ItemRotation, tmitem.TaxCode, tmitem.LineCode, tmitem.ModeCode, tmitem.CateCode, tmitem.SublCode,
        tmitem.ColoCode, tmitem.TypeCode, tmitem.ItemDesc2, tmitem.ItemNote, tmitem.ItemUserCrea, tmitem.ItemDateCrea,
        tmitem.ItemUserModi, tmitem.ItemDateModi, tmitem.ItemSIT, tmitem.ItemImageDir, tmitem.ItemImageDirS,
        tmitem.ItemImageDirL, tmitem.ItemStockAct, tmitem.ItemSincStatus, tmitem.TaxRate "; 
    $values2="SELECT art_control.co_art,  art_control.art_des, art_control.co_uni, art_control.ref, art_control.anulado, art_control.prec_vta1,  art_control.prec_vta2, 
        art_control.prec_vta3, 0, 0,  0, 0, art_control.cod_proc,  art_control.co_lin, art_control.modelo, art_control.co_cat, art_control.co_subl, art_control.co_color, 
        art_control.tipo, art_control.comentario, 0,  0, 0, 0, 0, art_control.tssit, 0, 0, 0, art_control.stock, 1, art_control.porc_tasa 
        FROM art_control LEFT JOIN tmitem ON tmitem.ItemCode = art_control.co_art WHERE tmitem.ItemCode IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$values2);//into bd
    //UPDATE -------------------------------------------------------------------
    $table2 = " tmitem,  art_control";
    $values2 =" tmitem.ItemCode = art_control.co_art, tmitem.ItemDesc = art_control.art_des, 
        tmitem.ItemUnit = art_control.co_uni, tmitem.ItemRefe = art_control.ref, tmitem.ItemStatus = art_control.anulado, 
        tmitem.ItemPrec1 = art_control.prec_vta1, tmitem.ItemPrec2 = art_control.prec_vta2, 
        tmitem.ItemPrec3 = art_control.prec_vta3, tmitem.ItemActCost = 0, tmitem.ItemAverCost = 0, 
        tmitem.ItemLateCost = 0, tmitem.ItemRotation = 0, tmitem.TaxCode = art_control.cod_proc, 
        tmitem.LineCode = art_control.co_lin, tmitem.ModeCode = art_control.modelo, tmitem.CateCode = art_control.co_cat, 
        tmitem.SublCode = art_control.co_subl, tmitem.ColoCode = art_control.co_color, tmitem.TypeCode = art_control.tipo,
        tmitem.ItemDesc2 = art_control.comentario, tmitem.ItemNote = 0, tmitem.ItemUserCrea = 0,  
        tmitem.ItemDateCrea = 0, tmitem.ItemUserModi = 0, tmitem.ItemDateModi = 0, tmitem.ItemSIT = art_control.tssit, 
        tmitem.ItemImageDir = 0, tmitem.ItemImageDirS = 0, tmitem.ItemImageDirL = 0, 
        tmitem.ItemStockAct = art_control.stock, tmitem.ItemSincStatus = 2, tmitem.TaxRate = art_control.porc_tasa ";
    
    $where2 = "(TSSincStatus = 1) AND (art_control.co_art = tmitem.ItemCode) AND 
        (art_control.art_des <> tmitem.ItemDesc OR  art_control.co_uni <> tmitem.ItemUnit OR 
        art_control.ref <> tmitem.ItemRefe OR art_control.anulado <> tmitem.ItemStatus OR 
        art_control.prec_vta1 <> tmitem.ItemPrec1 OR art_control.prec_vta2 <> tmitem.ItemPrec2 OR 
        art_control.prec_vta3 <> tmitem.ItemPrec3 OR 0 <> tmitem.ItemActCost OR 0 <> tmitem.ItemAverCost OR 
        0 <> tmitem.ItemLateCost OR 0 <> tmitem.ItemRotation OR art_control.cod_proc <> tmitem.TaxCode OR
        art_control.co_lin <> tmitem.LineCode OR art_control.modelo <> tmitem.ModeCode OR 
        art_control.co_cat <> tmitem.CateCode OR art_control.co_subl <> tmitem.SublCode OR 
        art_control.co_color <> tmitem.ColoCode OR art_control.tipo <> tmitem.TypeCode OR 
        art_control.comentario <> tmitem.ItemDesc2 OR 0 <> tmitem.ItemNote OR 0 <> tmitem.ItemUserCrea OR 
        0 <> tmitem.ItemDateCrea OR 0 <> tmitem.ItemUserModi OR 0 <> tmitem.ItemDateModi OR 
        art_control.tssit <> tmitem.ItemSIT OR
        0 <> tmitem.ItemImageDir OR 0 <> tmitem.ItemImageDirS OR 0 <> tmitem.ItemImageDirL OR 
        art_control.stock <> tmitem.ItemStockAct OR 1 <> tmitem.ItemSincStatus OR 
        art_control.porc_tasa <> tmitem.TaxPercen )";    
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
     //END UPDATE ANDROID TABLE

    //SECUND UPDATE
    $table2 = " art_control";
    $values2 = " TSSincStatus = 2";
    $where2 = "TSSincStatus = 1 ";
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
        
    //DELETE FOR ALWAYS MANTENECE TABLE
    $select2=" MAX(art_controlId-100) AS art_controlId  ";    $table2="art_control";  $where2=""; $order2="";
    $MAXId=$ObjBdQ2->Query_Select_col($select2,$table2,$where2,$order2);
    $where2=" art_controlId < '".$MAXId["art_controlId"]."'";
    $MAXId=$ObjBdQ2->Query_Delete($table2, $where2);
  }break;    

//------------------------------------------------------------------------------
case 'clientes':{
    $table2="clientes";    
    $select2=" co_cli, cli_des, tipo_cli, limite, deuda, co_zon, co_ven, d1, d2, d3, d4,  d5, d6, d7, direc, telefonos,  rif, tip_cli, contrib, email,  "
           . "ciudad, co_pais, respons, inactivo,  tssit "; 
    $valores="SELECT clientes_control.co_cli, clientes_control.cli_des, clientes_control.tipo_cli, clientes_control.limite, clientes_control.deuda, 
                clientes_control.co_zon, clientes_control.co_ven, clientes_control.d1, clientes_control.d2, clientes_control.d3, clientes_control.d4, clientes_control.d5,
                clientes_control.d6, clientes_control.d7, clientes_control.direc, clientes_control.telefonos, clientes_control.rif, clientes_control.tip_cli, 
                clientes_control.contrib, clientes_control.email, clientes_control.ciudad, clientes_control.co_pais, clientes_control.respons, 
                clientes_control.inactivo, clientes_control.tssit
                FROM
                clientes_control Left Join clientes ON clientes_control.co_cli = clientes.co_cli
                WHERE  clientes.co_cli IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd
    
     //ONLY UPDATE clientes
    $table2 = " clientes, clientes_control";
    $values2 =" clientes.cli_des = clientes_control.cli_des,	
        clientes.tipo_cli = clientes_control.tipo_cli,	clientes.limite = clientes_control.limite,	
        clientes.deuda = clientes_control.deuda, clientes.co_zon = clientes_control.co_zon, 
        clientes.co_ven = clientes_control.co_ven, clientes.d1 = clientes_control.d1, clientes.d2 = clientes_control.d2,
        clientes.d3 = clientes_control.d3, clientes.d4 = clientes_control.d4, clientes.d5 = clientes_control.d5,	
        clientes.d6 = clientes_control.d6, clientes.d7 = clientes_control.d7, clientes.direc = clientes_control.direc,	
        clientes.telefonos = clientes_control.telefonos, clientes.rif = clientes_control.rif, 
        clientes.tip_cli = clientes_control.tip_cli, clientes.contrib = clientes_control.contrib, 
        clientes.email = clientes_control.email, clientes.ciudad = clientes_control.ciudad,	
        clientes.co_pais = clientes_control.co_pais, clientes.respons = clientes_control.respons,	
         clientes.inactivo = clientes_control.inactivo, clientes.tssit = clientes_control.tssit	 ";
    
    $where2 = "(TSSincStatus = 1) AND "
            . "(clientes_control.co_cli = clientes.co_cli) AND 
        (clientes_control.cli_des <> clientes.cli_des OR clientes_control.tipo_cli <> clientes.tipo_cli OR
        clientes_control.limite <> clientes.limite OR clientes_control.deuda <> clientes.deuda OR
        clientes_control.co_zon <> clientes.co_zon OR clientes_control.co_ven <> clientes.co_ven OR
        clientes_control.d1 <> clientes.d1 OR clientes_control.d2 <> clientes.d2 OR
        clientes_control.d3 <> clientes.d3 OR clientes_control.d4 <> clientes.d4 OR
        clientes_control.d5 <> clientes.d5 OR clientes_control.d6 <> clientes.d6 OR
        clientes_control.d7 <> clientes.d7 OR clientes_control.direc <> clientes.direc OR
        clientes_control.telefonos <> clientes.telefonos OR clientes_control.rif <> clientes.rif OR
        clientes_control.tip_cli <> clientes.tip_cli OR clientes_control.contrib <> clientes.contrib OR
        clientes_control.email <> clientes.email OR clientes_control.ciudad <> clientes.ciudad OR
        clientes_control.co_pais <> clientes.co_pais OR clientes_control.respons <> clientes.respons OR
        clientes_control.inactivo <> clientes.inactivo OR
        clientes_control.tssit <> clientes.tssit)";    
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);

    //BEFORE UPDATE ANDROID TABLE
    $table2="tmcustomer";    
    $select2=" tmcustomer.CustCode, tmcustomer.CustDesc, tmcustomer.CustDirF, tmcustomer.CustRIF, tmcustomer.CustTele, tmcustomer.CustEmail, tmcustomer.CustStatus,
		tmcustomer.CustZone, tmcustomer.CustCountry, tmcustomer.CustCity, tmcustomer.CustBalance, tmcustomer.CustSIT, tmcustomer.SellCode,  tmcustomer.CustType,
		tmcustomer.CustSincStatus, tmcustomer.CustTaxPayer, tmcustomer.CustRespons "; 
		
    $valores="SELECT clientes_control.co_cli, clientes_control.cli_des, clientes_control.direc, clientes_control.rif, clientes_control.telefonos, clientes_control.email,
                clientes_control.inactivo, clientes_control.co_zon, clientes_control.co_pais, clientes_control.ciudad, clientes_control.deuda, clientes_control.tssit, 
		clientes_control.co_ven, clientes_control.tip_cli, clientes_control.TSSincStatus, clientes_control.contrib, clientes_control.respons 
              FROM clientes_control Left Join tmcustomer ON clientes_control.co_cli = tmcustomer.CustCode
	      WHERE  clientes_control.TSSincStatus = 1 AND tmcustomer.CustCode IS NULL ; "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd
    
//UPDATE    
    $table2 = " tmcustomer, clientes_control";
    $values2 =" tmcustomer.CustDesc = clientes_control.cli_des, tmcustomer.CustDirF = clientes_control.direc, tmcustomer.CustRIF = clientes_control.rif,
        tmcustomer.CustTele = clientes_control.telefonos, tmcustomer.CustEmail = clientes_control.email, tmcustomer.CustStatus = clientes_control.inactivo,
        tmcustomer.CustZone = clientes_control.co_zon, tmcustomer.CustCountry = clientes_control.co_pais, tmcustomer.CustCity = clientes_control.ciudad,
        tmcustomer.CustBalance = clientes_control.deuda, tmcustomer.CustSIT = clientes_control.tssit, tmcustomer.SellCode = LTRIM(RTRIM(clientes_control.co_ven)),
        tmcustomer.CustType = clientes_control.tip_cli, tmcustomer.CustSincStatus = 2, tmcustomer.CustTaxPayer = clientes_control.contrib,
        tmcustomer.CustRespons = clientes_control.respons ";
    
    $where2 = "(clientes_control.TSSincStatus = 1) AND (clientes_control.co_cli = tmcustomer.CustCode) AND 
                (clientes_control.cli_des <> tmcustomer.CustDesc OR clientes_control.direc <> tmcustomer.CustDirF OR
                clientes_control.rif <> tmcustomer.CustRIF OR clientes_control.telefonos <> tmcustomer.CustTele OR
                clientes_control.email <> tmcustomer.CustEmail OR clientes_control.inactivo <> tmcustomer.CustStatus OR
                clientes_control.co_zon <> tmcustomer.CustZone OR clientes_control.co_pais <> tmcustomer.CustCountry OR
                clientes_control.ciudad <> tmcustomer.CustCity OR clientes_control.deuda <> tmcustomer.CustBalance OR
                clientes_control.tssit <> tmcustomer.CustSIT OR clientes_control.co_ven <> tmcustomer.SellCode OR
                clientes_control.tip_cli <> tmcustomer.CustType OR clientes_control.contrib <> tmcustomer.CustTaxPayer OR
                clientes_control.respons <> tmcustomer.CustRespons)";    
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
    //END UPDATE ANDROID TABLE TMCUSTOMER

    //SECUND UPDATE
    $table2 = " clientes_control";
    $values2 = " TSSincStatus = 2";
    $where2 = "TSSincStatus = 1 ";
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);    
    
    //DELETE FOR ALWAYS MANTENECE TABLE
    $select2=" MAX(clientes_controlId-100) AS clientes_controlId  ";    $table2="clientes_control";  
    $where2=""; $order2="";
    $MAXId=$ObjBdQ2->Query_Select_col($select2,$table2,$where2,$order2);
    $where2=" clientes_controlId < '".$MAXId["clientes_controlId"]."'";
    $MAXId=$ObjBdQ2->Query_Delete($table2, $where2);

}break;
//END clientes------------------------------------------------------------------    

//BEGIN tipoprecio_control -----------------------------------------------------
case 'tipoprecio':{
    $table2="tipoprecio";    
    $select2=" co_precio, des_precio, incluye_imp, campo1, campo2, campo3, campo4, campo5, campo6, campo7, campo8, tssit "; 
    $valores="SELECT  tipoprecio_control.co_precio,  tipoprecio_control.des_precio, tipoprecio_control.incluye_imp, tipoprecio_control.campo1, tipoprecio_control.campo2,
              tipoprecio_control.campo3, tipoprecio_control.campo4, tipoprecio_control.campo5, tipoprecio_control.campo6, tipoprecio_control.campo7, tipoprecio_control.campo8, 
              tipoprecio_control.tssit FROM tipoprecio_control LEFT JOIN tipoprecio ON tipoprecio_control.co_precio = tipoprecio.co_precio
              WHERE  tipoprecio.co_precio IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd
            
    //ONLY UPDATE tipoprecio
    $table2 = " tipoprecio, tipoprecio_control";
    $values2 =" tipoprecio.des_precio = tipoprecio_control.des_precio, 
        tipoprecio.incluye_imp = tipoprecio_control.incluye_imp,tipoprecio.campo1 = tipoprecio_control.campo1,
        tipoprecio.campo2 = tipoprecio_control.campo2,tipoprecio.campo3 = tipoprecio_control.campo3,
        tipoprecio.campo4 = tipoprecio_control.campo4,tipoprecio.campo5 = tipoprecio_control.campo5,
        tipoprecio.campo6 = tipoprecio_control.campo6,tipoprecio.campo7 = tipoprecio_control.campo7,
        tipoprecio.campo8 = tipoprecio_control.campo8,tipoprecio.tssit = tipoprecio_control.tssit";
    
    $where2 = "(TSSincStatus = 1) AND "
            . "(tipoprecio.co_precio = tipoprecio_control.co_precio) AND (tipoprecio.des_precio <> tipoprecio_control.des_precio OR
        tipoprecio.incluye_imp <> tipoprecio_control.incluye_imp OR tipoprecio.campo1 <> tipoprecio_control.campo1 OR
        tipoprecio.campo2 <> tipoprecio_control.campo2 OR tipoprecio.campo3 <> tipoprecio_control.campo3 OR
        tipoprecio.campo4 <> tipoprecio_control.campo4 OR tipoprecio.campo5 <> tipoprecio_control.campo5 OR
        tipoprecio.campo6 <> tipoprecio_control.campo6 OR tipoprecio.campo7 <> tipoprecio_control.campo7 OR
        tipoprecio.campo8 <> tipoprecio_control.campo8 OR tipoprecio.tssit <> tipoprecio_control.tssit)";    
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
    //INSERT UPDATE ANDROID TABLE
    
    //SECUN UPDATE
    $table2 = " tipoprecio_control";
    $values2 = " TSSincStatus = 2";
    $where2 = "TSSincStatus = 1 ";
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);    
    
    //DELETE FOR ALWAYS MANTENECE TABLE
    $select2=" MAX(tipoprecioId-100) AS tipoprecioId  ";    $table2="tipoprecio_control";  
    $where2=""; $order2="";
    $MAXId=$ObjBdQ2->Query_Select_col($select2,$table2,$where2,$order2);
    $where2=" tipoprecioId < '".$MAXId["tipoprecioId"]."'";
    $MAXId=$ObjBdQ2->Query_Delete($table2, $where2);
    
    
    
}break;
//END tipoprecio_control--------------------------------------------------------    
//BEGIN vendedor -----------------------------------------------------
case 'vendedor':{
    $table2="vendedor";    
    $select2=" co_ven,tipo,ven_des,inactivo,email,tssit "; 
    $valores="SELECT vendedor_control.co_ven,vendedor_control.tipo,vendedor_control.ven_des,vendedor_control.inactivo,
                     vendedor_control.email,vendedor_control.tssit
              FROM vendedor_control LEFT JOIN vendedor ON vendedor_control.co_ven = vendedor.co_ven
              WHERE  vendedor.co_ven IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd
    
    $table2 = " vendedor, vendedor_control";
    $values2 =" vendedor.tipo = vendedor_control.tipo, vendedor.ven_des = vendedor_control.ven_des,
				vendedor.inactivo = vendedor_control.inactivo, vendedor.email = vendedor_control.email,
				vendedor.tssit = vendedor_control.tssit ";
    $where2 = "(TSSincStatus = 1) AND "
            . "(vendedor_control.co_ven = vendedor.co_ven) AND 
			(vendedor_control.tipo	<>	 vendedor.tipo OR vendedor_control.ven_des	<>	 vendedor.ven_des OR
			 vendedor_control.inactivo	<>	 vendedor.inactivo OR vendedor_control.email	<>	 vendedor.email OR
			 vendedor_control.tssit	<>	 vendedor.tssit )";     
    
     //BEFORE UPDATE ANDROID TABLE
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
    //SECUN UPDATE
    $table2 = " vendedor_control";
    $values2 = " TSSincStatus = 2";
    $where2 = "TSSincStatus = 1 ";
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);   
    
    

    //DELETE FOR ALWAYS MANTENECE TABLE
    $select2=" MAX(vendedorId-100) AS vendedorId  ";    $table2="vendedor_control";  
    $where2=""; $order2="";
    $MAXId=$ObjBdQ2->Query_Select_col($select2,$table2,$where2,$order2);
    $where2=" vendedorId < '".$MAXId["vendedorId"]."'";
    $MAXId=$ObjBdQ2->Query_Delete($table2, $where2);
           
}break;
//END vvendedor


//BEGIN artunidad -----------------------------------------------------
case 'artunidad':{
    $table2="artunidad";    
    $select2=" co_art, co_uni, relacion, equivalencia, uso_venta, uso_compra, uni_principal,
					uso_principal, uni_secundaria, uso_secundaria,tssit "; 
    $valores="SELECT artunidad_control.co_art, artunidad_control.co_uni,
				artunidad_control.relacion,artunidad_control.equivalencia,artunidad_control.uso_venta,
				artunidad_control.uso_compra,artunidad_control.uni_principal,artunidad_control.uso_principal,
				artunidad_control.uni_secundaria, artunidad_control.uso_secundaria,artunidad_control.tssit
	 FROM artunidad_control 
            LEFT JOIN artunidad ON artunidad_control.co_art = artunidad.co_art 
                                    AND artunidad_control.co_uni = artunidad.co_uni
         WHERE  artunidad.co_art IS NULL AND artunidad.co_uni IS NULL "; 				
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd
    
    $table2 = " artunidad, artunidad_control";
    $values2 =" artunidad.relacion = artunidad_control.relacion, artunidad.equivalencia = artunidad_control.equivalencia,
		artunidad.uso_venta = artunidad_control.uso_venta, artunidad.uso_compra = artunidad_control.uso_compra,
		artunidad.uni_principal = artunidad_control.uni_principal, artunidad.uso_principal = artunidad_control.uso_principal,
		artunidad.uni_secundaria = artunidad_control.uni_secundaria, 
		artunidad.uso_secundaria = artunidad_control.uso_secundaria,artunidad.tssit = artunidad_control.tssit ";

    $where2 = "(artunidad_control.TSSincStatus = 1) AND "
		. "(artunidad_control.co_art = artunidad.co_art) AND "
		. "(artunidad_control.co_uni = artunidad.co_uni) AND 
		(artunidad_control.relacion <> artunidad.relacion	OR
		artunidad_control.equivalencia <> artunidad.equivalencia	OR artunidad_control.uso_venta <> artunidad.uso_venta	OR
		artunidad_control.uso_compra <> artunidad.uso_compra	OR artunidad_control.uni_principal <> artunidad.uni_principal	OR
		artunidad_control.uso_principal <> artunidad.uso_principal	OR artunidad_control.uni_secundaria <> artunidad.uni_secundaria	OR
		artunidad_control.uso_secundaria <> artunidad.uso_secundaria	OR artunidad_control.tssit <> artunidad.tssit	 )";     
    
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
     //BEFORE INSERT - INIUPDATE ANDROID TABLE
    $table2="tmitemu";    
    $select2=" ItemuCode, UnitCode, Relationship, Equivalence, UseVenta, UsePurchase, MainUnit, PrimaryUse, SecundaryUnit, SecundaryUse, tssit, TSSincStatus "; 
    $valores="SELECT artunidad_control.co_art, artunidad_control.co_uni, artunidad_control.relacion, artunidad_control.equivalencia,
                artunidad_control.uso_venta, artunidad_control.uso_compra, artunidad_control.uni_principal, artunidad_control.uso_principal, artunidad_control.uni_secundaria,
		artunidad_control.uso_secundaria, artunidad_control.tssit, artunidad_control.TSSincStatus 
               FROM artunidad_control 
                    LEFT JOIN tmitemu ON artunidad_control.co_art = tmitemu.ItemuCode AND artunidad_control.co_uni = tmitemu.UnitCode
              WHERE  tmitemu.ItemuCode IS NULL "; 
    $r2=$ObjBdQ2->Query_Insert_SELECT($table2,$select2,$valores);//into bd

    $table2 = " tmitemu, artunidad_control";
    $values2 =" tmitemu.Relationship =artunidad_control.relacion, tmitemu.Equivalence =artunidad_control.equivalencia, tmitemu.UseVenta =artunidad_control.uso_venta, 
        tmitemu.UsePurchase =artunidad_control.uso_compra, tmitemu.MainUnit =artunidad_control.uni_principal, tmitemu.PrimaryUse =artunidad_control.uso_principal, 
        tmitemu.SecundaryUnit =artunidad_control.uni_secundaria, tmitemu.SecundaryUse =artunidad_control.uso_secundaria, tmitemu.tssit =artunidad_control.tssit ";				
    $where2 = "(artunidad_control.TSSincStatus = 1) AND 
               (artunidad_control.co_art = tmitemu.ItemuCode) AND 
               (tmitemu.UnitCode = artunidad_control.co_uni) AND 
               (tmitemu.Relationship <> artunidad_control.relacion OR tmitemu.Equivalence <> artunidad_control.equivalencia OR 
                tmitemu.UseVenta <> artunidad_control.uso_venta OR tmitemu.UsePurchase <> artunidad_control.uso_compra OR 
                tmitemu.MainUnit <> artunidad_control.uni_principal OR tmitemu.PrimaryUse <> artunidad_control.uso_principal OR 
                tmitemu.SecundaryUnit <> artunidad_control.uni_secundaria OR tmitemu.SecundaryUse <> artunidad_control.uso_secundaria OR 
                tmitemu.tssit <> artunidad_control.tssit) ";		
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);
    
    //SECUN UPDATE
    $table2 = " artunidad_control";
    $values2 = " TSSincStatus = 2";
    $where2 = "TSSincStatus = 1 ";
    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);   
    
    

    //DELETE FOR ALWAYS MANTENECE TABLE
    $select2=" MAX(ArtUnidadId-100) AS ArtUnidadId  ";    $table2="artunidad_control";  
    $where2=""; $order2="";
    $MAXId=$ObjBdQ2->Query_Select_col($select2,$table2,$where2,$order2);
    $where2=" ArtUnidadId < '".$MAXId["ArtUnidadId"]."'";
    $MAXId=$ObjBdQ2->Query_Delete($table2, $where2);
           
}break;
//END artunidad



       }//END SWITCH---------------------------------------------------------------
    return $r;
    }
	    //--------------------------------------------------------------------------
    function TSBdQueryProcedureALastSinc($sUp,$tsls,$UserId){//UPDATE LAST SINC THE ANDROID
       $r="";
        $r2="";
        $ObjBdQ2= new BdQuery(); 
        switch ($sUp){
            ////////////////////////////////////////////////////////////////////
            case 'tmcustomer':{//UPDATE LAST SINC THE ANDROID
                $rtslsR=explode(';',$tsls);
                $i=0;
                while($i<(count($rtslsR)-1)){
                    $table2 = " tmcustomer";
                    //TS say: original funcionando edgar 22082017;  $values2 = " CustSincStatus = 3";
					$values2 = " CustSincStatus = 1, SellCode = rtrim(ltrim(SellCode)) ";
					
                    //$where2 = "CustSIT = '".$rtslsR[$i]."'";
					$where2 = "SellCode = '".$UserId."' AND CustSIT = '".$rtslsR[$i]."'";
                    $r2=$ObjBdQ2->Query_Update($table2, $values2, $where2);  
                    $r.=$rtslsR[$i]."|";
                    $i++;   
                   }
            }break;
			
        }return $r;
    }
}

?>