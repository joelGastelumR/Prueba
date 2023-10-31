<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style>
      body{
        margin-top: 0rem;
      }
      .logo{
        height: 100px;
        width: 120px;
      }
      .logo2{
        margin-top: 10px;
        height: 40px;
        width: 150px;
        margin-bottom: 10px;
      }
      .titulo{
        margin-top: 25px;
      }

      .footer {
        background-color: #f5f5f5;
      }
      footer {
          position: fixed;
          height: 50px;
          bottom: 0;
          width: 100%;
          -webkit-border-radius: 10px;
      }
      .separador{
        top:5px;
        bottom: 5px;
      }
      .separador2{
        top:10px;
        bottom: 5px;
      }
      .separador3{
        top:15px;
        bottom: 5px;
      }
      .mensaje{
        font-weight: bold;
        margin-bottom: -5px;
      }
      .folio{
        font-size: 18px;
        font-weight: bold;
      }
      .mensaje_pago{
        margin-bottom: 3px;
      }
      #lbl_mensaje{
        margin-top: -15px;
      }
      .thank-you-pop{
      	width:100%;
       	/*padding:20px;*/
       	padding:5px;
      	text-align:center;
      }
      .thank-you-pop img{
      	width:56px;
      	height:auto;
      	margin:0 auto;
      	display:block;
      	margin-bottom:25px;
      }

      .thank-you-pop h1{
      	font-size: 32px;
          margin-bottom: 25px;
      	color:#5C5C5C;
      }
      .thank-you-pop p{
      	font-size: 20px;
        margin-bottom: 27px;
       	color:#5C5C5C;
      }
      .thank-you-pop h3.cupon-pop{
      	font-size: 18px;
          margin-bottom: 40px;
      	color:#222;
      	display:inline-block;
      	text-align:center;
      	padding:10px 20px;
      	border:2px dashed #222;
      	clear:both;
      	font-weight:normal;
      }
      .thank-you-pop h3.cupon-pop span{
      	color:#03A9F4;
      }
      .thank-you-pop a{
      	display: inline-block;
          margin: 0 auto;
          padding: 9px 20px;
          color: #fff;
          text-transform: uppercase;
          font-size: 14px;
          background-color: #8BC34A;
          border-radius: 17px;
      }
      .thank-you-pop a i{
      	margin-right:5px;
      	color:#fff;
      }
      #modalPoliza .modal-header{
          border:0px;
      }
      .html2canvas-container {
        width: 3000px !important;
         height: 3000px !important;
       }
      .caja_inline {
          display: inline-block;
          width: 210px;
      }
      div.blockMsg {
         width:  50%;
         top:    40%;
         left:   25%;
         text-align: center;
         background-color: #fcfcfc;
         border: 1px solid #ddd;
         -moz-border-radius: 10px;
         -webkit-border-radius: 10px;
      -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=50)";
         filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
         -moz-opacity:.70;
         opacity:.70;
         padding: 15px;
         color: #606060;
      }
      .observaciones1{
        font-size: 11px;
       	color:#5C5C5C;
      }
      .observaciones2{
        font-size: 14px;
        font-weight: bold;
      }
      #beneficiario_porcentaje{
        text-align: center;
      }
      .container-fluid, .container-lg, .container-md, .container-sm, .container-xl {
        padding-right: 0px;
        padding-left: 0px;
      }
      .card-body {
          padding-top: 0.85rem;
          padding-right: 0.55rem;
          padding-bottom: 0.85rem;
          padding-left: 0.55rem;
      }
      .subir {
          margin-top: -50px !important;
          margin-bottom: 30px !important;
      }
      .content-cajaP {
          overflow-y: auto;
      }
      div#myModal-poliza {
          overflow-y: auto;
      }
      span.letreroQAS {
            color: red;
            float: right;
/*            margin-top: -50px;*/
            font-weight: bold;
        }
      button#btnServicios {
          margin-bottom: 20px;
      }
      div#txtServicios {
          background: #cbcbcb;
          border: 1px dotted #9d9d9d;
          font-family: monospace;
          font-size: 13px;
          margin-bottom: 10px;
          margin-top: 10px;
      }
      button#btn_success {
          font-weight: bold;
          padding: 8px 20px;
          font-size: 17px;
      }
      button#btn_success2 {
          font-weight: bold;
          padding: 8px 20px;
          font-size: 17px;
      }
      p#mensaje_finalizar {
          margin-top: 25px;
      }
    </style>
    <title>DPVALE ECOMMERCES</title>
  </head>
  <body>
    <div class="content-cajaP">
      <?php 
          if(ENVIRONMENT=="development"){
              echo "<span class='letreroQAS'>QAS</span>";
         }
       ?>
      <div class="container-fluid">
          <div class="col-md-auto">
             <!--ENCABEZADO-->
                <div class="row">
                  <div class="col">
                    <center><img class="logo2 img-fluid" src="<?=base_url('/assets/imgs/dpvale_reflex.png')?>"></center>
                  </div>

                </div>
              <!--FIN ENCABEZADO -->

              <!-- OPERACION -->
              <!-- Busqueda de Folio -->
              <p class="mensaje_pago"><b>Monto a Pagar con dpvale Electrónico: $<?=number_format($monto,2,'.',',')?></b></p>
              <div class="card">
                <div class="card-body">
                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="label1">FOLIO</span>
                    </div>
                    <input type="text" value="" class="form-control folio" id="dpvale_folio" aria-describedby="label1"  style="text-transform:uppercase;" placeholder="0000000000" maxlength="10" >
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="btn_search">Buscar</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Fin Busqueda de Folio -->

              <!-- Informacion de Distribuidor y Canjeante-->
              <div class="card separador">
                <div class="card-body">

                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="lbdistribuidor">Distribuidor</span>
                    </div>
                    <input type="text" class="form-control" id="lbl_distribuidor" readonly  aria-describedby="lbdistribuidor">
                  </div>

                  <div class="input-group mb-2">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="lbcanjente">Canjeante</span>
                    </div>
                    <input type="text" class="form-control" id="lbl_canjeante" readonly aria-describedby="lbcanjente">
                    <div class="input-group-append">
                     <button class="btn btn-outline-secondary" type="button" onclick="verDetalle()" id="btn_detalle" disabled>Detalles</button>
                   </div>
                  </div>


                </div>
              </div>
              <!-- FIN Informacion de Distribuidor y Canjeante-->

              <!-- Informacion de Promociones-->
              <div class="card separador2">
                <div class="card-body">
                  <label class='mensaje'>Quincenas a pagar</label>
                  <div class="input-group mb-2">

                    <div class="input-group-prepend">
                      <label class="input-group-text" for="inputGroupSelect01">Promociones</label>
                    </div>
                    <select class="custom-select" id="dpvale_promociones">
                      <option value="" selected>..::Seleccione quincenas a pagar::...</option>
                    </select>
                  </div>
                  <label class='mensaje' id="lblFechaInicio"></label>
                </div>
              </div>
              <!-- FIN Informacion de Promociones-->

              <!-- Monto y boton de pagar-->
              <div class="card separador3">
                <div class="card-body">
                  <div class="row">
                  <div class="col-4" style="margin-top: -5px;">
                    <span><small>Monto a Pagar</small><br>
                      <b>$<?=number_format($monto,2,'.',',')?></b>
                    </span>
                  </div>
                  <div class="col-8">
                    <button class="btn btn-danger float-left" type="button" onclick="cerrarModal()" id="btn_cancel">Cancelar</button>
                    <!-- <button class="btn btn-success float-right" type="button" onclick="setPago()" id="btn_pago" disabled>Canjear</button> -->
                    <button class="btn btn-success float-right" type="button" onclick="capturarBeneficiario()" id="btn_pago" disabled>Siguiente</button>
                  </div>
                  </div>
                  </div>
                </div>

                 <?php  if(ENVIRONMENT=="development"){ ?>
                  <div class="row mb-3" style="margin-top: 25px;">
                      <div class="col-md-12">
                          <div id="txtServicios">
                              <p style="margin: 0;"><strong>s2credit:</strong> <?= $url_ws_s2credit?></p>
                              <p><strong>EnviarSMS:</strong> <?= $url_ws_EnviarSMS?></p>
                          </div>
                          <button class="btn btn-secondary float-left" id="btnServicios">Servicios</button>
                      </div>
                  </div>
                  <?php } ?>
              </div>
              <!-- FIN Monto y boton de pagar-->

              <!-- FIN OPERACION -->
          </div>

      <br>
      <input type="hidden" value="<?php echo $hash; ?>" name="idtoken" id="idtoken">
      <?php echo "<small>Orden: $ordenid </small>" ?>
      <br><br>
      </div>
      <!-- Modal SMS-->
      <div class="modal fade" id="modalSMS" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalSMSLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalSMSLabel">Verificación de Identidad</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>El código se ha enviado vía SMS, favor de introducir el código</p>
              <p id="lbl_mensaje" class="form-text text-muted"></p>
              <div class="row">
                <div class="col-8">
                  <div class="input-group mb-2" id="insert_code">
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="label2">DP-</span>
                    </div>
                    <input type="text" class="form-control form-control-lg" id="dpvale_token" aria-describedby="label2"  style="text-transform:uppercase;" placeholder="0000000" maxlength="7" >
                  </div>
                </div>
                <div class="col-12">
                    <button type="button" class="btn btn-outline-secondary invisible" onclick="reenviar()" id="btn_reenviar">Reenviar Código SMS </button>
                </div>
              </div>
            <!--  <p id="btn_reenvio_sms" class="form-text text-muted">Si no le ha llegado el mensaje puede volver enviarlo <button class="btn btn-primary" onclick="reenvio()">Reenviar</button></p>-->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" onclick="validaToken()" id="btn_verificacion">Verificar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Detalles Canjeante-->
      <div class="modal fade" id="modalCanjeante" tabindex="-1" role="dialog" aria-labelledby="modalCanjeanteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header" style="padding: 0.2rem 1rem;">
              <h5 class="modal-title" id="modalCanjeanteLabel">Detalle Canjeante</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" style="padding: 0rem">
              <div class="container-fluid m-0 p-0" id="detalles_canjeante">
              </div>
            </div>
            <div class="modal-footer" style="padding: 0.5rem">
              <button type="button" class="btn btn-success" data-dismiss="modal">Aceptar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Detalles Canjeante-->
      <div class="modal fade" id="modalPoliza" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-body">
              <div class="thank-you-pop">
                  <!-- <img src="<?php //base_url('/assets/imgs/Green-Round-Tick.png')?>" alt=""> -->
                  <!-- <h1 id="mensaje_titulo">dpvale canjeado</h1> -->
                  <!-- <h1 id="mensaje_titulo">Confirmando su compra</h1> -->
                  <!-- <p id="mensaje_finalizar"></p> -->
                  <p id="mensaje_finalizar"><strong>Para continuar con su compra, de clic en el siguiente botón: </strong></p>
                  <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_success" style="display: block; margin: 0 auto; background-color: #2f89a7; border-color: #2f89a7;">Finalizar Compra</button>
                  <button type="button" class="btn btn-success invisible" data-dismiss="modal" id="btn_success2" style="display: block;  margin: 0 auto; background-color: #2f89a7; border-color: #2f89a7;">Finalizar Compra</button>

                  <!-- <br> -->
                  <!-- <button type="button" class="btn btn-success invisible" data-dismiss="modal" id="btn_success2">FINALIZAR COMPRA</button><br><br> -->
                  <!-- <p id="mensaje_gracias"></p> -->
                  <p id="mensaje_gracias">Gracias por su compra, los recibos de compra serán enviados vía correo electrónico.</p>
                  <h3 class="cupon-pop">Código de autorización: <span id="lbl_ca"></span></h3>
                  <!-- <br> -->
                  <!-- <a id="link_descarga" class="invisible" style="margin-bottom:10px;" target="_blank" >Descargar Póliza de seguro</a><br> -->
                  <!-- <button type="button" class="btn btn-success" data-dismiss="modal" id="btn_success"></button><br> -->
                  <!-- <button type="button" class="btn btn-info invisible" data-dismiss="modal" id="btn_success2">FINALIZAR COMPRA</button> -->
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MODAL PARA BENEFICIARIO-->
      <div class="modal fade" id="myModal-beneficiario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title"><h3><b>Ingrese Beneficiario</b></h3></p></h5>
                 </div>
                 <div class="modal-body">
                         <form id="form-beneficiario">
                               <div class="form-group">
                                 <label for="nombre">Nombre(s)</label>
                                 <input type="text" class="form-control" required id="nombre" name="beneficiario_nombre" placeholder="">
                               </div>
                               <div class="form-group">
                                 <label for="apellido_paterno">Apellido Paterno</label>
                                 <input type="text" class="form-control" required id="apellido_paterno" name="beneficiario_paterno" placeholder="">
                               </div>
                               <div class="form-group">
                                 <label for="apellido_materno">Apellido Materno</label>
                                 <input type="text" class="form-control" required id="apellido_materno" name="beneficiario_materno" placeholder="">
                               </div>
                               <div class="row">
                                 <div class="col-6">
                                     <div class="form-group">
                                        <label for="parentesco">Parentesco</label>
                                         <select class="form-control input-lg" id="parentesco" name="parentesco">
                                        </select>
                                     </div>
                                  </div>
                                  <div class="col-6">
                                    <div class="form-group">
                                      <label for="beneficiario_porcentaje">Porcentaje</label>

                                    <div class="input-group mb-2">
                                      <input type="text" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" class="form-control" id="beneficiario_porcentaje" name="beneficiario_porcentaje" value="100">
                                      <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                      </div>
                                    </div>
                                    <small class="form-text text-muted">100% Maximo a otorgar</small>
                                  </div>
                                  </div>
                              </div>
                          </form>
                 <div class="modal-footer">
                     <!-- <input type="button" onclick="guardar_beneficiario()" class="btn btn-success btn-lg btn-block" value="GENERAR POLIZA DE SEGURO"> -->
                     <input type="button" onclick="guardar_beneficiario()" class="btn btn-success btn-lg btn-block" value="FIRMAR POLIZA DE SEGURO">
                   </div>
                 </div>

               </div><!-- /.modal-content -->
             </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      </div>

      <!-- Modal para poliza y firma digital -->
      <div class="modal fade bd-example-modal-lg" id="myModal-poliza" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
         <div class="modal-dialog" role="document">
               <div class="modal-content">
                 <div class="modal-header" style="padding: 0.2rem 1rem;">
                   <h5 class="modal-title"><h3><b>Póliza de seguro</b></h3></p></h5>
                 </div>
                 <div class="modal-body">
                   <div id="content" style="text-align: center;overflow: auto;height:170px;">
                 </div>
                 <br>
                    <center>
                       <div id="signature">
                         <canvas style="outline: black 1px solid;" id="signature-pad" class="signature-pad" width="auto" height="120px"></canvas>
                         <p class="observaciones1">Favor de usar el mouse / dedo para firmar</p>
                         <p class="observaciones2">Firma del asegurado</p>
                       </div>
                    </center>

                 <div class="modal-footer">
                    <button type="button" id="clear" onclick="reset()" class="btn btn-link">Reintentar firma</button>
                    <button type="button" onclick="setPago()" class="btn btn-success" id="btn_acepta_poliza">Aceptar</button>
                  <div class="clearfix"></div>
                </div>

               </div><!-- /.modal-content -->
             </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
      </div>
      <br>
      <!-- <button type="button" onclick="verpoliza()" class="btn btn-link">VER POLIZA</button>
      <button type="button" onclick="verbeneficiario()" class="btn btn-link">ver Beneficiario</button> -->
      <!-- FOOTER-->
      <footer class="footer fixed-bottom" style="height: 25px !important">
        <div class="container">
          <div class="row">
            <div class="col-auto" style="margin: 0 auto;">
              <span class="text-muted">Pago dpvale-ecommerce &copy; 2022</span>
            </div>
          </div>
      </div>
      </footer>
      <!-- FIN FOOTER -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.formatCurrency-1.4.0.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bowser/1.9.4/bowser.min.js"></script>
  </body>
