<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <title>Club Dp Credito</title>
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
            #monto{
              padding-left: 50px;
              font-size: 18px;
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
      <div style="text-align: center" id="ticket_content" class="modal-body">
        ...
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
                           <img id="logo" src="<?=base_url('assets/imgs/logo_clubdp.png')?>" alt="Dpvale" class="img-responsive">
                        </div>
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        <div id="formulario" class="form-group" style="text-align: center; padding-Top: 25px;  width: 100%">
        <p>  <div id="nom" class="input-group " style="text-align: center; padding-Top: 25px; visibility: hidden; padding-left: 300px; width: 80%"> <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span><strong> Nombre:</strong></span>
                    <input  style="text-align: center" type="text" id="name" class="form-control" placeholder="Nombre de cliente" disabled>
                </div>
              </div>
                <br>
                <div id="formulario" class="form-group" style="text-align: center; padding-Top: 25px; padding-left: 300px; width: 80%">
          <div class="input-group form-group-lg">
  <span class="input-group-btn">
      <button id="des" type="button" onclick="des(), changeState()" title="Digitada" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-credit-card"></span></button>
      <button id="man" type="button" onclick="man(), changeState()" title="Tecleada" class="btn btn-success btn-lg" ><span class="glyphicon glyphicon-list-alt"></span></button>
  </span>
        <input id="numero_tarjeta" placeholder="Teclee el numero de la tarjeta"  class="form-control " name="codigo" type="text" onkeypress="return validaNumericos(event)" value="" maxlength="16">
        <span class="input-group-btn">
          <button  id="buscar" onclick="consulta()" type="button" class="btn btn-success btn-lg " name="button" title="Buscar Promocion"><span class="glyphicon glyphicon-search"></span></button>
    </span>
  </div> <br>
          <div id="pr"  class="input-group form-group-lg" style="text-align: center; padding-Top: 25px; padding-left: 0px; width: 100%; visibility: hidden">
                      <span class="input-group-addon"><span class="glyphicon glyphicon-list"></span><strong> Promocion</strong></span></span>
                      <select id="promo" class="form-control"><option>Seleccione una promocion</option>

                      </select>
                  </div> <br> <br> <hr>
          <button id="pago" type="button" class="btn btn-success btn-block" onclick="compra()" disabled name="button"><span class="glyphicon glyphicon-credit-card"></span> Pagar</button>



            <p style="visibility: hidden" > <label id="plaza"></label> <label id="vend"><?=$vendedor?></label> <label id="ambiente"><?php echo $ambiente; ?></label><input onclick="changeState()" type="radio" name="options" id="d" autocomplete="off"> Digitada <input onclick="changeState()" checked="true" type="radio" name="options" id="c"> Tecleado </p>
            <label style="visibility: hidden" id="tipo">00</label>
        </div>
        <textarea style="visibility: hidden" id="detalle" rows="8" cols="80"><?=$detalle?></textarea>
        <div id="direccion" >
        <label id="calle"><?php echo $calle ?></label>
        <label id="colonia"><?php echo $colonia ?></label>
        <label id="telefono"><?php echo $telefono ?></label>
        <label id="cp"><?php echo $cp ?></label>
        <label id="ciudad"><?php echo $ciudad ?></label>
        <label id="estado"><?php echo $estado ?></label>
        </div>








<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.formatCurrency-1.4.0.min.js')?>"></script>

