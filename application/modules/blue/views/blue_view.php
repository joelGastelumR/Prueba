<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.formatCurrency-1.4.0.min.js')?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <title>DP Lealtad</title>
    <style>
            .bloque1{
                  height: 7em;
            }
            #direccion{
              visibility: hidden;
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
            #logo{
              width: 75%;

            }

            .myDIV{
              float: left;
              width: 50%;

            }
            .div2{
              float: right;
              width: 50%;
            }


            .info{
              padding-top: 5px;

            }
            .resultado{
              display: none;

            }
            .infosaldo{

              font-size: 30px;

              padding-top: 3px;
            }

            .total{
              text-align: right;
              font-size: 30px;
              font-style: bold;

              width: 40%;
              border-radius: 10px;
              border: 0;
            }

            }
            #monto{
              padding-left: 50px;
              font-size: 18px;
            }
            .botones{
              padding-top: 134px;
            }
            #ticket_content{
              text-align: center;
            }
            .leyenda{
              font-size: 10px;
            }
            .contenido{
              text-align: center;
            }

      </style>
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <div  id="ticket_content" class="modal-body">

      </div>


    </div>
  </div>
</div>
    <div class="container-fluid">
        <div class="panel panel-default bloque1" id="panel1">
          <div class="panel-body">
            <div id="busqueda" class="buscar">
              <div class="row">
                  <div class="col-xs-7 col-sm-4 col-md-4 col-lg-4">
                    <div id="monto" class="show">
                      <label id="montop">Monto a pagar</label>
                      <p class="info_credito" id="setmonto"><?php echo "$ ".number_format((float)$monto, 2, '.', ''); ;?></p>
                    <p style="visibility: hidden"> <label id="cvendedor"><?php echo $cvendedor; ?> </label> <label id="vendedor"> <?php echo $vendedor;?></label> <label id="ccajero"> <?php echo $ccajero; ?></label>
                    <label id="cajero"> <?php echo $cajero; ?></label> <label id="csupervisor"><?php echo $csupervisor; ?> </label> <label id="supervisor"><?php echo $supervisor; ?> </label> <label id="ticket"><?php echo $ticket; ?> </label> </p>
                    <div id="direccion" >
                    <label id="calle"><?php echo $calle ?></label>
                    <label id="colonia"><?php echo $colonia ?></label>
                    <label id="telefono"><?php echo $telefono ?></label>
                    <label id="cp"><?php echo $cp ?></label>
                    <label id="ciudad"><?php echo $ciudad ?></label>
                    <label id="estado"><?php echo $estado ?></label>
                    </div>

                    </div>
                  </div>
                    <div class="col-md-2 col-sm-2 col-lg-2">
                      <div class="form-group form-group-lg">
                        <div id="monto" class="show">
                          <label id="">Tienda</label>
                          <p class="info_credito" id="tienda"><?=$tienda?></p>

                        </div>

                      </div>
                  </div>

                  <div class="col-md-2 col-sm-2 col-lg-2">
                    <div id="monto" class="show">
                      <label id="">Caja</label>
                      <p class="info_credito" id="caja"><?=$caja?></p>

                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2 pull-right">
                      <div class="form-group">
                        <div class="form-group">
                         <img id="logo" src="http://10.200.3.35/newportal/assets/imgs/grupo-dp-v1.png" alt="Dpvale" class="img-responsive">
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
                <div id="formulario" class="form-group" style="text-align: center; padding-Top: 25px; padding-left: 300px; width: 80%">
          <div class="input-group form-group-lg">
  <span class="input-group-btn">
      <button id="des" type="button" onclick="des(), changeState()" title="Digitada" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-credit-card"></span></button>
      <button id="man" type="button" onclick="man(), changeState()" title="Tecleada" class="btn btn-primary btn-lg" ><span class="glyphicon glyphicon-list-alt"></span></button>
  </span>
        <input id="numero_tarjeta" placeholder="Teclee el numero de la tarjeta"  class="form-control " name="codigo" type="text" onkeypress="return validaNumericos(event)" maxlength="16">
        <span class="input-group-btn">
          <button  id="buscar" onclick="GetBalance()" type="button" class="btn btn-primary btn-lg " name="button" title="Buscar Promocion"><span class="glyphicon glyphicon-search"></span></button>
    </span>
  </div> <hr>
  <div class="div2">
    <label class="infosaldo">Cantidad a canjear: </label>
    <div style="text-align: right">
     <input type="text" class="total" id="sald" disabled name="" value="<?php echo "$ ".number_format($monto,2,'.',',');?>">
  </div>
    <div class="botones">
    <button type="button" style="width: 120px" onclick="Canje()"  class="btn btn-primary btn-lg">Canjear</button>
    <button type="button" style="width: 120px" onclick="cancelar()" class="btn btn-danger btn-lg">Cancelar</button>
  <label id="productos" style="visibility: hidden"><?php echo $detalle ?></label>

    </div>

  </div>
  <div class="myDIV">

  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Total de puntos:</b></i></span>
    <input id="tpuntos" disabled  style="text-align: center"  class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Saldo:</b></i></span>
    <input id="saldo" disabled  style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Status:</b></i></span>
    <input id="status" disabled  style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Fecha Activacion:</b></i></span>
    <input id="fecha_a" disabled  style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Fecha Expiracion:</b></i></span>
    <input id="fecha_e" disabled  style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>ID del cliente:</b></i></span>
    <input id="id_cliente" disabled  style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
  <div class="info">
    <div class="input-group">
       <span style="width: 180px;" class="input-group-addon"><b>Cliente:</b></i></span>
    <input id="cliente" disabled style="text-align: center" class="form-control" type="text" name="" placeholder="" value="">
  </div>