</html>
<script>
//alert("entro en 5.18");
  // $("#modalPoliza").modal('show');
//console.log("Navegador: "+bowser.name +" Version: "+ bowser.version);
$.blockUI.defaults.css = {};
$(function() {

    $.getJSON("https://api.ipify.org?format=jsonp&callback=?",
      function(json) {
        ip = json.ip;
      }
    );
    $("#dpvale_folio").focus();
  });

function capturarBeneficiario()
{
    const select = $("#dpvale_promociones option:selected").val();
    if(select == ''){
      mensaje('alerta','Por favor, seleccione una promoción para continuar');
      return false;
    }
  cargaParentescos();
  $("#myModal-beneficiario").modal('show');
}

$("#modalPoliza").on("shown.bs.modal", function() {

  setTimeout(function() {
    const canje = window.canje;
    console.log(canje);
    if(canje.seguro){
      enviarMensaje(2);
    }else{
      enviarMensaje(1);
    }
  }, 30000);

});


$("#dpvale_folio").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
     buscaFolio();
  }
});


$("#btn_search").on("click", function(){
  buscaFolio();
});

function buscaFolio(){
  $folio = $('#dpvale_folio').val();
  if($folio == ''){mensaje('Error', 'Favor de poner el folio',$(this).focus()); return false;}
  if($folio.length < 10){mensaje('Error', 'Formato de Folio Incorrecto, Favor de revisar el folio'); return false;}
  let ios=$("#idtoken").val();
  $.ajax({
      url: "<?php echo base_url('dpvalecom/getvale'); ?>",
      type: "GET",
      dataType: "json",
      data:{ folio : $folio ,token: "<?php echo $hash; ?>",itoken:ios },
      beforeSend: function() {
         $.blockUI({ message: '<h2>Validando Folio..</h2>',timeout: 60000,baseZ: 9000 });
      },
      success:function(data) {
      //  console.log(data);
        if(data.status == 'error'){mensaje('Error',data.message+" <br>Navegador: "+bowser.name +"<br> Version: "+ bowser.version);return false;}
        window.preload = data;
        $("#lbl_mensaje").html(data.sms.message);
        $("#insert_code").removeClass('invisible');
        $("#btn_verificacion").removeClass('invisible');
        $('#modalSMS').modal('show');
      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });
}

function cargadatos(){
  const datos = window.preload;
  let html = '';
  let trHTML = '';
  let encabezado = ["Id","Nombre","Dirección","Numero Ext","Numero Int","CP","Colonia","Ciudad","Estado","Sexo","Telefono","Nacimiento","Saldo Disp.","rfc","curp",];
  let num = 0;
  $.each(datos.Customer, function (i, item) {
      html += '<div class="row my-2 mx-auto"><div class="col-4 text-right border-right border-dark">'+encabezado[num] +'</div><div class="col-8 pl-2">'+item+'</div></div>';
      num++;
  });
  $('#detalles_canjeante').html('').append(html);
  $('#lbl_distribuidor').val(datos.Distributor.nombre);
  $('#lbl_canjeante').val(datos.Customer.nombre);
  $('#dpvale_promociones').empty();

  $('#lblFechaInicio').html("");
  //$('#lblFechaInicio').append("Empiece a pagar a partir del "+datos.Promotions[0].promo_date);
//Seleccione quincenas a pagar
 trHTML='<option value="" data-folio=""data-quincena=""data-fecha=""data-promo=""data-fecha_s2="">Seleccione quincenas a pagar</option>';

  $.each(datos.Promotions, function (i, item) {
    if(item.promo == 0){promo = 'NO'}else{promo = 'SI'}
    pagoquincenal = Number(<?=$monto?>) / Number(item.term) ;
      trHTML += '<option value="'+ item.id_offer +'" data-folio="' + item.id_offer + '" '+
      'data-quincena="'+ item.promo_date +'" '+
      'data-fecha="'+ item.term +'" '+
      'data-promo="'+ promo +'" '+
      'data-fecha_s2="'+ item.promo_date1 +'" '+
       '>' + item.term + ' Quincenas de $' + pagoquincenal.toFixed(2) + '</option>';
  });
  $('#dpvale_promociones').html('').append(trHTML);
  $("#btn_detalle").removeAttr('disabled',false);
  $("#btn_pago").removeAttr('disabled',false);
  return true;
}

$( "#dpvale_promociones" )
  .change(function () {
    var str = "";
    $( "#dpvale_promociones option:selected" ).each(function() {
      str += ($( this ).data("quincena"))?$( this ).data("quincena"):"";
    });
    // $( "div" ).text( str );
    console.log("STR",str);
    console.log("TIPO",typeof str);
    str = (str == "undefined")?"":str;
   $("#lblFechaInicio").html("");
   if(str!=""){
     var _fecha_descripcion="";
     let arr = str.split('-');
     if(arr[1]=="01")
     {
       _fecha_descripcion=arr[2]+" de Enero";
     }
     else if (arr[1]=="02") {
       _fecha_descripcion=arr[2]+" de Febrero";
     }
     else if (arr[1]=="03") {
       _fecha_descripcion=arr[2]+" de Marzo";
     }
     else if (arr[1]=="04") {
       _fecha_descripcion=arr[2]+" de Abril";
     }
     else if (arr[1]=="05") {
       _fecha_descripcion=arr[2]+" de Mayo";
     }
     else if (arr[1]=="06") {
       _fecha_descripcion=arr[2]+" de Junio";
     }
     else if (arr[1]=="07") {
       _fecha_descripcion=arr[2]+" de Julio";
     }
     else if (arr[1]=="08") {
       _fecha_descripcion=arr[2]+" de Agosto";
     }
     else if (arr[1]=="09") {
       _fecha_descripcion=arr[2]+" de Septiembre";
     }
     else if (arr[1]=="10") {
       _fecha_descripcion=arr[2]+" de Octubre";
     }
     else if (arr[1]=="11") {
       _fecha_descripcion=arr[2]+" de Noviembre";
     }
     else if (arr[1]=="12") {
       _fecha_descripcion=arr[2]+" de Diciembre";
     }

     //_fecha_descripcion="",
    //$('#lblFechaInicio').append("Empiece a pagar a partir del "+str);
    $('#lblFechaInicio').append("Empiece a pagar a partir del "+_fecha_descripcion);
   }
  })
  .change();

function validaToken(){
  $token = $("#dpvale_token").val();
  if($token== ''){mensaje('Error','Favor escribir el código de Verificación');return false;}
  if($token.length != 7){mensaje('Error','El código de Verificación es de 7 Digitos, Favor Verifique');return false;}
  let ios=$("#idtoken").val();
  $.ajax({
      url: "<?php echo base_url('dpvalecom/checkcode'); ?>",
      type: "GET",
      dataType: "json",
      data:{ code : $token ,token: "<?php echo $hash; ?>" ,key: ip, itoken:ios},
      beforeSend: function() {
         $.blockUI({ message: '<h2>Validando Token..</h2>',timeout: 60000,baseZ: 9000 });
      },
      success:function(data) {
        //console.log(data);
        if(!data.status){
          mensaje('Error',data.message);
                  if(!data.action){
                    $("#insert_code").addClass('invisible');
                    $("#lbl_mensaje").html('Supero los intentos de verificación de codigo');
                    $("#btn_verificacion").addClass('invisible');
                    return false;}
                    if(data.reenvio){
                      $("#btn_reenviar").removeClass('invisible');
                      $("#lbl_mensaje").html('Favor de enviar un nuevo codigo de verificación a su telefono');
                      return false;
                    }
        return false;
       }
        if(data.status){
          $('#modalSMS').modal('hide');
          $("#dpvale_token").val('');
          cargadatos();
        }else{
          mensaje('Error','No se pudo validar el código de verificación, intente en un momento más.');
        }

      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });
}

function setPago(){
  
const select = $("#dpvale_promociones option:selected");
  if(select.folio == ''){
    mensaje('Error','Por favor, seleccione promoción');
    return false;
  }

  const periodo_promo = select.data('fecha');
  const primer_pago_promo=select.data('quincena');
  const id_promo=select.data('folio');
  const es_promo=select.data('promo');
  const fec_s2=select.data('fecha_s2');
  let ios = $("#idtoken").val();
      $.ajax({
          url: "<?php echo base_url('dpvalecom/setventa'); ?>",
          type: "GET",
          dataType: "json",
          data:{
            token          : "<?php echo $hash; ?>",
            period         : periodo_promo,
            firstDueDate   : primer_pago_promo,
            idOffer        : id_promo,
            promo          : es_promo,
            promo_s2       : fec_s2,
            plataforma     : "EC-PAY",
            itoken         : ios
          },
          beforeSend: function() {
               $.blockUI({ message: '<h2>Canjeando dpvale.. <small>por favor espere un momento</small></h2>',timeout: 60000,baseZ: 9000 });
          },
          success:function(data) {
             //console.log(data);
            if(data.status == 'error'){mensaje('Error',data.message);return false;}
            if(data.status == 'ok'){
              window.canje=data;
              if(data.seguro){
                // * Una vez hecha la venta, se ejecuta la setventa() la cual genera la poliza siempre y cuando la venta aplique para éste caso.
                setventa(); // <- Aquí se genera el PDF de la póliza.

                msn_btn="FIRMAR POLIZA";
                msn_txt="Gracias por su compra, para su mayor protección tenemos una póliza de vida incluida en esta compra, para hacerla válida se requiere que nos proporcione los datos del beneficiario y su firma.";

              }else{
                msn_btn="Finalizar Compra";
                msn_txt="Gracias por su compra, los recibos de compra se le enviaran vía correo electrónico";

                $("#myModal-poliza").modal('hide');
              }
              $("#mensaje_gracias").html(msn_txt);
              $("#lbl_ca").html(data.CA);
              $("#btn_success").html(msn_btn);
              $('#modalPoliza').modal('show');
            }
          },
          error: function(e){
            mensaje('Error','No se pudo completar el canje, intente en un momento más.');
          },
          complete: function() {
              $(document).ajaxStop($.unblockUI);
         }
      });
}

/*
CLICK AL BOTON DE ACEPTAR EN EL MODAL DE GRACIAS POR LA COMPRA
*/
$("#btn_success").click(function(){
  const canje = window.canje;
  if(canje.seguro){
    cargaParentescos();
    $("#myModal-beneficiario").modal('show');
  }else{
    enviarMensaje(1);
  }
});

/*
CLICK AL BOTON DE ACEPTAR DESPUES DE GENERRAR LA POLIZA
*/
$("#btn_success2").click(function(){
   var poliza = $("#btn_success2").data("url-poliza");
   if (typeof poliza !== "undefined" && poliza !== null) {
     window.open(poliza);
   }
    const canje = window.canje;
    enviarMensaje(2);
});

function cargaParentescos(){
  $.ajax({
      url: "<?php echo base_url('dpvalecom/parentescos'); ?>",
      type: "GET",
      dataType: "json",
      timeout: 20000,
      beforeSend: function() {
          $('#parentesco').empty('').append('<option>Cargando...</option>');
      },
      success:function(data) {
            $('#parentesco').empty('').append('<option value="">Seleccione</option>');
             var trHTML = '';
             $.each(data.data, function (i, item) {
                  trHTML += '<option value="'+item.id+'">'+item.value+'</option>';
              });
              $('#parentesco').append(trHTML);
     },
     error: function(e){
         manualParentescos();
    },
     complete: function() {
         $(document).ajaxStop($.unblockUI);
    }
  });
}

function manualParentescos(){
  var cadena = '[{"id":"","value":"Seleccione"},{"id":"2","value":"Padre"},{"id":"3","value":"Madre"},{"id":"4","value":"Hijo (a)"},{"id":"5","value":"Hermano (a)"},{"id":"6","value":"T\u00edo (a)"},{"id":"7","value":"Sobrino (a)"},{"id":"8","value":"Abuelo (a)"},{"id":"10","value":"Esposo (a)"},{"id":"15","value":"Concubino (a)"},{"id":"16","value":"Nieto (a)"},{"id":"17","value":"Amigo (a)"}]';
  var data = JSON.parse(cadena);
  $('#parentesco').empty('');
   var trHTML = '';
   $.each(data, function (i, item) {
        trHTML += '<option value="'+item.id+'">'+item.value+'</option>';
    });
    $('#parentesco').append(trHTML);
}

function valida(){
    var values = {};
    var i = 0;
        $("#form-beneficiario").find(':input').each(function() {
         var elemento= this;
         if (elemento.value == "" ){
           mensaje('Error', "Favor de capturar el " + elemento.id.replace("_", " ") + " del beneficiario");
           $("#"+elemento.id).css("border-color", "#dc3545");
           return false;
         }else { $("#"+elemento.id).css("border-color", "#ced4da"); }
         values[elemento.id] = elemento.value;
         i++;
        });
    if (i < 5){return false;}
    if( $("#beneficiario_porcentaje").val() > 100 ){
      mensaje('Error', "El maximo a otorgar es 100%");
      $("#beneficiario_porcentaje").css("border-color", "#dc3545");
      return false;
    }else{
      $("#beneficiario_porcentaje").css("border-color", "#ced4da");
    }
    return true;
}

function guardar_beneficiario()
{
  if(valida()){
      let ios=$("#idtoken").val();
      values = $("#form-beneficiario").serialize() + '&beneficiario_nparentesco=' + $( "#parentesco option:selected" ).text();
      $.ajax({
          url: "<?php echo base_url('dpvalecom/beneficiario'); ?>",
          type: "GET",
          dataType: "json",
          data:{valores : values, token: "<?php echo $hash; ?>",itoken: ios},
          beforeSend: function() {
               $.blockUI({ message: '<h2>Generando Póliza..</h2>',timeout: 60000,baseZ: 9000 });
          },
          success:function(data) {
            // console.log(data);
            if(data.status == 'error'){mensaje('Error',data.message);return false;}
            if(data.status == 'ok'){
              let viewpoliza = decodeHTML(data.poliza);
              $('#content').html(viewpoliza);
              signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
              });
               $("#myModal-beneficiario").modal('hide');
               $("#myModal-poliza").modal('show');
            }
         },
         error: function(e){
          //  console.log(e);
           mensaje('Error','No se pudo guardar el beneficiario, intente en un momento más.');
         },
         complete: function() {
             $(document).ajaxStop($.unblockUI);
        }
      });
  }
}

