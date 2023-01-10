<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>DPVale Devoluciones</title>
    <style>
            .bloque1{
                  height: 7em;
            }

            .buscar{
                  margin: 1em auto;
            }
            .col-centered{
                margin: 0 auto;
                float: none;
            }
            .firma{
            /*  height: 150px;
              width: auto;
              background-color: white;*/
              width: 100%;
              height: 100%;
            }
            .firma img{
              /*display: block;
              margin: auto;*/
              width: 100%;
              height: 100%;
            }
            .help-block {
                margin-bottom: -10px;
            }
            body{
              padding-top: 5px;
            }
            .info_descripcion{
              font-size: 1.5em;
              margin: -5px -5px 0 0;
            }
            .info_credito{
              font-size: 1.5em;
              margin: -5px -5px 0 0;
            }
            .info-canjeante{
              font-size: 1.5em;
              margin: -7px -5px 0 0;
            }
            .Habilitado{
              color: green;
            }
            .Deshabilitado{
              color:red;
            }
            .Bloqueado{
              color:red;
            }
            .font-up{
              font-size: 24px;
            }
            .fix-input-margen{
              margin-top: -17px;
            }
            .form-horizontal .form-group {margin-left: 0;margin-right:0;}
            .celda_promo{
              font-size: 1.5em;
            }
            .alert{
              color:red;
              font-size: 1.5em;
            }
            .mensaje_tecnico{
              margin-top: -10px;
              background-color: beige;
            }
      </style>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="col-md-3 col-xs-3 col-sm-3 " style="padding-left:25px;">
            <h3>DPVale Devoluciones</h3>
          </div>
          <div class="col-md-3 col-xs-3 col-sm-3 " style="padding-left:25px;">
            <h3>
              <div class="form-group">
                <label class="col-lg-12 control-label" style="text-align: center;font-weight: normal;">Tienda</label>
                <div class="col-lg-12" style="text-align: center;">
                  <label class="control-label" id="numerotienda" style="font-weight: normal;"> <?php echo $devolucion['tienda']; ?></label>

                  <input type="hidden" name="" id="numcalletienda" value="<?php echo $devolucion['callenumtienda']; ?>">
                  <input type="hidden" name="" id="coloniatienda" value="<?php echo $devolucion['coltienda']; ?>">
                  <input type="hidden" name="" id="nombretienda" value="<?php echo $devolucion['nombretienda']; ?>">
                  <input type="hidden" name="" id="cptienda" value="<?php echo $devolucion['cptienda']; ?>">
                  <input type="hidden" name="" id="telefonotienda" value="<?php echo $devolucion['telefonotienda']; ?>">
                  <input type="hidden" name="" id="ciudadtienda" value="<?php echo $devolucion['ciudadtienda']; ?>">
                  <input type="hidden" name="" id="estadotienda" value="<?php echo $devolucion['estadotienda']; ?>">
                  <input type="hidden" name="" id="vendedortienda" value="<?php echo $devolucion['vendedortienda']; ?>">
                  <input type="hidden" name="" id="plazatienda" value="<?php echo $devolucion['plaza']; ?>">
                  <input type="hidden" name="" id="plataformatienda" value="<?php echo $devolucion['plataforma']; ?>">
                </div>
              </div>
            </h3>
          </div>
          <div class="col-md-3 col-xs-3 col-sm-3 " style="padding-left:25px;">
            <h3>
              <div class="form-group">
                <label class="col-lg-12 control-label" style="text-align: center;font-weight: normal;">Caja</label>
                <div class="col-lg-12" style="text-align: center;">
                  <label class="control-label" id="numerocaja" style="font-weight: normal;"><?php echo $devolucion['caja']; ?></label>
                </div>
              </div>
            </h3>
          </div>
          <div class="col-md-3 col-xs-3 col-sm-3">
            <img src="<?= base_url("/assets/imgs/grupo_dp.png")?>" class="pull-right" style="width: 177px;height: 56px;margin-top:10px;">
          </div>
        </div>
      </div>
      <hr class="divider-title" style="margin-top: 10px;">
      <div class="panel panel-default">
        <div class="form-group" style="text-align: center; padding: 40px;">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" role="form">
                <h3>
                  <div class="form-group">
                    <label class="col-lg-5 control-label">Folio Vale:</label>
                    <div class="col-lg-5">
                      <label class="control-label" id="FolioVale"><?php echo $devolucion['folio']; ?></label>
                    </div>
                  </div>
                </h3>
                <h3>
                  <div class="form-group">
                    <label class="col-lg-5 control-label">Monto:</label>
                    <div class="col-lg-5">
                      <label class="control-label" id="MontoVale"><?php echo $devolucion['monto']; ?></label>
                    </div>
                  </div>
                </h3>
                <div class="form-group">
                  <div class="botones">
                    <br><br>
                    <button type="button" class="btn btn-block btn-danger pull-right btn-lg" id="cancelar"><span class="glyphicon glyphicon-retweet"></span> APLICAR DEVOLUCIÓN </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div id="ticket_content" class="modal-body">
            </div>
          </div>
        </div>
      </div>

  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.66.0-2013.10.09/jquery.blockUI.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.formatCurrency-1.4.0.min.js')?>"></script>
  <script type="text/javascript">
  function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    demoAbout(printcontent);
    setTimeout(function(){pantallaimprimir(restorepage);}, 1000);

    //
  }

  function pantallaimprimir(restorepage){

    //window.print();
    document.body.innerHTML = restorepage;

    mensaje(0, "Nuevo Cupon generado", "",true);
  }

  function mensaje(tipo, msj, campo, confirmar=false){
    if(tipo == 1){var titulo = '¡Aviso!';var color = 'red';
    }else if (tipo == 0){var titulo = 'Movimiento Exitoso';var color = 'green';
    }else if (tipo== 2) {var titulo = 'Atención'; var color = 'orange';
    }
    $.confirm({
        title: titulo,content: msj,type: color,typeAnimated: true,buttons:{Aceptar: {
            keys: ['enter', 'esc'],
            action: function () {
              if(confirmar){
                 window.setTimeout('location.reload()', 500);
              }}}}});
  }
  $( document ).ready(function() {
    var arr =  new Array();
    var arr_json =  new Array();
    var json_enviar;
    plataformatienda = $('#plataformatienda').val();
    $('#cancelar').click(function(){
      var conterror = 0;
      var idcliente, idCoupon, msj = "";
      var folio = $('#FolioVale').html();
      var monto = $('#MontoVale').html();
      var nombretienda = $('#nombretienda').html();
      var numerotienda = $('#numerotienda').html();
      var numerocaja = $('#numerocaja').html();

      var numcalletienda = $('#numcalletienda').val();
      if(numcalletienda == "" || numcalletienda == null){
        numcalletienda = "";
      }
      var coloniatienda = $('#coloniatienda').val();
      if(coloniatienda == "" || coloniatienda == null){
        coloniatienda = "";
      }

      var cptienda = $('#cptienda').val();
      if(cptienda == "" || cptienda == null){
        cptienda = "";
      }

      var telefonotienda = $('#telefonotienda').val();
      if(telefonotienda == "" || telefonotienda == null){
        telefonotienda = "";
      }

      var ciudadtienda = $('#ciudadtienda').val();
      if(ciudadtienda == "" || ciudadtienda == null){
        ciudadtienda = "";
      }

      var estadotienda = $('#estadotienda').val();
      if(estadotienda == "" || estadotienda == null){
        estadotienda = "";
      }

      var vendedortienda = $('#vendedortienda').val();
      if(vendedortienda == "" || vendedortienda == null){
        vendedortienda = "";
      }

      var nombretienda = $('#nombretienda').val();
      if(nombretienda == "" || nombretienda == null){
        nombretienda = "";
      }
      if(conterror < 3){
        try {
          $.ajax({
            method: "GET",
            dataType: "json",
            url: "<?=base_url('dpvale_devolucion/devoluciones/getvale');?>",
            data: {folio: folio,token: "<?php echo $hash; ?>"},
            beforeSend: function() {
              $.blockUI({ message: '<h2>Espere un momento...</h2>' });
            },
            success: function( data ) {
              if(data.response.ErrorMessage){
                //mensaje(1,data.response.ErrorMessage.Detalle,"");
                mensaje(1,"ERROR","");
              }else{
                idcoupon = data.response.coupon.idCustomer;
                idcliente = data.response.distributor.number;
                if(data.response.distributor.name == "" || data.response.distributor.name == null){
                  nombre_distribuidor = "";
                }else{
                  nombre_distribuidor = data.response.distributor.name;
                }

                if(data.response.distributor.middleName == "" || data.response.distributor.middleName == null){
                  segundo_nombre_distribuidor = "";
                }else{
                  segundo_nombre_distribuidor = data.response.distributor.middleName;
                }

                if(data.response.distributor.lastName == "" || data.response.distributor.lastName == null){
                  apellido_distribuidor = "";
                }else{
                  apellido_distribuidor = data.response.distributor.lastName;
                }

                if(data.response.distributor.secondLastName == "" || data.response.distributor.secondLastName == null){
                  segundo_apellido_distribuidor = "";
                }else{
                  segundo_apellido_distribuidor = data.response.distributor.secondLastName;
                }

                if(data.response.purchases == null){
                  var pagos_quincenales = 0;
                }else{
                  var pagos_quincenales = data.response.purchases[0].insurance;
                }

                if(idcoupon == null || idcoupon == ""){
                  idcoupon = 0;
                }
                  arr = [{"idCustomer": idcoupon, "folio_distribuidor": data.response.distributor.number, "distribuidor_nombre": nombre_distribuidor, "distribuidor_segundo_nombre": segundo_nombre_distribuidor, "distribuidor_apellido": apellido_distribuidor, "distribuidor_segundo_apellido": segundo_apellido_distribuidor, "valeOrigen":folio, "idcoupon":idcoupon,"idcliente":idcliente,"calle": data.response.branch.street, "numero": data.response.branch.number, "colonia": data.response.branch.neighborhood, "city": data.response.branch.name, "folio_canjeante": data.response.coupon.idCustomer, "pagos_quincenales": pagos_quincenales , "quincenas": data.response.amortizationsPurchase.length, "nombre_tienda": nombretienda, "calle_num_tienda": numcalletienda, "colonia_tienda": coloniatienda, "cptienda": cptienda, "telefonotienda": telefonotienda, "ciudadtienda": ciudadtienda, "estadotienda": estadotienda, "vendedortienda": vendedortienda, "nombretienda": nombretienda, "firma": data.response.distributor.signature, "monto": monto, "importeOrig": data.response.coupon.purchasedPmount,"CA":"","numerotienda": numerotienda, "numerocaja": numerocaja}];
                  switch (data.response.status) {
                    case 0:
                      msj = "Servicio no disponible";
                      break;
                    case 1:
                      msj = "Venta almacenada";
                      break;
                    case 2:
                      msj = "Devolución registrada";
                      break;
                    case 3:
                      msj = "Timeout";
                      break;
                    case 4:
                      msj = "Error";
                      break;
                    case 5:
                      msj = "Acción Cancelada";
                      break;
                    case 6:
                      msj = "Rechazado";
                      break;
                  }
                  var res = folio.substring(folio.length - 4, folio.length);
                  res = 'XXXXXXXXX'+res;
                  json_enviar = {"Status": data.response.status, "Msg": msj, "No_tarjeta": res, "Fecha_venc": data.response.coupon.expirationDate, "Informativo": "", "FormaDePago": "DPVale", "HTML_R":""};
                    $.confirm({
                      title: 'Atención!',
                      content: '¿Deseas proceder con su devolución?',
                      type: 'orange',
                      typeAnimated: true,
                      buttons: {
                          OK: {
                              action: function(){
                                if(devolucion(folio, monto, idcliente)){
                                  $.confirm({
                                    title: 'Movimiento Exitoso!',
                                    content: '',
                                    type: 'green',
                                    typeAnimated: true,
                                    buttons: {
                                        OK: {
                                          action: function(){
                                            revale(folio, monto, idcoupon);
                                          }
                                        }
                                      }
                                  });
                                }
                              }
                          },
                          Cancelar: function () {
                            mensaje(1,"<h2>Se canceló la operación<h2>","");
                          }
                      }
                    });
                }

            },
            error: function ( data ) {
              mensaje(1,"Error al completar la operación, favor de ponerse en contacto con soporte","");
              $.unblockUI();
            },
            complete: function() {
              $.unblockUI();;
            }
        });
        }catch(err){
          mensaje(1,"error2","");
          conterror = conterror + 1;
        }
      }

    });

    function devolucion(folio, monto, idcliente){
      var res = false;
      if(folio == ""){
        mensaje(1, "El valor folio se mandó vacio","");
      }

      if(monto == ""){
        mensaje(1, "El valor monto se mandó vacio","");
      }

      if(idcliente == ""){
        mensaje(1, "El id del cliente se mandó vacio","");
      }

      $.ajax({
        async: false,
        method: "GET",
        dataType: "json",
        url: "<?php echo base_url('/dpvale_devolucion/devoluciones/devolucion') ?>",
        data: {folio: folio,monto: monto, idcliente:idcliente},
        beforeSend: function() {
          $.blockUI({ message: '<h2>Espere un momento...</h2>',timeout: 30 });
        },
        success: function( data ) {
          if(data.response.ErrorMessage){
            mensaje(1, data.response.ErrorMessage.msn,"");
              res = false;
          }
          else if(data.response.status == 1){
            json_enviar.CA =  data.response.devolution;
            arr[0]['CA']= data.response.devolution;
            res = true;
          }
        },
        error: function ( data ) {
          mensaje(1,"Error al completar la operación, favor de ponerse en contacto con soporte","");
        },
        complete: function() {
          $(document).ajaxStop($.unblockUI);
        }
      });

      return res;
    }

    function revale(folio, monto, idcliente){
        $.confirm({
          title: 'Atención!',
          content: '¿Quieres Revale?',
          type: 'orange',
          typeAnimated: true,
          buttons: {
              SI: {
                  action: function(){
                    crearrevale(folio, monto, idcliente);
                  }
              },
              NO: {
                action: function () {
                  imprimirdevolucion();
                }
              }
          }
        });
    }

    function imprimirdevolucion(){
      var jsonString = JSON.stringify(arr);
      console.log('desde imprimirdevolucion: ',jsonString);
      $.ajax({
        method: "GET",
        url: "<?php echo base_url('dpvale_devolucion/devoluciones/imprimirdevolucion') ?>",
        data: {'array': jsonString},
        beforeSend: function() {
          $.blockUI({ message: '<h2>Espere un momento...</h2>',timeout: 30 });
        },
        success: function( data ) {
          console.log(data);
          if(plataformatienda.toLowerCase() == "pruebas"){
            document.getElementById("ticket_content").innerHTML = data;
            printContent('ticket_content');
          }else if (plataformatienda.toLowerCase() == "aptos") {
          //  json_enviar.HTML_T = data;
            RespuestaApi(data);
            $.blockUI({ message: '<h2>DEVOLUCIÓN EXITOSA!!</h2><br><small>para otra devolucion es necesario presionar el boton de cancelar transaccion</small>' });
          }else if (plataformatienda.toLowerCase() == "ec"){
          //  json_enviar.HTML_T = data;
            parent.postMessage(data,'*');
            $.blockUI({ message: '<h2>DEVOLUCIÓN EXITOSA!!</h2><br><small>para otra devolucion es necesario presionar el boton de cancelar transaccion</small>' });
          }else{
            mensaje(1,"No se eligió plataforma","");
          }
        },
        error: function ( data ) {
          $(document).ajaxStop($.unblockUI);
          mensaje(1,"Error al completar la operación, favor de ponerse en contacto con soporte","");
        },
        complete: function() {
          //$(document).ajaxStop($.unblockUI);
        }
      });
    }

    function crearrevale(folio, monto, idcoupon){
      var telefonotienda = $('#telefonotienda').val();
      if(telefonotienda == "" || telefonotienda == null){
        telefonotienda = "";
      }

      var plazatienda = $('#plazatienda').val();
      if(plazatienda == "" || plazatienda == null){
        plazatienda = "";
      }
      $.ajax({
        async: false,
        method: "GET",
        dataType: "json",
        url: "<?php echo base_url('/dpvale_devolucion/devoluciones/setRevale') ?>",
        data: {folio: folio,monto: monto, idcliente:idcoupon},
        success: function( data ) {
          if(data == "0"){
            mensaje(1, "Error, faltan datos","");
          }
          else if(data.response.status == 1){
            arr.push({"plazatienda": plazatienda, "telefonotienda": telefonotienda, "folio": data.response.coupon.id ,"fecha_emision": data.response.coupon.issuedDate, "fecha_exp": data.response.coupon.expirationDate, "id_customer": data.response.customer.id, "name_customer": data.response.customer.name, "middleName_customer": data.response.customer.middleName, "lastName_customer": data.response.customer.lastName, "secondLastName_customer": data.response.customer.secondLastName});
            imprimir();
          }else{
            mensaje(1, data.response.ErrorMessage.msn, "");
          }
        },
        error: function ( data ) {
          mensaje(1,"Error al completar la operación, favor de ponerse en contacto con soporte","");
        }
      });
    }

    function imprimir(){
      var jsonString = JSON.stringify(arr);
      console.log('desde IMPRIMIR',jsonString);
      var arr_json_imprimir =  new Array();
      $.ajax({
        async: false,
        method: "GET",
        dataType: "html",
        url: "<?php echo base_url('/dpvale_devolucion/devoluciones/imprimir') ?>",
        data: {'array': jsonString},
        success: function( data ) {
          if(plataformatienda.toLowerCase() == "pruebas"){
              $('#ticket_content').html(data);
              printContent('ticket_content');
          }else if (plataformatienda.toLowerCase() == "aptos") {
            //  json_enviar.HTML_T = data;
              RespuestaApi(data);
              $.blockUI({ message: '<h2>DEVOLUCIÓN EXITOSA!!</h2><br><small>para otra devolucion es necesario presionar el boton de cancelar transaccion</small>' });
          }else if (plataformatienda.toLowerCase() == "ec"){
            //  json_enviar.HTML_T = data;
              //parent.RespuestaApi(json_enviar);
              parent.postMessage(data,'*');
              $.blockUI({ message: '<h2>DEVOLUCIÓN EXITOSA!!</h2><br><small>para otra devolucion es necesario presionar el boton de cancelar transaccion</small>' });
          }else {
            mensaje(1,"No se eligió plataforma","");
          }
        },
        error: function ( data ) {
          mensaje(1,"Error al completar la operación, favor de ponerse en contacto con soporte","");
        }
      });
    }
  });
  </script>
</html>