<script type="text/javascript">
$("#numero_tarjeta").focus();
var ttienda = document.getElementById("tienda").innerHTML;
var ncaja = document.getElementById("caja").innerHTML;
var t = ttienda.padStart(3,"0");
var c = ncaja.padStart(3,"0");
$('#caja').html(c);
$('#tienda').html(t);
$("#promo").change(function () {
$('#pago').attr("disabled", false)
});
function des(){
  $('#des').addClass("btn-success");
  $('#des').removeClass("btn-default");
  document.getElementById('buscar').style.display = 'none';
  $('#man').removeClass("btn-success");
  $('#man').addClass("btn-default");
  $("#d").prop("checked", true);
  document.getElementById('tipo').innerHTML=  "01";

}
function man(){
  $('#man').addClass("btn-success");
  $('#man').removeClass("btn-default");
document.getElementById('buscar').style.display = 'block';
  $('#des').removeClass("btn-success");
  $('#des').addClass("btn-default");
  $("#c").prop("checked", true);
  document.getElementById('tipo').innerHTML=  "00";

}
function lectora(){
  var tarjeta = $("#numero_tarjeta").val().split("ñ")[1];
  var nt = tarjeta.slice(0,16);
  var nombre = $("#numero_tarjeta").val().split("&")[1];
  document.getElementById('name').value= nombre;
  document.getElementById("numero_tarjeta").setAttribute('type','text');
  document.getElementById('numero_tarjeta').value= nt;
  var bin = $("#numero_tarjeta").val().slice(0,-10);

  $.ajax({
      url: "<?php echo base_url('dpclub/Dpclub_controller/validabin'); ?>",
      data:{
            Bin: bin
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Validando Tarjeta..</h2>',timeout: 30 });
      },
      success:function(data) {
        //console.log(data);

          $(document).ajaxStop($.unblockUI);

        var bin = data[0].num;
           if (bin == 0)
           {

             $.confirm({
           icon: 'fa fa-warning',
           title: 'Error de Tarjeta',
           content: 'La tarjeta no es Club DP, favor de ingresar una nueva tarjeta',
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
          $(document).ajaxStop($.unblockUI);


        }
        document.getElementById('pr').style.visibility = '';
        document.getElementById('nom').style.visibility = '';

        getplaza();


      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });

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
function validaBin(vbin){
var bin = $("#numero_tarjeta").val().slice(0,-10);

$.ajax({
    url: "<?php echo base_url('dpclub/Dpclub_controller/validabin'); ?>",
    data:{
          Bin: bin
    },
    type: "GET",
    dataType: "json",
    beforeSend: function() {
        $.blockUI({ message: '<h2>Validando Tarjeta..</h2>',timeout: 30 });
    },
    success:function(data) {
      console.log(data);

        $(document).ajaxStop($.unblockUI);

      var bin = data[0].num;
         if (bin == 0)
         {

           $.confirm({
         icon: 'fa fa-warning',
         title: 'Error de Tarjeta',
         content: 'La tarjeta no es Club DP, favor de ingresar una nueva tarjeta',
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


      }


    },
    error: function(){
      $(document).ajaxStop($.unblockUI);

    },
    complete: function() {

   }
});
return;
}
$('#numero_tarjeta').keyup(function(e) {
if(e.which == 13){
  var tipo = document.getElementById('tipo').innerHTML;
  if(tipo == "01"){

    lectora();

  }else
  consulta();
}
});
function getplaza(){
  var tienda = document.getElementById("tienda").innerHTML;

  $.ajax({
      url: "<?php echo base_url('dpclub/Dpclub_controller/getPlaza'); ?>",
      data:{
            Tienda: tienda
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>}Obteniendo Plaza..</h2>',timeout: 30 });
      },
      success:function(data) {
          console.log(data);
        var plaza = data[0].plaza;
        document.getElementById('plaza').innerHTML=  plaza;
          $(document).ajaxStop($.unblockUI);
         getpromo();

      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });
}
function getpromo(){

  var tarjeta = $("#numero_tarjeta").val();
  var bin = tarjeta.slice(0,-10);
  var monto = $("#setmonto").val();
  var plaza = document.getElementById("plaza").innerHTML;


  $.ajax({
      url: "<?php echo base_url('dpclub/getpromociones'); ?>",
      data:{
            Bin: bin,
            Monto:"<?=$monto?>",
            Plaza : plaza
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Buscando Promociones..</h2>',timeout: 30 });
      },
      success:function(data) {
        try {
          console.log(data);


        }catch{
          $(document).ajaxStop($.unblockUI);
        }
        var i = 0;
        $('#promo').empty();
        $("#promo").append('<option value="0">Seleccione una promocion</option>');
			$.each(data, function(value, key) {
				$("#promo").append('<option value="' + data[i].Id_Num_Promo + '">' + data[i].Desc_Promo + '</option>');
        i++;
			}); // close each()

      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });
}
function consulta(){
if (numero_tarjeta.value == ""){
$.confirm({
icon: 'fa fa-warning',
title: 'Campo vacio',
content: 'Este Campo debe de contener almenos 16 digitos',
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
return;
}

if (validar() == true)
{
return;
}
else{
  var bin = $("#numero_tarjeta").val().slice(0,-10);

  $.ajax({
      url: "<?php echo base_url('dpclub/Dpclub_controller/validabin'); ?>",
      data:{
            Bin: bin
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Validando Tarjeta..</h2>',timeout: 30000 });
      },
      success:function(data) {
        console.log(data);

          $(document).ajaxStop($.unblockUI);

        var bin = data[0].num;
           if (bin == 0)
           {

             $.confirm({
           icon: 'fa fa-warning',
           title: 'Error de Tarjeta',
           content: 'La tarjeta no es Club DP, favor de ingresar una nueva tarjeta',
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
          $(document).ajaxStop($.unblockUI);


        }


var x = document.getElementById("d").checked;
var tarjeta = $("#numero_tarjeta").val();
var tipo = document.getElementById("tipo").innerHTML;
var amb = document.getElementById("ambiente").innerHTML;
var tienda = document.getElementById("tienda").innerHTML;
var ncaja = document.getElementById("caja").innerHTML;
var caja = ncaja.padStart(5,"0");
if ( amb == "Pruebas" )
{
  var tienda = "D393251";
}

var dd = new Date()
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
var fecha = '' + dd.getFullYear() + currentMoth + currentDay + currentHours + currentMin + currentSeg
fecha.toString();

//alert(fecha);

$.ajax({
    url: "<?php echo base_url('dpclub/Dpclub_controller/getTarjeta'); ?>",
    data:{
              Tarjeta : tarjeta,
              Fecha : fecha,
              Tipo : tipo,
              Tienda : tienda,
              Caja : caja
    },
    type: "GET",
    dataType: "json",
    beforeSend: function() {
        $.blockUI({ message: '<h2>Consultando tarjeta y promocion..</h2>',timeout: 30000 });
    },
    success:function(msg) {
      xmlDoc = $.parseXML( msg ),
      $xml = $( xmlDoc ),


      $succes = $xml.find("Success");
      $saldoac = $xml.find( "SaldoActual" );
      $tarjeta = $("#numero_tarjeta").val()
      $thabiente = $xml.find("TarjetaHabiente");
      var nombre = $thabiente.text();
      var neg = $saldoac.text().slice(10);
      var nn= parseFloat($saldoac.text())
      if (neg == "-")
      {
      var nv = nn * -1;
      }
      else {
        var nv=nn;
      }
      var saldoa  = nv.toFixed(2);
      var mount = document.getElementById("setmonto").innerHTML.slice(2);

      if (Number(mount) > Number(saldoa))
      {
        $.confirm({
              icon: 'fa fa-cancel',
              title: 'Saldo Insuficiente',
              content: 'La tarjeta capturada no cuenta con el saldo suficiente para realizar la compra',
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
            return;
      }
      document.getElementById('name').value= nombre;
      document.getElementById('pr').style.visibility = '';
      document.getElementById('nom').style.visibility = '';
      //demoAbout(window.navigator.appVersion, document.URL);
        getplaza();
        $(document).ajaxStop($.unblockUI);



    },
    error: function(){
      $(document).ajaxStop($.unblockUI);

    },
    complete: function() {

   }
});
},
error: function(){
  $(document).ajaxStop($.unblockUI);

},
complete: function() {

}
});

}//fin else
}
function compra(){
  var tarjeta = $("#numero_tarjeta").val();
  var th = $("#name").val();
  //validaBin();

  if (tarjeta == "")
  {
    $.confirm({
  icon: 'fa fa-warning',
  title: 'Error campo vacio',
  content: 'No se a ingresado una tarjeta, favor de ingresar una',
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

  return;
  }
  var promo = $("#promo").val();
  if (promo == "0")
  {
    $.confirm({
  icon: 'fa fa-warning',
  title: 'Error',
  content: 'No se a seleccionado alguna promocion, favor de seleccionar una',
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

  return;
  }
  var monto = document.getElementById("setmonto").innerHTML.slice(2);
  var tienda = document.getElementById("tienda").innerHTML;
  var amb = document.getElementById("ambiente").innerHTML;
  var tienda = document.getElementById("tienda").innerHTML;
  if ( amb == "Pruebas" )
  {
    var tienda = "D393251";
  }
  var tipo = document.getElementById("tipo").innerHTML;
  var detalle = $("#detalle").val();
  var ndetalle = encodeURI(detalle);
  var tmonto = document.getElementById("setmonto").innerHTML;
  var ttienda = document.getElementById("tienda").innerHTML;
  var ncaja = document.getElementById("caja").innerHTML;
  var vendedor = document.getElementById("vend").innerHTML;
  var calle = document.getElementById("calle").innerHTML;
  var colonia = document.getElementById("colonia").innerHTML;
  var telefono = document.getElementById("telefono").innerHTML;
  var cp = document.getElementById("cp").innerHTML;
  var ciudad = document.getElementById("ciudad").innerHTML;
  var estado = document.getElementById("estado").innerHTML;
  var caja = ncaja.padStart(5,"0");
  var dd = new Date()
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
  var fecha = '' + dd.getFullYear() + currentMoth + currentDay + currentHours + currentMin + currentSeg
  fecha.toString();
  var fech = '' + (dd.getDate()) + "/" + (dd.getMonth()+1) + "/" + dd.getFullYear()
  var hr = '' + currentHours + ":" + currentMin + ":" + dd.getSeconds()
  var tar = tarjeta.slice(12)
  var star = "**** **** **** "+ tar;

  $.ajax({
      url: "<?php echo base_url('dpclub/consulta'); ?>",
      data:{
            Tarjeta : tarjeta,
            Promo : promo,
            Monto : monto,
            Tienda : tienda,
            Caja : caja,
            Tipo : tipo,
            Fecha : fecha,
            Detalle : ndetalle
      },
      type: "GET",
      dataType: "json",
      beforeSend: function() {
          $.blockUI({ message: '<h2>Validando..</h2>',timeout: 3000 });
      },
      success:function(data) {
        try {
          console.log(data);
          xmlDoc = $.parseXML( data ),
          $xml = $( xmlDoc ),

          $succes = $xml.find("Success");
          $mensaje = $xml.find("Mensaje");

          $cm = $xml.find("ConsecutivoPOS");
          var exito = $succes.text();
          var mensaje = $mensaje.text();

          var cm = $cm.text();
          if (tipo = "00"){
            tipo = "Tecleada"
          }else {
            tipo = "Digitada"
          }
          var tipo_respuesta;
          if(amb == 'Pruebas')
          {
            tipo_respuesta = 'html';
          }else
          {
            tipo_respuesta = 'json';
          }
          if (mensaje == "FORMAT ERROR")
          {
            $.confirm({
          icon: 'fa fa-warning',
          title: 'Error de formato',
          content: 'Formato invalido favor de verificar con proveedor',
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
              url: "<?php echo base_url('dpclub/Dpclub_controller/ticket'); ?>",
              data:{
                    Tarjeta : star,
                    Hora : hr,
                    Fecha : fech,
                    Tarjetah : th,
                    Tienda : ttienda,
                    Monto : tmonto,
                    Promo : promo,
                    Caja : ncaja,
                    Consecutivopos : cm,
                    Tipo : tipo,
                    Vendedor : vendedor,
                    Calle : calle,
                    Colonia : colonia,
                    Telefono : telefono,
                    Cp : cp,
                    Ciudad : ciudad,
                    Estado : estado,
                    Plataforma : amb
              },
              type: "GET",
              dataType: tipo_respuesta,
              beforeSend: function() {
                  $.blockUI({ message: '<h2>Generando ticket..</h2>',timeout: 300 });
              },
              success:function(res) {
              console.log("respuesta ticket"+res);

              if (exito == "true"){
                $.confirm({
                      icon: 'fa fa-check',
                      title: 'Compra Aprobada',
                      content: 'El pago se a efectuado con exito!',
                      type: 'green',
                      typeAnimated: true,
                      theme: 'supervan',
                      buttons: {
                        tryAgain: {
                        text: 'Aceptar',
                        btnClass: 'btn-green',
                        action: function(){
                            printContent(amb,res);
                            location.href ="<?php echo base_url('dpclub/Dpclubsucces'); ?>";
                          }
                        },
                      }
                    });

                  }
                  else {
                    $.confirm({
                          icon: 'fa fa-warning',
                          title: 'Error en la compra',
                          content: 'El pago no pudo ser efectuado',
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
                  }

              },
              error: function(e){
                alert('Error en efectuar el pago');
                $(document).ajaxStop($.unblockUI);
              }
          });


        }catch{
          $(document).ajaxStop($.unblockUI);
        }

      },
      error: function(){
        $(document).ajaxStop($.unblockUI);

      },
      complete: function() {

     }
  });

}

function printContent(amb, res){
  if(amb == 'aptos'){
    var jsonC = JSON.stringify(res);
    RespuestaApi(jsonC);
  }else if(amb == 'ec'){
    var jsonC = JSON.stringify(res);
    parent.RespuestaApi(jsonC);
  }else{
    $('.modal-body').html(res);

  }


}

</script>
</html>