function reset() {
  $("#signature").show();
  signaturePad.clear();
}

/* Se genera la poliza y se guarda en la ruta del proyecto. */
function setventa(){
  if( signaturePad.isEmpty() ){mensaje('Error','Favor de Firmar la póliza');return false;}
  let data = signaturePad.toDataURL("image/png");
  let imagen64 = data.replace('data:image/png;base64,', '');
  let ios=$("#idtoken").val();
  $.ajax({
      url: "<?php echo base_url('dpvalecom/guardarpoliza'); ?>",
      type: "GET",
      dataType: "json",
      data:{ imgdata : imagen64 , token: "<?php echo $hash; ?>",itoken:ios },
      beforeSend: function() {
           $.blockUI({ message: '<h2>Guardando Póliza..</h2>',timeout: 60000,baseZ: 9000 });
      },
      success:function(data) {
       console.log(data);
        window.seguro = data;
        if(data.status == 'error'){mensaje('Error',data.message);return false;}
        if(data.status == 'ok'){
          // setPago();
          // $("#mensaje_titulo").html('Confirmando su compra');
          $("#mensaje_gracias").html('Gracias por su compra, los recibos de compra serán enviados vía correo electrónico.');
          $("#mensaje_finalizar").html('<strong>Para continuar con su compra, de clic en el siguiente botón: </strong>');
          $("#btn_success2").removeClass('invisible');
          $("#btn_success2").addClass('subir');
          $("#btn_success2").attr("data-url-poliza", data.poliza);
          $("#btn_success").addClass('invisible');
          $("#myModal-poliza").modal('hide');
          // $("#link_descarga").removeClass('invisible').attr('href',data.poliza);
          $('#modalPoliza').modal('show');
        }
     },
     error: function(e){
       mensaje('Error','Se tuvo problemas para generar la póliza, intente en un momento más.');
    },
     complete: function() {
         $(document).ajaxStop($.unblockUI);
    }
  });
}