</div> <br>
</div>



  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>



            <p style="visibility: hidden" > <label id="plaza"></label>  <label id="ambiente"><?php echo $ambiente; ?></label><input onclick="changeState()" type="radio" name="options" id="d" autocomplete="off"> Digitada <input onclick="changeState()" checked="true" type="radio" name="options" id="c"> Tecleado
               <label id="tipo" style="visibility: hidden">0</label> </p>
               <label id="cm" style="visibility: hidden"></label>


        </div>





<script type="text/javascript">
numero_tarjeta.focus();
var ttienda = document.getElementById("tienda").innerHTML;
var ncaja = document.getElementById("caja").innerHTML;

var t = ttienda.padStart(3,"0");
var c = ncaja.padStart(3,"0");

$('#caja').html(c);
$('#tienda').html(t);

function setname(){
  var name = document.getElementById("cuname").value;
  document.getElementById('cliente').value=  name;
  $('#myModal').modal('hide');
}
function test(){
  $('#myModal').modal('show');
}
function des(){
  $('#des').addClass("btn-primary");
  $('#des').removeClass("btn-default");
  document.getElementById('buscar').style.display = 'none';
  $('#man').removeClass("btn-primary");
  $('#man').addClass("btn-default");
  $("#d").prop("checked", true);
  document.getElementById('tipo').innerHTML=  "1";

}
function man(){
  $('#man').addClass("btn-primary");
  $('#man').removeClass("btn-default");
document.getElementById('buscar').style.display = 'block';
  $('#des').removeClass("btn-primary");
  $('#des').addClass("btn-default");
  $("#c").prop("checked", true);
  document.getElementById('tipo').innerHTML=  "0";

}
$('#numero_tarjeta').keyup(function(e) {
if(e.which == 13){

 var tipo = document.getElementById('tipo').innerHTML;
 if (tipo == 1) {
   lectora();
 }else {
   GetBalance();
 }
}
});
function lectora(){
  var tarjeta = $("#numero_tarjeta").val().split("ñ")[1];
  var nt = tarjeta.slice(0,16);
  document.getElementById("numero_tarjeta").setAttribute('type','text');
  document.getElementById('numero_tarjeta').value= nt;
  var bin = $("#numero_tarjeta").val().slice(0,-10);

  if (bin != 258383){

             $.confirm({
           icon: 'fa fa-warning',
           title: 'Error de Tarjeta',
           content: 'La tarjeta no es valida para canje, favor de ingresar una nueva tarjeta',
           type: 'orange',
           typeAnimated: true,
           buttons: {
           tryAgain: {
           text: 'Aceptar',
           btnClass: 'btn-orange',
           action: function(){
             numero_tarjeta.focus();
             numero_tarjeta.value = "";
           }

           },
           }
           });
           return;
         }
         GetBalance();


}
function cancelar(){
location.reload();
}
function changeState(){
  var x = document.getElementById("d").checked;
  if (x == true)
  {
    document.getElementById("numero_tarjeta").setAttribute('type','password');
    document.getElementById("numero_tarjeta").setAttribute('placeholder','Deslize la tarjeta');
    document.getElementById("numero_tarjeta").removeAttribute('disabled');
    document.getElementById("numero_tarjeta").removeAttribute('maxlength');
    document.getElementById("numero_tarjeta").removeAttribute('onkeypress');

    numero_tarjeta.focus();
  }
  var z = document.getElementById("c").checked;
  if (z == true){
  document.getElementById("numero_tarjeta").setAttribute('type','text');
  document.getElementById("numero_tarjeta").setAttribute('placeholder','Teclee el numero de la tarjeta');
  document.getElementById("numero_tarjeta").removeAttribute('disabled');
  document.getElementById("numero_tarjeta").setAttribute('maxlength','16');
  document.getElementById("numero_tarjeta").setAttribute('onkeypress','return validaNumericos(event)');
  numero_tarjeta.focus();
}

}
function validar() {

if (numero_tarjeta.value.length!=16) {


$.confirm({
icon: 'fa fa-warning',
title: 'Error en Captura',
content: 'Favor de digitar los 16 numeros de la tarjeta a consultar',
type: 'orange',
typeAnimated: true,
buttons: {
tryAgain: {
text: 'Aceptar',
btnClass: 'btn-orange',
action: function(){
}
},
}
});
numero_tarjeta.focus();
numero_tarjeta.value = "";
return true;
}
}
function validaNumericos(event) {

if(event.charCode >= 13 && event.charCode <= 57){

  return true;

 }

 $.confirm({
icon: 'fa fa-warning',
title: 'Error de Captura',
content: 'Este campo solo admite valores numericos',
type: 'orange',
typeAnimated: true,
buttons: {
tryAgain: {
text: 'Aceptar',
btnClass: 'btn-orange',
action: function(){
}
},
}
});
 return false;
}
function GetBalance(){
  var ccajero = document.getElementById("ccajero").innerHTML;
  var cajero = document.getElementById("cajero").innerHTML;
  var cvendedor = document.getElementById("cvendedor").innerHTML;
  var vendedor = document.getElementById("vendedor").innerHTML;
  var monto = document.getElementById("setmonto").innerHTML.slice(2);
  var csupervisor = document.getElementById("csupervisor").innerHTML;
  var supervisor = document.getElementById("supervisor").innerHTML;
  var amb = document.getElementById("ambiente").innerHTML;
  var tienda = document.getElementById("tienda").innerHTML;
  if ( amb == "Pruebas" )
  {
    var tienda = "1";
  }
  var caja = document.getElementById("caja").innerHTML;
  var card = $("#numero_tarjeta").val();
  var ticket = document.getElementById("ticket").innerHTML;
  var fecha =(new Date(new Date().toString().split('GMT')[0]+' UTC').toISOString().split('.')[0]);
  var bin = $("#numero_tarjeta").val().slice(0,-11);

  if (bin != 25833){

             $.confirm({
           icon: 'fa fa-warning',
           title: 'Error de Tarjeta',
           content: 'La tarjeta no es valida para canje, favor de ingresar una nueva tarjeta',
           type: 'orange',
           typeAnimated: true,
           buttons: {
           tryAgain: {
           text: 'Aceptar',
           btnClass: 'btn-orange',
           action: function(){
             numero_tarjeta.focus();
             numero_tarjeta.value = "";
           }

           },
           }
           });
           return;
         }
  $.ajax({
      url: "<?php echo base_url('blue/blue_controller/balance'); ?>",
      data:{
            Ccajero : ccajero,
            Cajero : cajero,
            Cvendedor : cvendedor,
            Vendedor : vendedor,
            Csupervisor : csupervisor,
            Supervisor : supervisor,
            Card : card,
            Fecha : fecha,
            Tienda : tienda,
            Ticket : ticket




      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Consultando Puntos..</h2>',timeout: 30000 });
      },
      success:function(data) {
        console.log(data);
        xmlDoc = $.parseXML( data ),
        $xml = $( xmlDoc ),


        $tpuntos = $xml.find("BalancePoints");
        $saldo = $xml.find("BalanceAmount");
        $status = $xml.find("StatusDescription");
        $fechact = $xml.find("Activate");
        $fechaex = $xml.find("Expire");
        $idclient = $xml.find("CustomerId");
        $nombreclient = $xml.find("CustomerName");
        $mensaje = $xml.find("Description");
        $result = $xml.find("ResultId");


        var mensaje = $mensaje.text();
        var result = $result.text();
        var tpuntos = $tpuntos.text();
        var saldo = $saldo.text();
        var status = $status.text();
        var fechact = $fechact.text();
        var fechaex = $fechaex.text();
        var idclient = $idclient.text();
        var nombreclient = $nombreclient.text();
        var tar = card.slice(12);
        var nsaldo = parseFloat(saldo).toFixed(2);


        if (result < 0){
          $.confirm({
        icon: 'fa fa-warning',
        title: 'Error de Tarjeta',
        content: mensaje,
        type: 'red',
        typeAnimated: true,
        buttons: {
        tryAgain: {
        text: 'Aceptar',
        btnClass: 'btn-red',
        action: function(){

        }

        },
        }
        });
        $(document).ajaxStop($.unblockUI);
        return;
        }

        document.getElementById('tpuntos').value= tpuntos;
        document.getElementById('saldo').value= "$" +  parseFloat(saldo).toFixed(2);
        document.getElementById('status').value= status;
        document.getElementById('fecha_a').value= fechact;
        document.getElementById('fecha_e').value= fechaex;
        document.getElementById('id_cliente').value= idclient;
        document.getElementById('cliente').value= nombreclient;




          $(document).ajaxStop($.unblockUI);



      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });



}
function Canje(){
  var tienda = document.getElementById("tienda").innerHTML;
  if ( amb == "Pruebas" )
  {
    var tienda = "1";
  }
  var caja = document.getElementById("caja").innerHTML;
  var ccajero = document.getElementById("ccajero").innerHTML;
  var monto = document.getElementById("setmonto").innerHTML.slice(2);
  var cajero = document.getElementById("cajero").innerHTML;
  var cvendedor = document.getElementById("cvendedor").innerHTML;
  var vendedor = document.getElementById("vendedor").innerHTML;
  var csupervisor = document.getElementById("csupervisor").innerHTML;
  var supervisor = document.getElementById("supervisor").innerHTML;
  var productos = document.getElementById("productos").innerHTML.slice(0,-1);
  var amb = document.getElementById("ambiente").innerHTML;
  var tienda = document.getElementById("tienda").innerHTML;
  var dd = new Date();
  currentHours = dd.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  currentMin = dd.getMinutes();
  if(currentMin < 10){
  currentMin = ("0" + currentMin).slice(-2);
  }
  currentSeg = dd.getSeconds();
  if(currentSeg < 10){
  currentSeg = ("0" + currentSeg).slice(-2);
  }
  var currentDay = dd.getDate();
  if (currentDay < 10){
  currentDay = ("0" + currentDay);
  }
  var currentMoth = dd.getMonth()+1;
  if (currentMoth < 10){
  currentMoth = ("0" + currentMoth);
  }
  var fecha = '' + dd.getFullYear() + currentMoth + currentDay + currentHours + currentMin + currentSeg;
  fecha.toString();
  var fech = '' + (dd.getDate()) + "/" + (dd.getMonth()+1) + "/" + dd.getFullYear();
  var hr = '' + currentHours + ":" + currentMin + ":" + dd.getSeconds();
  if ( amb == "Pruebas" )
  {
    var tienda = "1";
  }
  var caja = document.getElementById("caja").innerHTML;
  var card = $("#numero_tarjeta").val();
  var cliente = $("#cliente").val();
  var tar = card.slice(12);
  var star = "**** **** **** "+ tar;
  var ticket = document.getElementById("ticket").innerHTML;
  var fecha =(new Date(new Date().toString().split('GMT')[0]+' UTC').toISOString().split('.')[0]);
  var th = "Rodolfo Bustamante";
  //var cm = "2122";
  var calle = document.getElementById("calle").innerHTML;
  var colonia = document.getElementById("colonia").innerHTML;
  var telefono = document.getElementById("telefono").innerHTML;
  var cp = document.getElementById("cp").innerHTML;
  var ciudad = document.getElementById("ciudad").innerHTML;
  var estado = document.getElementById("estado").innerHTML;

  var puntos = document.getElementById("saldo").value.slice(1);
  var monto = document.getElementById("setmonto").innerHTML.slice(2);



  if (Number(monto) > Number(puntos)){
    $.confirm({
  icon: 'fa fa-warning',
  title: 'Saldo Insuficiente',
  content: "La tarjeta con terminación " + "<strong>" + tar + "</strong>"  + " no cuenta con los puntos necesarios para realizar el canje." ,
  type: 'red',
  typeAnimated: true,
  buttons: {
  tryAgain: {
  text: 'Aceptar',
  btnClass: 'btn-red',
  action: function(){

  }

  },
  }
  });
    return;
  }

  $.ajax({
      url: "<?php echo base_url('blue/blue_controller/canje'); ?>",
      data:{
            Ccajero : ccajero,
            Cajero : cajero,
            Cvendedor : cvendedor,
            Vendedor : vendedor,
            Csupervisor : csupervisor,
            Supervisor : supervisor,
            Card : card,
            Fecha : fecha,
            Tienda : tienda,
            Ticket : ticket,
            Productos : productos,
            Monto : monto,
            Cliente : cliente
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Canjeando puntos..</h2>',timeout: 30000 });
      },
      success:function(data) {
        console.log(data);
        xmlDoc = $.parseXML( data ),
        $xml = $( xmlDoc ),


        $mensaje = $xml.find("Description");
        $result = $xml.find("ResultID");
        $cm = $xml.find("ResultID");
        var result = $result.text();
        var mensaje = $mensaje.text();
        var cm = $cm.text();
        document.getElementById('cm').innerHTML=  cm;
          if (result < 0){
              console.log('Error en Tarjeta');
              $.confirm({
                      icon: 'fa fa-warning',
                      title: 'Error de Tarjeta',
                      content: mensaje,
                      type: 'orange',
                      typeAnimated: true,
                      buttons: {
                      tryAgain: {
                      text: 'Aceptar',
                      btnClass: 'btn-orange',
                      action: function(){
                              }
                            },
                      }
                    });
            $(document).ajaxStop($.unblockUI);
            return;
          }
          if (mensaje == "TRANSACCION REGISTRADA.")
          {
            $.confirm({
                  icon: 'fa fa-check',
                  title: 'Canje de puntos aprobado',
                  content: 'El canje de puntos se a efectuado con exito!',
                  type: 'green',
                  typeAnimated: true,
                  theme: 'supervan',
                  buttons: {
                    tryAgain: {
                    text: 'Aceptar',
                    btnClass: 'btn-green',
                    action: function(){
                        location.href ="<?php echo base_url('blue/Dpuntossucces'); ?>";
                        Gticket();
                      }
                    },
                  }
                });
          }
          if(mensaje == 'CANJE REENVIADO'){
            console.log('Error en Tarjeta');
               $.confirm({
                    icon: 'fa fa-danger',
                    title: 'Transaccion duplicada',
                    content: 'La transaccion ya fue utilizada anteriormente, favor de verificar el folio: '+result,
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                    tryAgain: {
                    text: 'Aceptar',
                    btnClass: 'btn-red',
                    action: function(){
                            }
                      },
                    }
                  });
          $(document).ajaxStop($.unblockUI);
          return;
          }
          $(document).ajaxStop($.unblockUI);


      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });

}
function printContent(el){
var restorepage = document.body.innerHTML;
var printcontent = document.getElementById(el).innerHTML;
document.body.innerHTML = printcontent;
window.print();
document.body.innerHTML = restorepage;
}

function Gticket(){
  var card = $("#numero_tarjeta").val();
  var tar = card.slice(12);
  var star = "**** **** **** "+ tar;
  var caja = document.getElementById("caja").innerHTML;
  var calle = document.getElementById("calle").innerHTML;
  var colonia = document.getElementById("colonia").innerHTML;
  var telefono = document.getElementById("telefono").innerHTML;
  var cp = document.getElementById("cp").innerHTML;
  var ciudad = document.getElementById("ciudad").innerHTML;
  var estado = document.getElementById("estado").innerHTML;
  var tienda = document.getElementById("tienda").innerHTML;
  var amb = document.getElementById("ambiente").innerHTML;
  if ( amb == "Pruebas" )
  {
    var tienda = "1";
  }
  var tipo = document.getElementById("tipo").innerHTML;
  if (tipo == "0"){
    var tipo = "Tecleado"
  }else if (tipo == "1") {
    var tipo = "Digitada"
  }

  var vendedor = document.getElementById("vendedor").innerHTML;
  var cm = document.getElementById("cm").innerHTML;
  var dd = new Date();
  currentHours = dd.getHours();
  currentHours = ("0" + currentHours).slice(-2);
  currentMin = dd.getMinutes();
  if(currentMin < 10){
  currentMin = ("0" + currentMin).slice(-2);
  }
  currentSeg = dd.getSeconds();
  if(currentSeg < 10){
  currentSeg = ("0" + currentSeg).slice(-2);
  }
  var currentDay = dd.getDate();
  if (currentDay < 10){
  currentDay = ("0" + currentDay);
  }
  var currentMoth = dd.getMonth()+1;
  if (currentMoth < 10){
  currentMoth = ("0" + currentMoth);
  }
  var fecha = '' + dd.getFullYear() + currentMoth + currentDay + currentHours + currentMin + currentSeg;
  fecha.toString();
  var fech = '' + (dd.getDate()) + "/" + (dd.getMonth()+1) + "/" + dd.getFullYear();
  var hr = '' + currentHours + ":" + currentMin + ":" + dd.getSeconds();
  var th = $("#cliente").val();
  var monto = document.getElementById("setmonto").innerHTML;
  var tipo_respuesta;
  if(amb == 'Pruebas')
  {
    tipo_respuesta = 'html';
  }else
  {
    tipo_respuesta = 'json';
  }
  $.ajax({
      url: "<?php echo base_url('blue/blue_controller/ticket'); ?>",
      data:{
        Tarjeta : star,
        Calle : calle,
        Colonia : colonia,
        Telefono : telefono,
        Cp : cp,
        Ciudad : ciudad,
        Estado : estado,
        Tienda : tienda,
        Consecutivopos : cm,
        Tipo : tipo,
        Vendedor : vendedor,
        Hora : hr,
        Fecha : fech,
        Tarjetah : th,
        Monto : monto,
        Caja : caja,
        Plataforma : amb,
        Card: card
      },
      type: "GET",
      dataType: tipo_respuesta,
      beforeSend: function() {
          $.blockUI({ message: '<h2>Generando ticket..</h2>',timeout: 30 });
      },
      success:function(res) {
      console.log(res);
      if (amb.toLowerCase() == "aptos"){
          var jsonC = JSON.stringify(res);
          RespuestaApi(jsonC);
        $.blockUI({ message: '<h1>Transacción Exitosa!!</h1><br><small>Ya puede cerrar la pantalla</small>'});
      }else if(amb.toLowerCase() == 'ec'){
        try{
            parent.RespuestaApi(res);
            $.blockUI({ message: '<h1>Transacción Exitosa!!</h1><br><small>Ya puede cerrar la pantalla</small>'});
        }catch{
            console.log('Error: No se encuentra en viewer');
            $('.modal-body').html(res);
            printContent('ticket_content');
        }
      }else{
        $('.modal-body').html(res);
        printContent('ticket_content');
      }

      },
      error: function(e){
        $(document).ajaxStop($.unblockUI);
      }
  });

}




</script>
</html>