function verpoliza(){
  /*ESTO ES UNA PRUEBA PARA EL MODAL DE POLIZA*/
  $('#content').html('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.');
  signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
    backgroundColor: 'rgba(255, 255, 255, 0)',
    penColor: 'rgb(0, 0, 0)'
  });
    $("#myModal-poliza").modal('show');
}

var decodeHTML = function (html) {
	var txt = document.createElement('textarea');
	txt.innerHTML = html;
	return txt.value;
};

function reenviar(){
  $folio = $('#dpvale_folio').val();
  if($folio == ''){mensaje('Error', 'Favor de poner el folio',$(this).focus()); return false;}
  if($folio.length < 10){mensaje('Error', 'Formato de Folio Incorrecto, Favor de revisar el folio'); return false;}
  let ios=$("#idtoken").val();
  $.ajax({
      url: "<?php echo base_url('dpvalecom/reenvio'); ?>",
      type: "GET",
      dataType: "json",
      data:{ folio : $folio ,token: "<?php echo $hash; ?>", itoken:ios },
      beforeSend: function() {
         $.blockUI({ message: '<h2>Reenviando Código..</h2>',timeout: 60000,baseZ: 9000 });
      },
      success:function(data) {
        //console.log(data);
        if(data.status == 'error'){mensaje('Error',data.message);return false;}
        $("#lbl_mensaje").html(data.message);
        $("#dpvale_token").val('');
        $("#btn_reenviar").addClass('invisible');
      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });

}

function generarRespuesta(tipo){
  let obj = new Object();
     obj.Status = 1;
     obj.Mensaje  = 'Venta Exitosa';
     obj.CA = window.canje.CA;
     obj.No_tarjeta = $("#dpvale_folio").val();

         let ticket = new Object();
           ticket.no_quincenas = window.canje.quincenas;
           ticket.acreditado = window.preload.Distributor.nombre;
           ticket.canjeante = window.preload.Customer.nombre;
           ticket.pago_quincenal = window.canje.pagosde;
           ticket.inicia_pago = window.canje.fechapago;
           obj.VentaTicket = ticket;
      if(tipo == 2){
        let seguro = new Object();
            seguro.pdf = window.seguro.poliza;
            obj.SeguroTicket = seguro;
      }else{
        obj.SeguroTicket = null;
      }
   let json= JSON.stringify(obj);

   return json;
}

function mensaje(tipo, mensaje,callback = ''){
  switch(tipo) {
    case 'Error':
      $.confirm({
        icon: 'fas fa-exclamation-triangle',
        title: 'Error!',
        content: mensaje,
        type: 'red',
        typeAnimated: true,
        columnClass: 'medium',
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-red',
                action: function(){
                  if(callback.length > 0){
                    eval(callback);
                  }
                }
            }
        }

      });
      break;
    case 'aviso':
      $.confirm({
        title: 'Aviso',
        content: mensaje,
        type: 'blue',
        typeAnimated: true,
        columnClass: 'medium',
        buttons: {
            tryAgain: {
                text: 'Aceptar',
                btnClass: 'btn-blue',
                action: function(){
                }
            }
        }
      });
      break;
    case 'alerta':
        $.confirm({
          title: '¡Alerta!',
          content: mensaje,
          type: 'orange',
          typeAnimated: true,
          columnClass: 'medium',
          buttons: {
              tryAgain: {
                  text: 'Aceptar',
                    keys: ['enter', 'esc'],
                  btnClass: 'btn-orange',
                  action: function(){
                    if(callback.length > 0){
                    eval(callback);
                    }
                  }
              }
          },
          scrollToPreviousElement:false
        });
      break;
      case 'ok':
          $.confirm({
            icon: 'fa fa-check',
            title: 'Exito',
            content: mensaje,
            type: 'green',
            typeAnimated: true,
            columnClass: 'medium',
            buttons: {
                tryAgain: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function(){
                    }
                }
            }
          });
        break;
    }
}

function verDetalle(){
    $('#modalCanjeante').modal('show');
}

function verVerficador(){
    $('#modalSMS').modal('show');
}

/*FUNCIONES DE SALIDA */
function enviarMensaje(res){
  dprespuesta = generarRespuesta(res);
  parent.postMessage(dprespuesta,"*");
}
function cerrarModal(){
  parent.postMessage('cerrar',"*");
}

  $("#txtServicios").hide();

  $("#btnServicios").click(function(){
      $("#txtServicios").toggle();

  });
/* SEGURIDAD VALIDACION DE URL y HOST */
//if(parent.document.dpvaleiframe === undefined){
  //document.location = 'http://10.200.3.35/dpapi/dpvalecom/error';
//}

//if(parent.window.dpvalerandom != '<?=$validacion?>'){
  //document.location = 'http://10.200.3.35/dpapi/dpvalecom/error';
//}
//console.log(document.referrer);
</script>
