<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>Dpvale</title>
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
              height: 200px;
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
            #oculta_detallado_canjeante p {
                margin: -5px 0 10px;
            }
      </style>
    <div class="hide" id="div-ticket"></div>
    <div class="container-fluid">
        <div class="panel panel-default bloque1" id="panel1">
          <div class="panel-body">
            <div id="busqueda" class="buscar">
              <div class="row">
                  <div class="col-xs-7 col-sm-4 col-md-4 col-lg-4">
                    <div class="input-group form-group-lg">
                      <span class="input-group-addon"><b>FOLIO</b></span>
                      <input type="text" class="form-control" placeholder="0000000000" id="folio_vale" value="" autocomplete="off" maxlength="10">
                      <span class="input-group-btn">
                        <button class="btn btn-success btn-lg" type="button" id="btn_busca_folio">
                          <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                          </button>
                      </span>
                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2">
                      <div class="form-group form-group-lg">
                          <div id="montovale" class="show">
                              <label id="tipo_de_vale">Monto Vale</label>
                              <p class="info_credito" id="monto_credito">$ 0.00</p>
                          </div>
                          <div id="monto_manual" class='hide'>
                               <span><b>Monto vale</b></span>
                               <input type="text" class="form-control font-up" placeholder="0.00" id="monto_vale_manual" autocomplete="off">
                          </div>
                      </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2">
                    <div class="input-group form-group-lg">
                    <!--<span class="input-group-addon"><b>Monto $</b></span>
                       <input type="text" class="form-control" placeholder="0.00" id="setmonto" value="<?=$monto?>" autocomplete="off">
                    -->
                      <label>Monto a pagar</label>
                      <p class="info_credito" id="setmonto"><?php echo "$ ".number_format($monto,2,'.',',');?></p>

                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2">
                    <div class="input-group form-group-lg">
                      <label>Tope de Venta</label>
                      <p class="info_credito" id="setlimite"><?php echo "$ ".number_format($tope,2,'.',',');?></p>

                    </div>
                  </div>
                  <div class="col-md-2 col-sm-2 col-lg-2 pull-right">
                      <div class="form-group">
                         <img id="logo" src="<?=base_url('assets/imgs/logo_dpvale.png')?>" alt="Dpvale" class="img-responsive">
                      </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
    <div class="row ">
      <!-- DISTRIBUIDOR -->
        <div class="col-sm-6">
          <div class="panel panel-default" id="panel2">
            <div class="panel-heading" style="height:40px"><b class="pull-left">DISTRIBUIDOR</b><b class="pull-right info_descripcion" id="txtdistribuidor"></b></div>
            <div class="panel-body">
              <form >
                  <div class="form-group">
                    <label for="txtnombredist" class="col-sm-12 control-label">Nombre Distribuidor</label>
                      <input type="text" class="form-control" id="txtnombredist" tabIndex="-1" readonly>
                    </div>
                <hr/>
                <div id="lienzo" class="firma hidden">
                  <img id="firma" src="" >
                </div>
              </form>
            </div>
          </div>
          <p><?='Tienda: '.str_pad($tienda, 5, "0", STR_PAD_LEFT).' / Caja: '.str_pad($caja, 5, "0", STR_PAD_LEFT);?></p>
		  <p><?php if($pedido != ''){echo "Procesando pedido: ".str_pad($pedido, 10, "0", STR_PAD_LEFT);}?></p>
          <div id="muestraJson"><small>Plataforma: <?php if($plataforma == 'pruebas'){echo 'Ecommerces';}else{echo $plataforma;}?><small></div>
        </div>
      <!-- CANJEANTE -->
        <div class="col-sm-6">
          <div class="panel panel-default" id="panel3">
            <div class="panel-heading" style="height:40px"><b class="pull-left">CANJEANTE</b>
              <b class="pull-right info-canjeante">
                <button class="btn btn-default" type="button" id="btn_modal_busca_canjeante" href="#myModal-canjeante-search" data-toggle="modal" disabled="disabled">
                  <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                </button>
                <button class="btn btn-default" type="button" id="btn_modal_edita_canjeante" href="#myModal-canjeante-edit" data-toggle="modal" disabled="disabled">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </button>
                <input type="hidden" id="txtcanjeante_vale" name="txtcanjeante_vale">
              </b>
            </div>
            <div class="panel-body">
              <div id="mensaje_detalle_canjeante" class="show">
                <p id="texto_detallado_canjeante"></p>
              </div>
              <div id="oculta_detallado_canjeante" class="hide">
                <div class="form-horizontal1">
                    <p><b>Nombre: </b> <span id="canjeante_nombre"> </span></p>
                    <p><b>Dirección: </b> <span id="canjeante_direccion"> </span></p>
                    <p><b>Num Int: </b> <span id="canjeante_numint"> </span>
                     <b> Num Ext: </b> <span id="canjeante_numext"> </span></p>
                     <p><b>Codigo Postal: </b> <span id="canjeante_cp"> </span></p>
                     <p><b>Colonia: </b> <span id="canjeante_colonia"> </span></p>
                     <p><b>Ciudad: </b> <span id="canjeante_ciudad"> </span></p>
                     <p><b>Estado: </b> <span id="canjeante_estado"> </span></p>
                     <p><b>Sexo: </b> <span id="canjeante_sexo"> </span></p>
                     <p><b>Telefono: </b> <span id="canjeante_telefono"> </span></p>
                     <p><b>Fecha Nac.: </b> <span id="canjeante_fnacimiento"> </span></p>
                     <p><b>Saldo disponible: </b> <span id="canjeante_saldo_disponible"> </span></p>
                     <p><b>RFC: </b> <span id="canjeante_rfc"> </span></p>
                     <p><b>Curp: </b> <span id="canjeante_curp"> </span></p>
                  </li>
                </div>
              </div>
            </div><!-- END panel-body-->
            <div class="panel-footer text-right">
              <div class="btn-group" role="group" aria-label="...">
                  <div class="pull-right">
                    <button class="btn btn-success btn-lg hide" type="button" id="btn_set_venta">
                      <span class="glyphicon glyphicon-disk" aria-hidden="true"></span>REALIZAR VENTA
                    </button>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>


<!--MODALES -->
<div class="modal fade" id="myModal-canjeante-edit">
   <div class="modal-dialog modal-lg">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             <h3 class="modal-title"><b>Editar Canjeante</p></h3>
           </div>
                 <div class="modal-body">
                   <div class="row">
                     <div class="form-group hidden" id="canjeante_nombres">
                       <label for="txtcanjeante_nombre1" class="col-sm-2 control-label">Primer Nombre</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_nombre1" readonly>
                       </div>
                       <label for="txtcanjeante_nombre2" class="col-sm-2 control-label">Segundo Nombre</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_nombre2" readonly>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="form-group hidden"  id="canjeante_apellidos">
                       <label for="txtcanjeante_apaterno" class="col-sm-2 control-label">Apellido Paterno</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_apaterno" readonly>
                       </div>
                       <label for="txtcanjeante_amaterno" class="col-sm-2 control-label">Apellido Materno</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_amaterno" readonly>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="form-group">
                       <label for="txtcanjeante_direccion" class="col-sm-2 control-label">Direccion</label>
                       <div class="col-sm-10">
                         <input type="text" class="form-control" id="txtcanjeante_direccion" readonly>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                   <div class="row">
                     <div class="form-group">
                       <label for="txtcanjeante_numext" class="col-sm-2 control-label">Num Exterior</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_numext" readonly>
                       </div>
                       <label for="txtcanjeante_numint" class="col-sm-2 control-label">Num Interior</label>
                       <div class="col-sm-4">
                         <input type="text" class="form-control" id="txtcanjeante_numint" readonly>
                       </div>
                       <div class="clearfix"></div>
                    </div>
                   </div>
                   <div class="row">
                     <div class="form-group">
                       <label for="txtcanjeante_cp" class="col-sm-2 control-label">Codigo Postal</label>
                       <div class="col-sm-10">
                         <input type="number" class="form-control" id="txtcanjeante_cp" readonly>
                       </div>
                       <div class="clearfix"></div>
                     </div>
                   </div>
                   <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_colonia" class="col-sm-2 control-label">Colonia</label>
                     <div class="col-sm-10">
                       <!--<input type="text" class="form-control" id="txtcanjeante_colonia" readonly>-->
                       <select class="form-control" id="txtcanjeante_colonia" readonly>
                         <option value="0"></option>
                       </select>
					   <input type="hidden" class="form-control" id="txtcanjeante_settlement" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_ciudad" class="col-sm-2 control-label">Ciudad</label>
                     <div class="col-sm-10">
                       <input type="text" class="form-control" id="txtcanjeante_ciudad" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_estado" class="col-sm-2 control-label">Estado</label>
                     <div class="col-sm-10">
                       <input type="text" class="form-control" id="txtcanjeante_estado" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_sexo" class="col-sm-2 control-label">Sexo</label>
                     <div class="col-sm-10">
                       <select class="form-control" id="txtcanjeante_sexo" readonly>
                         <option value="0"></option>
                         <option value="1">HOMBRE</option>
                         <option value="2">MUJER</option>
                       </select>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_telefono" class="col-sm-2 control-label">Telefono</label>
                     <div class="col-sm-10">
                       <input type="number" class="form-control" id="txtcanjeante_telefono" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group">
                     <label for="txtcanjeante_fnacimiento" class="col-sm-2 control-label">Fecha Nacimiento</label>
                     <div class="col-sm-10">
                       <input type="date" class="form-control" id="txtcanjeante_fnacimiento" readonly placeholder="AAAA-MM-DD"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Favor de usar formato AAAA-MM-DD"/>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="form-group" id="canjeante_rfc">
                     <label for="txtcanjeante_rfc" class="col-sm-2 control-label">RFC</label>
                     <div class="col-sm-10">
                       <input type="text" class="form-control" id="txtcanjeante_rfc" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
                 </div>
               <div class="row">
                   <div class="form-group" id="canjeante_curp">
                     <label for="txtcanjeante_curp" class="col-sm-2 control-label">CURP</label>
                     <div class="col-sm-10">
                       <input type="text" class="form-control" id="txtcanjeante_curp" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
               </div>
               <div class="row">
                   <div class="form-group" >
                     <label for="txtcanjeante_saldo_disponible" class="col-sm-2 control-label">Saldo Disponible</label>
                     <div class="col-sm-10">
                       <input type="text" class="form-control" id="txtcanjeante_saldo_disponible" readonly>
                     </div>
                     <div class="clearfix"></div>
                   </div>
               </div>
                 </div>
                 <div class="modal-footer text-right">
                   <div class="btn-group" role="group" aria-label="...">
                     <button class="btn btn-success pull-left" type="button" id="btn_actualiza_save" autocomplete="off">
                       <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
                       Guardar</button>
                     <button class="btn btn-danger pull-right" type="button" id="btn_actualiza_cancelar" data-dismiss="modal">
                       <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                       Cancelar</button>
                   </div>
                 </div>
             </div><!-- /.modal-content -->
           </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->
<div class="modal fade" id="myModal-canjeante-search" tabindex="-1" role="dialog">
 <div class="modal-dialog">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
           <h5 class="modal-title"><b>Busqueda de Canjeante</p></h5>
         </div>
         <div class="modal-body">
               <div class="col-lg-12 col-sm-12 col-sx-12 col-md-12">
               <label for="txtcanjeante_nombre" class="hidden-xs col-sm-1 control-label"></label>
               <div class="input-group form-group-lg">
                 <input type="text" class="form-control" placeholder="Buscar Canjeante" id="txtcanjeante_nombre" readonly autocomplete="off">
                 <span class="input-group-btn">
                   <button class="btn btn-default btn-lg" type="button" id="btn_busca_canjeante" disabled="disabled">
                     <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                   </button>
                 </span>
               </div>
                 <small  class="help-block">Verde: Activos, Rojo: Deshabilitado</small>
               <br>
             </div>

                 <table id="tabla_canjeantes" class="table table-hover">
                    <thead>
                      <tr>
                          <th>Folio</th>
                          <th>Nombre</th>
                          <th>Estado</th>
                          <th>Ciudad</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
               <div class="form-group">
                 <input type="button" class="btn btn-warning btn-sm pull-right" value="Limpiar" id="btn_limpiar_search">
                 <div class="clearfix"></div>
               </div>
         </div>
       </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
        <h4 class="modal-title " id="myModalLabel">ALTA DE CANJEANTE</h4>
      </div>
      <div class="modal-body">
          <div class="form-horizontal" id="formulario_registro">
            <div class="form-group">
              <label for="registro_nombre1" class="col-sm-2 control-label">Primer Nombre</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_nombre1">
              </div>
              <label for="registro_nombre2" class="col-sm-2 control-label">Segundo Nombre</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_nombre2">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_apaterno" class="col-sm-2 control-label">Apellido Paterno</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_apaterno">
              </div>
              <label for="registro_amaterno" class="col-sm-2 control-label">Apellido Materno</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_amaterno">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_direccion" class="col-sm-2 control-label">Direccion</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="registro_direccion">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_numext" class="col-sm-2 control-label">Num Exterior</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_numext">
              </div>
              <label for="registro_numint" class="col-sm-2 control-label">Num Interior</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="registro_numint">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_cp" class="col-sm-2 control-label">Codigo Postal</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="registro_cp">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_colonia" class="col-sm-2 control-label">Colonia</label>
              <div class="col-sm-10">
                <select class="form-control" id="registro_colonia">
                  <option value="0"></option>
                </select>
				<input type="hidden" class="form-control" id="registro_settlement" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="registro_ciudad" class="col-sm-2 control-label">Ciudad</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="registro_ciudad" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="registro_estado" class="col-sm-2 control-label">Estado</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="registro_estado" readonly>
              </div>
            </div>
            <div class="form-group">
              <label for="registro_sexo" class="col-sm-2 control-label">Sexo</label>
              <div class="col-sm-10">
                <select class="form-control" id="registro_sexo">
                  <option value="0"></option>
                  <option value="1">HOMBRE</option>
                  <option value="2">MUJER</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="registro_telefono" class="col-sm-2 control-label">Telefono</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="registro_telefono">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_fnacimiento" class="col-sm-2 control-label">Fecha Nacimiento</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" id="registro_fnacimiento" placeholder="DD-MM-AAAA"  pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" title="Favor de usar formato AAAA-MM-DD" />
              </div>
            </div>
            <div class="form-group">
              <label for="registro_rfc" class="col-sm-2 control-label">RFC</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="registro_rfc">
              </div>
            </div>
            <div class="form-group">
              <label for="registro_curp" class="col-sm-2 control-label">CURP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="registro_curp">
              </div>
            </div>
          </div>
          </div><!-- Container MODAL -->
          <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="registro_cancelar">
          <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
          Cancelar</button>
        <button type="button" class="btn btn-success" id="registro_guardar">
          <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>
          Guardar Nuevo</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal-promociones" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             <h5 class="modal-title"><b>Seleccione Promoción</p></h5>
           </div>
           <div class="modal-body">
                 <div class="col-lg-12 col-sm-12 col-sx-12 col-md-12">
                   <table id="tabla_promociones" class="table table-hover">
                      <thead>
                        <tr>
                            <th>Quincenas</th>
                            <th>pagoQuincenal</th>
                            <th>FechaPago</th>
                            <th>Promoción</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                    <div class="clearfix"></div>
           </div>
           <div class="modal-footer">
             <div class="form-group">
               <input type="button" class="btn btn-success btn-lg btn-block" value="ACEPTAR" id="btn_acepta_promo">
               <div class="clearfix"></div>
             </div>
           </div>
         </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<div class="modal fade" id="myModal-beneficiario" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header">
             <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
             <h5 class="modal-title"><h3><b>Ingrese Beneficiario</b></h3></p></h5>
           </div>
           <div class="modal-body">

                   <form id="form-beneficiario">
                         <div class="form-group">
                           <label for="beneficiario_nombre">Nombre(s)</label>
                           <input type="text" class="form-control" id="beneficiario_nombre" name="beneficiario_nombre" placeholder="">
                         </div>
                         <div class="form-group">
                           <label for="beneficiario_paterno">Apellido Paterno</label>
                           <input type="text" class="form-control" id="beneficiario_paterno" name="beneficiario_paterno" placeholder="">
                         </div>
                         <div class="form-group">
                           <label for="beneficiario_materno">Apellido Materno</label>
                           <input type="text" class="form-control" id="beneficiario_materno" name="beneficiario_materno" placeholder="">
                         </div>
                         <div class="form-group">
                            <label for="beneficiario_parentesco">Parentesco</label>
                             <select class="form-control input-lg" id="beneficiario_parentesco" name="beneficiario_parentesco">
                            </select>
                         </div>
                        <div class="form-group">
                          <label for="beneficiario_porcentaje">Porcentaje</label>
                          <div class="input-group">
                              <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="3" class="form-control input-lg" id="beneficiario_porcentaje" name="beneficiario_porcentaje" value="100">
                              <span class="input-group-addon">%</span>

                          </div>
                          <span class="help-block"><small>El Maximo de porcentaje a otorgar es de 100%</small></span>
                        </div>

                    <div class="clearfix"></div>

           <div class="modal-footer">
             <div class="form-group">
               <input type="button" class="btn btn-success btn-lg btn-block" value="ACEPTAR BENEFICIARIO" id="btn_acepta_beneficiario">
               <div class="clearfix"></div>
             </div>
           </div>
           </form>
         </div><!-- /.modal-content -->
       </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</div>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.formatCurrency-1.4.0.min.js')?>"></script>

<script>
$("#folio_vale").focus();
var block = false;
var amount = "<?=$monto?>";
tope = "<?=$tope?>";
var pedido = "<?=$pedido?>";
REVALEOK = '';
b_nombre     = '';
b_parentesco = '';
b_porcentaje = '';
seguro_quincenas ='';
seguro_total ='';
seguro_desde ='';
seguro_hasta ='';
seguro_costo = 0;
es_revale = false;

$("#btn_busca_folio").on("click", function(){
  if(!block){
  	var xfolio = $("#folio_vale").val();
  					 if(xfolio) {
                if(xfolio.length === 10){
  							 $.ajax({
  									 url: "<?php echo base_url('dpvale/getvale'); ?>",
  									 type: "GET",
  									 dataType: "json",
  									 data:{ folio : xfolio,token: "<?php echo $hash; ?>" },
  	                 beforeSend: function() {
                        limpiaDistribuidor();
                        limpiaModalRegistro();
                        limpiarCanjeante();
                        limpiarCanjeante_busqueda();
                        $("#txtcanjeante_nombre").val('');
  	                    $.blockUI({ message: '<h2>Validando Folio..</h2>',timeout: 30000,baseZ: 9000 });
  	                 },
  									 success:function(data) {
                       var xml = data.response;
                       console.log(xml);
                      try{
                          if(xml.coupon.status == 3){
                            var siguiente = cargarDatos(xml);
                            if(siguiente == true){
                              verficaCanjeante(xml);
                              bloqueo();
                            }
                          }else{
                                var $texto = leyendas(xml.coupon.status);
                                mensaje('aviso',$texto);
                            }

                     }catch(err) {
                        $(document).ajaxStop($.unblockUI);
                        var $texto = leyendas(xml.ErrorMessage.status);
                        var $error = xml.ErrorMessage.msn;
                        mensaje('error','<h1>'+$texto+'</h1><br><div class="mensaje_tecnico"><small><b>Descripción Técnica del Error</b><br>'+$error+'<br>'+err.message+'</small></div>');
                      }

  									 },
  	                 complete: function() {
  	                     $(document).ajaxStop($.unblockUI);
  	               	}
  							 });
               }else{
                 mensaje('alerta',"El DPVALE debe contener 10 digitos",'$("#folio_vale").focus()');
               }
             }else{
  							 mensaje('alerta',"Favor de agregar un folio DPVALE",'$("#folio_vale").focus()');
  					 };
  }else{
    mensaje('alerta2',"¿Desea hacer una nueva consulta? <br> AVISO: Esto limpiara todos los datos");
  }
});

function bloqueo(){
  if(block == true){
        $("#folio_vale").removeAttr('disabled').removeAttr('readonly');
        $("#btn_busca_folio").html('<span class="glyphicon glyphicon-search" aria-hidden="true"></span>').removeClass('btn-danger').addClass('btn-success');
        block = false;
        limpiaDistribuidor();
        limpiaModalRegistro();
        limpiarCanjeante();
        limpiarCanjeante_busqueda();
        limpia_busqueda();
        $("#folio_vale,#txtcanjeante_nombre").val('');
        $("#folio_vale").focus();
        $('#btn_set_venta').addClass('hide');
        $("#texto_detallado_canjeante").html('').removeClass('alert');
        $('#btn_modal_busca_canjeante').attr('disabled','disabled').attr('readonly',true);
  }else{
        $("#folio_vale").attr('disabled','disabled').attr('readonly',true);
        $("#btn_busca_folio").html('<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>').removeClass('btn-success').addClass('btn-danger');
        block = true;
  }
}

function cargarDatos(xml)
{
    nombre = xml.distributor.name + ' ';
    nombre2 = (xml.distributor.middleName == null || xml.distributor.middleName == 'null')?'':xml.distributor.middleName+ ' ';
    apellidop = (xml.distributor.lastName == null || xml.distributor.lastName == 'null')?'':xml.distributor.lastName+ ' ';
    apellidom = (xml.distributor.secondLastName == null || xml.distributor.secondLastName == 'null')?'':xml.distributor.secondLastName;
    congelado1 = xml.distributor.status;
    congelado2 = xml.credit.status;
    congelado3 = xml.credit.currentMora;
    availables = xml.credit.available;
    firma = xml.distributor.signature;
    folio = xml.coupon.id;
    monto_del_vale = Number(xml.coupon.amount);
    tipo_vale = xml.coupon.id_charge_type;
    tiene_promo = xml.coupon.enable_offer;
    monto_a_cargar = Number(<?php echo $monto; ?>);
    distributor = xml.distributor.number;
    vXML = xml;
    if(xml.parent != null ){
     es_revale = true;
     $("#tipo_de_vale").html('Monto Revale');
   }else{
     es_revale = false;
      $("#tipo_de_vale").html('Monto Vale');
   }

    /*congelado en sistema*/
    if(congelado1 == 2 || (congelado2 == 2 || congelado2 == 4 || congelado2 == 6 || congelado2 == 7) || congelado3 > 0)
    {
      $congesistema = 'SI';
    }else{
      $congesistema = 'NO';
    }

    /*congelado en oficina*/
    if(congelado2 == 2 || congelado2 == 4 || congelado2 == 6 || congelado2 == 7)
    {
      $congeoficina='SI';
    }else{
      $congeoficina='NO';
    }

    if(congelado2 == 5){
      $bloqueado = 'SI';
    }else{
      $bloqueado = 'NO';
    }

    if(tipo_vale == 2)
    {
      mensaje('error', 'Vale asignado a Financiero no es posible canjearlo en Calzado');
      return false;
    }

    $credito_manual = availables - monto_a_cargar;
    if($credito_manual < 0 && availables > 0)
    {
      mensaje('error', '<h2>Monto disponible en vale es de: <b>'+ availables.toFixed(2) +'</b>, favor de verificar</h2>');
      return false;
    }

    if( monto_del_vale == 0 || typeof monto_del_vale === 'object')
    {
      $('#monto_manual').removeClass('hide').addClass('fix-input-margen');
      $('#monto_vale_manual').focus();
      $('#montovale').removeClass('show').addClass('hide');
    }

    $credito = monto_del_vale - monto_a_cargar;
    if($credito < 0 && monto_del_vale > 0)
    {
      mensaje('error', '<h2>Monto disponible en vale es de: <b>'+ monto_del_vale.toFixed(2) +'</b>, favor de verificar</h2>');
      return false;
    }


    $("#txtdistribuidor").html(distributor);
    $("#txtnombredist").val(nombre + nombre2 + apellidop + apellidom);
    nombre_distributor = nombre + nombre2 + apellidop + apellidom;
    $("#lienzo").removeClass('hidden');
    $("#firma").attr('src','data:image/png;base64,'+firma);
    $("#txtfolio").val(folio);
    if(typeof monto_del_vale  !== 'object' && typeof monto_del_vale  !== 'undefined')
    {
        var monto = monto_del_vale;
        $("#monto_credito").html( '$ ' + monto ).formatCurrency();
    }

    return true;
}

function verficaCanjeante(xml){
  idCustomer = xml.coupon.idCustomer;
  var conOfi = $congeoficina;
  var conSis = $congesistema;
  if( conOfi == 'SI' || conSis == 'SI' || $bloqueado == 'SI'){
    if(conOfi == 'SI'){
      $("#texto_detallado_canjeante").html('El Distribuidor esta congelado desde Oficina').addClass('alert');
    }else{
      $("#texto_detallado_canjeante").html('El Distribuidor esta congelado desde Sistema').addClass('alert');
    }
    if($bloqueado == 'SI'){
      $("#texto_detallado_canjeante").html('El Distribuidor se encuentra bloqueado').addClass('alert');
    }
    $('#txtcanjeante_nombre').attr('disabled','disabled').attr('readonly',true);
    $('#btn_busca_canjeante').attr('disabled','disabled').attr('readonly',true);
    $('#btn_modal_busca_canjeante').attr('disabled','disabled').attr('readonly',true);
  }else{
    $('#txtcanjeante_nombre').removeAttr('disabled').removeAttr('readonly');
    $('#btn_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
    $('#btn_modal_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
    if(idCustomer > 0){
      getCanjeante(idCustomer);
    }else{
      $("#texto_detallado_canjeante").html('Canjeante no asignado, favor de buscarlo y seleccionarlo');
    }
  }
}

function getCanjeante(folio){
  $.ajax({
      url: "<?php echo base_url('dpvale/getcanjeante'); ?>",
      type: "GET",
      dataType: "json",
      data:{ folio : folio, token: "<?php echo $hash; ?>" },
      beforeSend: function() {
          $.blockUI({ message: "<h2> Validando  Canjeante </h2>",timeout: 30000,baseZ: 9000 });
      },
      success:function(data) {
       try {
         var canje = data.response;
         console.log(canje);

         if(canje.status == 1){
           if(canje.results.length > 1){
             $("#texto_detallado_canjeante").html('Canjeante no asignado, favor de buscarlo y seleccionarlo');
             cargatabla(canje.results);
           }else{
             if(canje.results[0].status == 1){
               cargaCanjeante(canje.results);
               $("#myModal-canjeante-search").modal('hide');
               $('#btn_set_venta').removeClass('hide');
               $('#btn_modal_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
             }else{
               mensaje('error','El canjeante esta bloqueado!');
             }
           }

         }else{
           if(typeof canje != 'object'){
             var $texto = "Se detecto lentitud, favor de lanzar de nuevo la busqueda";
             var $error = '#00005';
             mensaje('aviso','<h1>'+$texto+'</h1><br><div class="mensaje_tecnico"><small><b>Descripción Técnica del Error</b><br>'+$error+'<br>'+canje+'</small></div>');
           }else{
             mensaje('aviso2',"Canjeante no encontrado, ¿Que desea realizar?");
           }
         }

       }catch(err) {
         mensaje('error','Favor de verificar el canjeante e intentarlo de nuevo. <br>'+err.message);
       }
            /**/
      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });
}

function cargaCanjeante(cj){
    $('#oculta_detallado_canjeante').removeClass('hide');
    $('#mensaje_detalle_canjeante').removeClass('show').addClass('hide');
    cj = cj[0];
    n1=(cj.name == null)?'':cj.name+ ' ';
    n2=(cj.middleName == null)?'':cj.middleName+ ' ';
    a1=(cj.lastName == null)?'':cj.lastName+ ' ';
    a2=(cj.secondLastName == null)?'':cj.secondLastName+' ';
    var nstatus = (cj.status == 1)?'Habilitado':(cj.status == 2)?'Deshabilitado':'Bloqueado';
    var saldo = (cj.customer_available > 0 )?cj.customer_available:0;
    var sexo = (cj.gender == 1)?'Hombre':'Mujer';
    nc=n1+n2+a1+a2;
    /*CARGA EN DETALLE */
    console.log(cj);
     idCustomer = cj.id;
     nombre_canjeante = nc;
     telefono_canjeante = cj.phones[0].number;
     rfc_canjeante = cj.rfc;
     sexo_canjeante = (cj.gender == 1)?'Masculino':'Femenino';
     $('#txtcanjeante_vale').val(cj.id);
     $("#canjeante_direccion").html(cj.address.street);
     $("#canjeante_numext").html(cj.address.house_number);
     $("#canjeante_numint").html(cj.address.apartment_number);
     $("#canjeante_cp").html(cj.address.zipcode);
     $("#canjeante_colonia").html(cj.address.neighborhood);
     $("#canjeante_ciudad").html(cj.address.city);
     $("#canjeante_estado").html(cj.address.state);
     $("#canjeante_sexo").html(sexo);
     $("#canjeante_telefono").html(cj.phones[0].number);
     $("#canjeante_fnacimiento").html(cj.birthdate);
     $("#canjeante_saldo_disponible").html(saldo.toFixed(2));
     $("#mensaje_txtcanjeante_nombre").html('<small>'+ cj.status+ ' - '+nstatus+'</small>');
     $("#canjeante_nombre1").html(cj.name);
     $("#canjeante_nombre2").html(cj.middleName);
     $("#canjeante_apaterno").html(cj.lastName);
     $("#canjeante_amaterno").html(cj.secondLastName);
     $("#canjeante_rfc").html(cj.rfc );
     $("#canjeante_curp").html(cj.curp);
     $("#canjeante_nombre").html(nc);
    /*CARGA EN BUSQUEDA */
     $("#txtcanjeante_direccion").val(cj.address.street);
     $("#txtcanjeante_numext").val(cj.address.house_number);
     $("#txtcanjeante_numint").val(cj.address.apartment_number);
     $("#txtcanjeante_cp").val(cj.address.zipcode);
     $("#txtcanjeante_colonia").empty().append('<option value="'+cj.address.neighborhood+'">'+cj.address.neighborhood+'</option>');
	 $("#txtcanjeante_settlement").html(cj.address.settlement);
     $("#txtcanjeante_ciudad").val(cj.address.city);
     $("#txtcanjeante_estado").val(cj.address.state);
     $("#txtcanjeante_sexo").val(cj.gender);
     $("#txtcanjeante_telefono").val(cj.phones[0].number);
     $("#txtcanjeante_fnacimiento").val(cj.birthdate);
     $("#txtcanjeante_saldo_disponible").val(saldo).formatCurrency();
     $("#mensaje_txtcanjeante_nombre").html('<small>'+cj.status+ ' - '+nstatus+'</small>');
     $("#txtcanjeante_nombre1").val(cj.name);
     $("#txtcanjeante_nombre2").val(cj.middleName);
     $("#txtcanjeante_apaterno").val(cj.lastName);
     $("#txtcanjeante_amaterno").val(cj.secondLastName);
     $("#txtcanjeante_rfc").val(cj.rfc);
     $("#txtcanjeante_curp").val(cj.curp);
     habilitarCampos();

     $('#btn_modal_busca_canjeante').attr('disabled','disabled').attr('readonly',true);
     $('#btn_modal_edita_canjeante').removeAttr('disabled').removeAttr('readonly');

}

$("#btn_actualiza_save").on("click", function(){
    $(this).attr('disabled','disabled').html('Actualizando Datos...');
    $.ajax({
        url: "<?php echo base_url('dpvale/saveCustomer'); ?>",
        type: "GET",
        dataType: "json",
        data:{
          idcustomer : $("#txtcanjeante_vale").val(),
          direccion : $("#txtcanjeante_direccion").val(),
          numint : $("#txtcanjeante_numint").val(),
          numext : $("#txtcanjeante_numext").val(),
          cp : $("#txtcanjeante_cp").val(),
          colonia : $("#txtcanjeante_colonia").val(),
          ciudad : $("#txtcanjeante_ciudad").val(),
          estado : $("#txtcanjeante_estado").val(),
          sexo : $("#txtcanjeante_sexo").val(),
          telefono : $("#txtcanjeante_telefono").val(),
          fnacimiento : $("#txtcanjeante_fnacimiento").val(),
          nombre1 : $("#txtcanjeante_nombre1").val(),
          nombre2 : $("#txtcanjeante_nombre2").val(),
          apaterno : $("#txtcanjeante_apaterno").val(),
          amaterno : $("#txtcanjeante_amaterno").val(),
          rfc : $("#txtcanjeante_rfc").val(),
          curp : $("#txtcanjeante_curp").val(),
          settlement: $("#txtcanjeante_settlement").val()
        },
        beforeSend: function() {
            $.blockUI({ message: '<h2>Actualizando Datos..</h2>',timeout: 30000,baseZ: 9000 });
        },
        success:function(data) {
          try {
              var res =  data.response;
              if(typeof res.ErrorMessage === 'undefined'){
                  $("#btn_actualiza_save").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar');
                  mensaje('ok','Datos actualizados correctamente');
                  reload_canjeante();
                  $('#myModal-canjeante-edit').modal("hide");
              }else{
                  $(document).ajaxStop($.unblockUI);
                  $("#btn_actualiza_save").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar');
                  mensaje('error','Ocurrio un error en enviar información <br><b>'+res.ErrorMessage.msn+"</b>");
              }
          }catch{
            $(document).ajaxStop($.unblockUI);
            $("#btn_actualiza_save").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar');
            mensaje('error','Ocurrio un error en enviar información, intente de nuevo por favor.');
          }
        },
        error: function(){
          $(document).ajaxStop($.unblockUI);
          $("#btn_actualiza_save").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar');
          mensaje('error', 'Ocurrio un error en enviar información, intente de nuevo por favor.');
        },
        complete: function() {
            $(document).ajaxStop($.unblockUI);
       }
    });

});

function reload_canjeante(){
  $("#canjeante_direccion").html(  $("#txtcanjeante_direccion").val() );
  $("#canjeante_numint").html( $("#txtcanjeante_numint").val() );
  $("#canjeante_numext").html( $("#txtcanjeante_numext").val() );
  $("#canjeante_cp").html( $("#txtcanjeante_cp").val() );
  $("#canjeante_colonia").html( $("#txtcanjeante_colonia").val() );
  $("#canjeante_ciudad").html( $("#txtcanjeante_ciudad").val() );
  $("#canjeante_estado").html( $("#txtcanjeante_estado").val() );
  $("#canjeante_sexo").html( $("#txtcanjeante_sexo").val() );
  $("#canjeante_telefono").html( $("#txtcanjeante_telefono").val() );
  $("#canjeante_fnacimiento").html( $("#txtcanjeante_fnacimiento").val() );
  $("#canjeante_saldo_disponible").html( $("#txtcanjeante_saldo_disponible").val() );
  $("#canjeante_nombre1").html( $("#txtcanjeante_nombre1").val() );
  $("#canjeante_nombre2").html( $("#txtcanjeante_nombre2").val() );
  $("#canjeante_apaterno").html( $("#txtcanjeante_apaterno").val() );
  $("#canjeante_amaterno").html( $("#txtcanjeante_amaterno").val() );
  $("#canjeante_rfc").html( $("#txtcanjeante_rfc").val() );
  $("#canjeante_curp").html( $("#txtcanjeante_curp").val() );
}

function cargatabla(obj){
  $('#tabla_canjeantes tbody').html('');
  var trHTML = '';
   $.each(obj, function (i, item) {
     n1=(item.name == null)?'':item.name+ ' ';
     n2=(item.middleName == null)?'':item.middleName+ ' ';
     a1=(item.lastName == null)?'':item.lastName+ ' ';
     a2=(item.secondLastName == null)?'':item.secondLastName+' ';
     var nstatus = (item.status == 1)?'Habilitado':(item.status == 2)?'Deshabilitado':'Bloqueado';
     var saldo = (item.customer_available > 0)?item.customer_available:0;
     var sexo = (item.gender == 1)?'Hombre':'Mujer';
     nc=n1+n2+a1+a2;
       trHTML += '<tr class="' + nstatus + '" data-folio="' + item.id + '" '+
       'data-direccion="'+ item.address.street +'" '+
       'data-num_int="'+ item.address.house_number +'" '+
       'data-num_ext="'+ item.address.apartment_number +'" '+
       'data-cp="'+ item.address.zipcode +'" '+
       'data-colonia="'+ item.address.neighborhood +'" '+
	   'data-settlement="'+ item.address.settlement +'" '+
       'data-ciudad="'+ item.address.city +'" '+
       'data-estado="'+ item.address.state +'" '+
       'data-sexo="'+ sexo +'" '+
       'data-nsexo="'+ item.gender +'" '+
       'data-telefono="'+ item.phones[0].number +'" '+
       'data-nacimiento="'+ item.birthdate +'" '+
       'data-saldo="'+ saldo.toFixed(2) +'" '+
       'data-status="'+ item.status +'" '+
       'data-statusstring="'+ nstatus +'" '+
       'data-nombre1="'+ item.name +'" '+
       'data-nombre2="'+ item.middleName +'" '+
       'data-apaterno="'+ item.lastName +'" '+
       'data-amaterno="'+ item.secondLastName +'" '+
       'data-rfc="'+ item.rfc +'" '+
       'data-curp="'+ item.curp +'" '+
       'data-nombre="'+ nc +'"><td>' + item.id + '</td><td>' + nc + '</td><td>' + item.address.city + '</td><td>' + item.address.state + '</td></tr>';
   });
   $('#tabla_canjeantes').append(trHTML);
}

$("#tabla_canjeantes tbody").on("click", "tr", function(e){
  var dato = $(this);
  if(dato[0].dataset.status == 1){
    getdetalle(dato);
    $('#myModal-canjeante-search').modal("hide");
    $('#btn_set_venta').removeClass('hide');
  }else{
    mensaje('error', 'Canjeante no habilitado!');
  }
});

function getdetalle(campo){
  $('#oculta_detallado_canjeante').removeClass('hide');
  $('#mensaje_detalle_canjeante').removeClass('show').addClass('hide');
  nombre_canjeante = campo.data("nombre");
  telefono_canjeante = campo.data("telefono");
  rfc_canjeante = campo.data("rfc");
  sexo_canjeante = (campo.data("sexo") == 1)?'Masculino':'Femenino';
  $("#txtcanjeante_vale").val(campo.data("folio"));
  $("#canjeante_nombre").html(campo.data("nombre"));
  $("#canjeante_direccion").html(campo.data("direccion"));
  $("#canjeante_numint").html(campo.data("num_int"));
  $("#canjeante_numext").html(campo.data("num_ext"));
  $("#canjeante_cp").html(campo.data("cp"));
  $("#canjeante_colonia").html(campo.data("colonia"));
  $("#canjeante_ciudad").html(campo.data("ciudad"));
  $("#canjeante_estado").html(campo.data("estado"));
  $("#canjeante_sexo").html(campo.data("sexo"));
  $("#canjeante_telefono").html(campo.data("telefono"));
  $("#canjeante_fnacimiento").html(campo.data("nacimiento"));
  $("#canjeante_saldo_disponible").html(campo.data("saldo"));
  $("#mensaje_canjeante_nombre").html(campo.data("status")+ ' - '+campo.data("statusstring"));
  $("#canjeante_nombre1").html(campo.data("nombre1"));
  $("#canjeante_nombre2").html(campo.data("nombre2"));
  $("#canjeante_apaterno").html(campo.data("apaterno"));
  $("#canjeante_amaterno").html(campo.data("amaterno"));
  $("#canjeante_rfc").html(campo.data("rfc"));
  $("#canjeante_curp").html(campo.data("curp"));
  $('#btn_modal_edita_canjeante').removeAttr('disabled').removeAttr('readonly');
  habilitarCampos();
  getSelect2(campo);
}

$("#btn_limpiar_search").on("click",function(){
  mensaje("aviso4","¿Desea limpiar la busqueda?");
});

$("#btn_busca_canjeante").on("click", function(){
  var xfolio = $("#txtcanjeante_nombre").val();
           if(xfolio) {
             limpiarCanjeante_busqueda();
             getCanjeante(xfolio);
           }else{
             mensaje('alerta',"Favor de agregar folio o nombre de canjeante");
           }
});

$("#btn_actualiza_cancelar").on("click", function(){
    $('#myModal-canjeante-edit').modal('hide');
});

$('#txtcanjeante_colonia').on("change", function(){
  $("#txtcanjeante_ciudad").val($(this).find(':selected').data("ciudad"));
  $("#txtcanjeante_estado").val($(this).find(':selected').data("estado"));
  $("#txtcanjeante_settlement").val($(this).find(':selected').data("settlement"));
});

function buscaCP(zipcode,campo){
  $.ajax({
      url: "<?php echo base_url('dpvale/getColonias'); ?>",
      type: "GET",
      dataType: "json",
      cache: true,
      data:{zipcode : zipcode,token: "<?php echo $hash; ?>"},
      beforeSend: function() {
          $.blockUI({ message: '<h2>Buscando Colonias..</h2>',timeout: 30000,baseZ: 9000 });
      },
      success:function(data) {
          var $canje = data.response;

          $('#'+campo).empty();
          if(campo == 'registro_colonia'){
            $("#registro_ciudad, #registro_estado").val('');
          }else{
            $("#txtcanjeante_ciudad, #txtcanjeante_estado").val('');
          }
          if($canje.status > 0){
            $.each($canje.data, function(key, value) {
               $('#'+campo).append('<option value="'+ value.neighborhood +'" data-ciudad="'+value.city+'" data-estado="'+value.state+'" data-settlement="'+value.settlement+'">'+value.neighborhood+'</option>');
            });
            if(campo == 'registro_colonia'){
              $("#registro_ciudad").val($("#registro_colonia").find(':selected').data("ciudad"));
              $('#registro_estado').val($("#registro_colonia").find(':selected').data("estado"));
			  $('#registro_settlement').val($("#registro_colonia").find(':selected').data("settlement"));
            }else{
              $("#txtcanjeante_ciudad").val($("#txtcanjeante_colonia").find(':selected').data("ciudad"));
              $("#txtcanjeante_estado").val($("#txtcanjeante_colonia").find(':selected').data("estado"));
			  $("#txtcanjeante_settlement").val($("#txtcanjeante_colonia").find(':selected').data("settlement"));
            }
          }

      },
      error: function(){
        $(document).ajaxStop($.unblockUI);
        mensaje('error', 'Ocurrio un error en enviar información, intente de nuevo por favor.');
      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });
}

$("#txtcanjeante_cp").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
       buscaCP($(this).val(),'txtcanjeante_colonia');
  }
});

$("#registro_cp").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
       buscaCP($(this).val(),'registro_colonia');
  }
});

$("#txtcanjeante_nombre").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
       getCanjeante($(this).val());
  }
});

$("#folio_vale").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
       $("#btn_busca_folio").click();
  }
});

$('#registro_colonia').on("change", function(){
  $("#registro_ciudad").val($(this).find(':selected').data("ciudad"));
  $("#registro_estado").val($(this).find(':selected').data("estado"));
  $("#registro_settlement").val($(this).find(':selected').data("settlement"));
});

$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
  if (event.keyCode == 13) {
    event.preventDefault();
    var fields = $("#formulario_registro").find("input, textarea, select");
    var index = fields.index(this) + 1;
    var field;
    fields.eq(
      fields.length <= index
      ? 0
      : index
    ).focus();
  }
});

$("#registro_guardar").on("click", function(){
   if(validaDatos){
    $(this).attr('disabled','disabled').html('Guardando Datos...');
    $.ajax({
        url: "<?php echo base_url('dpvale/saveCustomer'); ?>",
        type: "GET",
        dataType: "json",
        data:{
          idcustomer : '',
          direccion : $("#registro_direccion").val(),
          numint : $("#registro_numint").val(),
          numext : $("#registro_numext").val(),
          cp : $("#registro_cp").val(),
          colonia : $("#registro_colonia").val(),
          ciudad : $("#registro_ciudad").val(),
          estado : $("#registro_estado").val(),
          sexo : $("#registro_sexo").val(),
          telefono : $("#registro_telefono").val(),
          fnacimiento : $("#registro_fnacimiento").val(),
          nombre1 : $("#registro_nombre1").val(),
          nombre2 : $("#registro_nombre2").val(),
          apaterno : $("#registro_apaterno").val(),
          amaterno : $("#registro_amaterno").val(),
          rfc : $("#registro_rfc").val(),
          curp : $("#registro_curp").val(),
		  settlement : $("#registro_settlement").val(),
          token: "<?php echo $hash; ?>"
        },
        beforeSend: function() {
            $.blockUI({ message: '<h2>Guardando Datos..</h2>',timeout: 30000,baseZ: 9000 });
        },
        success:function(data) {
        //  try {
              var res =  data.response;
              if(typeof res.ErrorMessage === 'undefined'){
                $("#registro_guardar").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar Nuevo');
                mensaje('ok','Datos actualizados correctamente');
                $("#myModal, #myModal-canjeante-search").modal('toggle');
                registro_canjeante(res.customer.id_customer);
                limpiaModalRegistro();
              }else{
                $err = res.ErrorMessage;
                $("#registro_guardar").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar Nuevo');
                mensaje('error','Ocurrio un error en enviar información, intente de nuevo por favor. code: 002<br>'+$err.msn);
              }
      /*    }catch{
            $(document).ajaxStop($.unblockUI);
            $("#registro_guardar").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar Nuevo');
            mensaje('error','Ocurrio un error en enviar información, intente de nuevo por favor. code: 003');
          }*/
        },
        error: function(){
          $(document).ajaxStop($.unblockUI);
          $("#registro_guardar").removeAttr('disabled').html('<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>Guardar Nuevo');
          mensaje('error', 'Ocurrio un error en enviar información, intente de nuevo por favor. code: 004');
        },
        complete: function() {
            $(document).ajaxStop($.unblockUI);
       }
    });
  }
});

$("#monto_vale_manual").on("blur",function(){
  valida_montos();
});

$("#monto_vale_manual").keypress(function( event ) {
  if ( event.which == 13 ) {
     event.preventDefault();
      var r = valida_montos();
      if(r){
        $("#myModal-canjeante-search").modal('show');
      }
  }
});

$("#btn_set_venta").on('click', function(){
  if($("#txtcanjeante_direccion").val() == '' ||
     $("#txtcanjeante_numext").val() == '' ||
     $("#txtcanjeante_cp").val() == '' ||
     $("#txtcanjeante_colonia").val() == '' ||
     $("#txtcanjeante_ciudad").val() == '' ||
     $("#txtcanjeante_estado").val() == '' ||
     $("#txtcanjeante_sexo").val() == ''
    ){
      mensaje('error', 'Favor de llenar todos los datos del canjeante');
      $('#myModal-canjeante-edit').modal("show");
  }else{
      var $montos = valida_montos();
      var $idcanjeante = $('#txtcanjeante_nombre').val();
      if( ( $montos == true && $idcanjeante != '' ) || ($montos == true && idCustomer > 0) ){
        $(this).attr('disabled','disabled').html('Buscando Promociones...');
        $.ajax({
            url: "<?php echo base_url('dpvale/getpromociones'); ?>",
            data:{token: "<?php echo $hash; ?>",tienda:"<?=$tienda?>",monto:"<?=$monto?>",tipo:tiene_promo},
            type: "GET",
            dataType: "json",
            beforeSend: function() {
                $.blockUI({ message: '<h2>Buscando Promociones..</h2>',timeout: 30000,baseZ: 9000 });
            },
            success:function(data) {
              try {
                  cargapromos(data, es_revale);

              }catch{
                $(document).ajaxStop($.unblockUI);
                $("#btn_set_venta").removeAttr('disabled').html('<span aria-hidden="true"></span>REALIZAR VENTA');
                mensaje('error','Ocurrio un error en enviar información, intente de nuevo por favor. code: 005');
              }
            },
            error: function(){
              $(document).ajaxStop($.unblockUI);
              $("#btn_set_venta").removeAttr('disabled').html('<span aria-hidden="true"></span>REALIZAR VENTA');
              mensaje('error', 'Ocurrio un error en enviar información, intente de nuevo por favor. code: 006');
            },
            complete: function() {
                $("#btn_set_venta").removeAttr('disabled').html('<span aria-hidden="true"></span>REALIZAR VENTA');
                $(document).ajaxStop($.unblockUI);
           }
        });
      }
    }
});

function cargapromos(obj, revale){
 $('#tabla_promociones tbody').html('');
  var trHTML = '';
  var promo = 'NO';
  if(revale == true){
    trHTML += '<tr class="celda_promo" data-folio="00" data-quincena="00" data-fecha="00" data-promo="REVALE" '+
     '><td colspan="4">Revale ingresado, las quincenas serán las mismas que el vale original</td></tr>';
  }else{
     $.each(obj, function (i, item) {
       if(item.promo == 0){promo = 'NO'}else{promo = 'SI'}
       pagoquincenal = Number(<?=$monto?>) / Number(item.term) ;
         trHTML += '<tr class="celda_promo" data-folio="' + item.id_offer + '" '+
         'data-quincena="'+ item.promo_date +'" '+
		 'data-fecha_s2="'+ item.promo_date1 +'" '+
         'data-fecha="'+ item.term +'" '+
         'data-promo="'+ promo +'" '+
          '><td>' + item.term + '</td><td><b>$' + pagoquincenal.toFixed(2) + '</b></td><td>' + item.promo_date + '</td><td>' + promo + '</td></tr>';
     });
   }
   $('#tabla_promociones').append(trHTML);

   $("#myModal-promociones").modal('show');
}
function valida_montos(){
  /*if(tipo_vale == 3 || tipo_vale == null || tipo_vale == ''){*/
  if(!monto_del_vale > 0 ){
    if($("#monto_vale_manual").val() > 0){
        $monto_a_pagar = parseInt(<?=$monto?>);
        $cantidad = parseInt($("#monto_vale_manual").val()) - $monto_a_pagar;
        if($cantidad < 0){
            mensaje('error2','No tiene saldo suficiente, <br> El monto del vale es menor al monto a pagar! <br> <small>Error #0086</small>');
            return false;
        }
        if(parseInt($("#monto_vale_manual").val()) > tope){
            mensaje('error2','No Puede Sobre pasar el Tope, <br> El monto del vale es no puede sobre pasar el tope de venta! <br> <small>Error #0089</small>');
            return false;
        }
    }else{
      $monto_a_pagar = parseInt(<?=$monto?>);
      $cantidad = parseInt(monto_del_vale) - $monto_a_pagar;
      if($cantidad < 0){
        mensaje('error2','No tiene saldo suficiente, <br> El monto del vale es menor al monto a pagar! <br> <small>Error #0087</small>');
        return false;
      }
    }
  }else{
    if( amount > monto_del_vale ){
      mensaje('error2','No tiene saldo suficiente, <br> El monto del vale es menor al monto a pagar! <br> <small>Error #0088</small>');
      return false;
    }
  }
  return true;
}
function registro_canjeante($idconsumer){
  if($idconsumer != '')
  {
    $("#txtcanjeante_nombre").val($idconsumer);
    getCanjeante($idconsumer);
  }else{
    $n1=$("#registro_nombre1").val();
    $n2=$("#registro_nombre2").val();
    $a1=$("#registro_apaterno").val();
    $a2=$("#registro_amaterno").val();
    if( $n2.length > 0 ){$n2 = '_' + $n2;}
    if( $a2.length > 0 ){$a2 = '_' + $a2;}

    $("#txtcanjeante_nombre").val($n1.trim()+$n2.trim()+'_'+$a1.trim()+$a2.trim());
    getCanjeante($n1.trim()+$n2.trim()+'_'+$a1.trim()+$a2.trim());
  }

}
function limpiaModalRegistro(){
  $("#registro_nombre1").val('');
  $("#registro_nombre2").val('');
  $("#registro_apaterno").val('');
  $("#registro_amaterno").val('');
  $("#registro_direccion").val('');
  $("#registro_numint").val('');
  $("#registro_numext").val('');
  $("#registro_cp").val('');
  $("#registro_colonia").empty();
  $("#registro_ciudad").val('');
  $("#registro_estado").val('');
  $("#registro_sexo").val(0);
  $("#registro_telefono").val('');
  $("#registro_fnacimiento").val('');
  $("#registro_rfc").val('');
  $("#registro_curp").val('');
  $("#registro_settlement").val('');
}
function habilitarCampos(){
  $("#txtcanjeante_direccion").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_numint").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_numext").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_cp").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_colonia").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_sexo").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_telefono").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_fnacimiento").removeAttr('disabled').removeAttr('readonly');
  //$('#txtcanjeante_vale').attr('disabled','disabled').attr('readonly',true);
  $("#canjeante_nombres").removeClass('hidden');
  $("#canjeante_apellidos").removeClass('hidden');
  $("#canjeante_rfc").removeClass('hidden');
  $("#canjeante_curp").removeClass('hidden');
  $("#txtcanjeante_rfc").removeAttr('disabled').removeAttr('readonly');
  $("#txtcanjeante_curp").removeAttr('disabled').removeAttr('readonly');
}
function dehabilitarCampos(){
  $("#txtcanjeante_direccion").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_numint").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_numext").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_cp").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_colonia").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_ciudad").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_estado").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_sexo").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_telefono").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_fnacimiento").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_nombre1").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_nombre2").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_apaterno").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_amaterno").attr('disabled','disabled').attr('readonly',true);
  $("#canjeante_nombres").addClass('hidden');
  $("#canjeante_apellidos").addClass('hidden');
  $("#canjeante_rfc").addClass('hidden');
  $("#canjeante_curp").addClass('hidden');
  $("#txtcanjeante_rfc").attr('disabled','disabled').attr('readonly',true);
  $("#txtcanjeante_curp").attr('disabled','disabled').attr('readonly',true);
  if(!idCustomer > 0 ){
    $('#txtcanjeante_nombre').removeAttr('disabled').removeAttr('readonly');
    $('#btn_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
  //  $('#txtcanjeante_vale').removeAttr('disabled').removeAttr('readonly');
  }
}
function limpiaDistribuidor(){
  $("#txtdistribuidor").html('');
  $("#txtnombredist").val('');
  $("#txtdiscalzado").val('');
  $("#txtdisfinanciero").val('');
  $("#firma").attr('src','');
  $("#lienzo").addClass('hidden');
  $("#txtfolio").val('');
  $("#txtcongesistema").val('');
  $("#txtcongeoficina").val('');
  $('#monto_manual').removeClass('fix-input-margen').addClass('hide');
  $('#montovale').removeClass('hide').addClass('show');
  $('#monto_credito').html('$ 0.00');
  $('#monto_vale_manual').val('');
}
function limpiarCanjeante(){
  $("#txtcanjeante_direccion").val('').html('');
  $("#txtcanjeante_numint").val('').html('');
  $("#txtcanjeante_numext").val('').html('');
  $("#txtcanjeante_cp").val('').html('');
  $("#txtcanjeante_colonia").empty().html('');
  $("#txtcanjeante_ciudad").val('').html('');
  $("#txtcanjeante_estado").val('').html('');
  $("#txtcanjeante_sexo").val(0);
  $("#txtcanjeante_telefono").val('').html('');
  $("#txtcanjeante_fnacimiento").val('').html('');
  $("#txtcanjeante_saldo_disponible").val('').html('');
  $("#mensaje_txtcanjeante_nombre").html('').html('');
  $("#txtcanjeante_nombre1").val('').html('');
  $("#txtcanjeante_nombre2").val('').html('');
  $("#txtcanjeante_apaterno").val('').html('');
  $("#txtcanjeante_amaterno").val('').html('');
  $("#txtcanjeante_rfc").val('').html('');
  $("#txtcanjeante_curp").val('').html('');
  /*DETALLE*/
  $("#canjeante_direccion").html('');
  $("#canjeante_numint").html('');
  $("#canjeante_numext").html('');
  $("#canjeante_cp").html('');
  $("#canjeante_colonia").html('');
  $("#canjeante_ciudad").html('');
  $("#canjeante_estado").html('');
  $("#canjeante_sexo").val(0);
  $("#canjeante_telefono").html('');
  $("#canjeante_fnacimiento").html('');
  $("#canjeante_saldo_disponible").html('');
  $("#canjeante_nombre1").html('');
  $("#canjeante_nombre2").html('');
  $("#canjeante_apaterno").html('');
  $("#canjeante_amaterno").html('');
  $("#canjeante_rfc").html('');
  $("#canjeante_curp").html('');

  $('#oculta_detallado_canjeante').removeClass('show').addClass('hide');
  $('#mensaje_detalle_canjeante').removeClass('hide').addClass('show');
  $('#btn_modal_busca_canjeante').attr('disabled','disabled').attr('readonly',true);
  $('#btn_modal_edita_canjeante').attr('disabled','disabled').attr('readonly',true);
}
function limpiarCanjeante_busqueda(){
  $('#txtcanjeante_vale').empty();
  limpiarCanjeante();
}
function limpia_busqueda(){
  $('#tabla_canjeantes tbody').html('');
  $('#txtcanjeante_nombre').removeAttr('disabled').removeAttr('readonly');
  $('#btn_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
  limpiarCanjeante();
  $('#btn_modal_busca_canjeante').removeAttr('disabled').removeAttr('readonly');
}
function getSelect2(campo){
  $("#txtcanjeante_direccion").val(campo.data("direccion"));
  $("#txtcanjeante_numint").val(campo.data("num_int"));
  $("#txtcanjeante_numext").val(campo.data("num_ext"));
  $("#txtcanjeante_cp").val(campo.data("cp"));
  $("#txtcanjeante_colonia").empty().append("<option value='"+campo.data("colonia")+"'>"+campo.data("colonia")+"</option>");
  $("#txtcanjeante_settlement").val(campo.data("settlement"));
  $("#txtcanjeante_ciudad").val(campo.data("ciudad"));
  $("#txtcanjeante_estado").val(campo.data("estado"));
  $("#txtcanjeante_sexo").val(campo.data("nsexo"));
  $("#txtcanjeante_telefono").val(campo.data("telefono"));
  $("#txtcanjeante_fnacimiento").val(campo.data("nacimiento"));
  $("#txtcanjeante_saldo_disponible").val(campo.data("saldo")).formatCurrency();
  $("#mensaje_txtcanjeante_nombre").html('<small>'+campo.data("status")+ ' - '+campo.data("statusstring")+'</small>');
  $("#txtcanjeante_nombre1").val(campo.data("nombre1"));
  $("#txtcanjeante_nombre2").val(campo.data("nombre2"));
  $("#txtcanjeante_apaterno").val(campo.data("apaterno"));
  $("#txtcanjeante_amaterno").val(campo.data("amaterno"));
  $("#txtcanjeante_rfc").val(campo.data("rfc"));
  $("#txtcanjeante_curp").val(campo.data("curp"));
}
function leyendas(english){
  var english = english*1;
  switch (english) {
    case 0:
      return "Vale no existe";
      break;
    case 1:
      return "Vale con status invalido";
      break;
    case 2:
      return "Vale con status invalido";
      break;
    case 3:
      return "Vale activo";
      break;
    case 4:
      return "Vale Expirado";
      break;
    case 5:
      return "Vale cancelado";
      break;
    case 6:
      return "El vale ya ha sido utilizado";
      break;
    case 7:
      return "Vale con status invalido";
      break;
    default:
      return "Estatus no encontrado";
  }
}
function mensaje(tipo, mensaje,callback = ''){
  switch(tipo) {
    case 'error':
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
      case 'error2':
        $.confirm({
          icon: 'fa fa-warning',
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
          title: 'Alerta',
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
      case 'alerta2':
          $.confirm({
            title: 'Alerta',
            content: mensaje,
            type: 'orange',
            typeAnimated: true,
            columnClass: 'medium',
            buttons: {
                tryAgain: {
                    text: 'Nueva Busqueda',
                    btnClass: 'btn-green',
                    action: function(){
                        bloqueo();
                    }
                },
                 boton2:{
                   text: 'Cancelar',
                   btnClass: 'btn-red',
                   action: function(){
                     $("#txtcanjeante_nombre").select().focus();
                   },
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
    case 'aviso2':
        $.confirm({
          icon: 'fa fa-warning',
          title: 'Aviso',
          content: mensaje,
          type: 'blue',
          typeAnimated: true,
          columnClass: 'medium',
          buttons: {
              tryAgain: {
                  text: 'Alta Canjeante',
                  btnClass: 'btn-green',
                  action: function(){
                    $("#myModal").modal({
                      keyboard: false,
                      show: true,
                      backdrop:'static'
                    });
                    limpiarCanjeante();
                    limpiarCanjeante_busqueda();
                    limpia_busqueda();
                  },
               },
               boton2:{
                 text: 'Nueva Consulta',
                 btnClass: 'btn-blue',
                 action: function(){
                   $("#txtcanjeante_nombre").select().focus();
                 },
                }
              },
              scrollToPreviousElement:false

          });
          break;
    case 'aviso3':
      $.confirm({
        icon: 'fa fa-warning',
        title: 'Aviso',
        content: mensaje,
        type: 'blue',
        typeAnimated: true,
        columnClass: 'medium',
        buttons: {
            tryAgain: {
                text: 'Actualizar registro',
                btnClass: 'btn-green',
                action: function(){
                  updateAsignacion();
                },
             },
             boton2:{
               text: 'Cancelar',
               btnClass: 'btn-danger',
               action: function(){
               },
              }
            },
            scrollToPreviousElement:false

        });
      break;
    case 'aviso4':
        $.confirm({
          icon: 'fa fa-warning',
          title: 'Aviso',
          content: mensaje,
          type: 'blue',
          typeAnimated: true,
          columnClass: 'medium',
          buttons: {
              tryAgain: {
                  text: 'Aceptar',
                  btnClass: 'btn-green',
                  action: function(){
                    limpia_busqueda();
                  },
               },
               boton2:{
                 text: 'Cancelar',
                 btnClass: 'btn-danger',
                 action: function(){
                 },
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
                btnClass: 'btn-blue',
                action: function(){
                }
            }
        }
      });
      break;
    case 'ok2':
        $.confirm({
          icon: 'fa fa-check',
          title: 'Exito',
          content: mensaje,
          type: 'green',
          typeAnimated: true,
          columnClass: 'medium',
          buttons: {
              tryAgain: {
                  text: 'Todo Bien',
                  btnClass: 'btn-green',
                  action: function(){
                    limpiaDistribuidor();
                    limpiaModalRegistro();
                    limpiarCanjeante();
                    limpiarCanjeante_busqueda();
                    $("#folio_vale").removeAttr('disabled').removeAttr('readonly');
                    $("#btn_busca_folio").html('<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Buscar');
                    block = false;
                    $("#folio_vale,#txtcanjeante_nombre").val('');
                    $('#txtcanjeante_nombre,#btn_busca_canjeante,#txtcanjeante_vale').attr('disabled','disabled').attr('readonly',true);
                  },
               },
               boton2:{
                 text: 'Modificar Asignación',
                 btnClass: 'btn-red',
                 action: function(){
                   $("#txtcanjeante_nombre").select().focus();
                 },
                }
              },
              scrollToPreviousElement:false

          });
        break;
    case 'ok3':
        $.confirm({
          icon: 'fa fa-check',
          title: 'Exito',
          content: mensaje,
          type: 'green',
          typeAnimated: true,
          columnClass: 'medium',
          buttons: {
              tryAgain: {
                  text: 'SI QUIERO REVALE',
                  btnClass: 'btn-green',
                  action: function(){
                      getrevale(callback);
                  },
               },
               boton2:{
                 text: 'NO QUIERO REVALE',
                 btnClass: 'btn-red',
                 action: function(){
                      impresion(0);
                 },
                }
              },
              scrollToPreviousElement:false

          });
        break;
  }
}
$('#myModal-canjeante-search').on('shown.bs.modal', function (e) {
  $("#txtcanjeante_nombre").focus();
});
$("#tabla_promociones tbody").on("click", "tr", function(e){
        $(this).addClass('active').siblings().removeClass('active');
        folio_promo = [$(this).data('folio'), $(this).data('quincena'), $(this).data('fecha'), $(this).data('promo'), $(this).data('fecha_s2')];
});
$("#btn_acepta_promo").on("click",function(){
    if(typeof folio_promo == 'object'){
      enviarventa(folio_promo);
    }else{
      mensaje('alerta','Favor de seleccionar una opción');
    }
});
function getFinalMonto(){
  var valor = 0 ;
  if(!monto_del_vale > 0 ){
    valor = $("#monto_vale_manual").val();
  }else{
    valor = monto_del_vale;
  }
  return valor;
}
function enviarventa(promo){
  idCustomer = $("#txtcanjeante_vale").val();
  montofinal = getFinalMonto();
  promociones = promo;
      $.ajax({
          url: "<?php echo base_url('dpvale/setventa'); ?>",
          type: "GET",
          dataType: "json",
          data:{
            token          : "<?php echo $hash; ?>",
            tienda         : "<?=$tienda?>",
            customer       : idCustomer,
            distributor    : distributor,
            idCoupon       : folio,
            couponAmount   : montofinal,
            purchaseAmount : amount,
            period         : promo[2],
            firstDueDate   : promo[1],
            idOffer        : promo[0],
            promo          : promo[3],
			promo_s2       : promo[4],
            pedido         : "<?=$pedido?>",
            plataforma     : "<?=$plataforma?>"
          },
          beforeSend: function() {
               $.blockUI({ message: '<h2>Guardando Venta..</h2>',timeout: 30000,baseZ: 9000 });
          },
          success:function(data) {
           try{
               var xml = data.response;
               if(typeof xml.ErrorMessage === 'undefined'){
                 VALEOK = xml;
                 TICKETSEGURO = false;
                 TICKETREVALE = false;
                 CA = xml.purchasesGenerated[0];
              //  console.log(xml);
                 $("#myModal-promociones").modal('hide');
              //   console.log(xml.valePadre);
                 if(typeof xml.valePadre === "object"){
                   promociones = ['00', xml.valePadre.fechapago, xml.valePadre.quincenas];
                 }

                 if(xml.insurancePeriods != null){

                    seguro_1er_monto= xml.insurancePeriods[0].amortizations[0].amount;
                    seguro_desde    = xml.insurancePeriods[0].amortizations[0].date;

                    TICKETSEGURO = true;
                    var highlights = xml.insurancePeriods[0].amortizations;
                    var total = 0;
                    var fecha = '';
                    seguro_quincenas = 0;

                    highlights.forEach( function(record) {
                          if(record.amount > 0 && seguro_quincenas == 0){
                            seguro_quincenas = record.amount;
                          }
                          total += parseFloat(record.amount);
                          fecha =  record.date;
                    });

                    seguro_total    = total;
                    seguro_hasta    = fecha;

					cargaParentescos();
                    $("#myModal-beneficiario").modal('show');

                 }else{
                     TICKETSEGURO = false;
                     if(xml.remainder > 0 ){
                       mensaje('ok3','Venta Generada con exito, ¿Desea Impresión de Re-Vale?',VALEOK);
                     }else{
                        mensaje('ok','Venta Generada con exito');
                        impresion();
                     }
                 }
               }else{
                 //mensaje('error','Favor de intentarlo de nuevo. code: 008 <br>'+xml.ErrorMessage.msn);
                 var $texto = 'Error en Generar la Venta';
                 var $error = 'Favor de contactar a Soporte Tecnico para revisar.';
                 mensaje('error','<h1>'+$texto+'</h1><br><div class="mensaje_tecnico"><small><b>Descripción Técnica del Error</b><br>'+$error+'<br>'+xml.ErrorMessage.msn+'</small></div>');
               }
           }catch(err) {
             $(document).ajaxStop($.unblockUI);
             mensaje('error','Favor de intentarlo de nuevo. code: 007 <br>'+err.message);
             $(document).ajaxStop($.unblockUI);
           }
          },
          complete: function() {
              $(document).ajaxStop($.unblockUI);
         }
      });
}

function cargaParentescos(){
  $.ajax({
      url: "<?php echo base_url('dpvale/parentescos'); ?>",
      type: "GET",
      dataType: "json",
      timeout: 20000,
      beforeSend: function() {
          $('#beneficiario_parentesco').empty('').append('<option>Cargando...</option>');
      },
      success:function(data) {
            $('#beneficiario_parentesco').empty('');
             var trHTML = '';
             $.each(data, function (i, item) {
                  trHTML += '<option value="'+item.id+'">'+item.value+'</option>';
              });
              $('#beneficiario_parentesco').append(trHTML);
     },
     error: function(e){
         if (e.statusText==='timeout'){
           console.log('Tiempo de espera agotado');
         }
         else{
           console.log(e.statusText);
         }
         manualParentescos();
    },
     complete: function() {
         $(document).ajaxStop($.unblockUI);
    }
  });
}
function manualParentescos(){
  console.log('Se carga select manualmente');
  var cadena = '[{"id":"2","value":"Padre"},{"id":"3","value":"Madre"},{"id":"4","value":"Hijo (a)"},{"id":"5","value":"Hermano (a)"},{"id":"6","value":"T\u00edo (a)"},{"id":"7","value":"Sobrino (a)"},{"id":"8","value":"Abuelo (a)"},{"id":"10","value":"Esposo (a)"},{"id":"15","value":"Concubino (a)"},{"id":"16","value":"Nieto (a)"},{"id":"17","value":"Amigo (a)"}]';
  var data = JSON.parse(cadena);
  $('#beneficiario_parentesco').empty('');
   var trHTML = '';
   $.each(data, function (i, item) {
        trHTML += '<option value="'+item.id+'">'+item.value+'</option>';
    });
    $('#beneficiario_parentesco').append(trHTML);
}
function impresion(tipo){
  plataforma = "<?= ($plataforma=='')?'pruebas':$plataforma;?>";
  print(plataforma);
}

function getrevale(datos){
  $.ajax({
      url: "<?php echo base_url('dpvale/setRevale'); ?>",
      type: "GET",
      dataType: "json",
      data:{
        token          : "<?php echo $hash; ?>",
        idCoupon       : datos.coupon,
        idCustomer     : idCustomer,
        amount         : datos.remainder
      },
      beforeSend: function() {
           $.blockUI({ message: '<h2>Generando Revale..</h2>',timeout: 30000,baseZ: 9000 });
      },
      success:function(data) {
       try{
           var xml = data.response;
           if(typeof xml.ErrorMessage === 'undefined'){
                mensaje('ok','Revale Generado con exito');
                TICKETREVALE = true;
                REVALEOK = xml;
                console.log(xml);
                impresion();

           }else{
             mensaje('error','Favor de intentarlo de nuevo. code: 009 <br>'+xml.ErrorMessage.msn);
             mensaje('ok3','¿Desea Impresión de Re-Vale?',VALEOK);
           }
       }catch(err) {
         $(document).ajaxStop($.unblockUI);
         mensaje('error','Favor de intentarlo de nuevo. code: 010 <br>'+err.message);
         mensaje('ok3','¿Desea Impresión de Re-Vale?',VALEOK);
       }
      },
      complete: function() {
          $(document).ajaxStop($.unblockUI);
     }
  });
}


$("#btn_acepta_beneficiario").on('keypress click', function(e){
  if (e.which === 13 || e.type === 'click') {
    var b_nombre      = $("#beneficiario_nombre").val();
    var b_paterno     = $("#beneficiario_paterno").val();
    var b_materno     = $("#beneficiario_materno").val();
    var b_parentesco  = $("#beneficiario_parentesco").val();
    var b_porcentaje  = $("#beneficiario_porcentaje").val();
    var b_parentesco_texto  = $("#beneficiario_parentesco option:selected").text();

    if(! b_nombre.length > 0){mensaje('error','Favor de poner un nombre de beneficiario','$("#beneficiario_nombre").focus()')
    }else if(! b_paterno.length > 0){mensaje('error','Favor de poner un apellido paterno de beneficiario','$("#beneficiario_paterno").focus()')
    }else if(! b_materno.length > 0){mensaje('error','Favor de poner un apellido materno de beneficiario','$("#beneficiario_materno").focus()')
    }else if( b_parentesco == 0){mensaje('error','Favor de poner el tipo de parenteco','$("#beneficiario_parentesco").focus()')
    }else if(! b_porcentaje > 0){mensaje('error','Favor de poner el porcentaje para el beneficiario','$("#beneficiario_porcentaje").focus()')
    }else if(b_porcentaje > 100){mensaje('error','El porcentaje maximo para el beneficiario debe de ser de 100%','$("#beneficiario_porcentaje").val("100")')
  } else{
     try{
        var id_venta = VALEOK.insurancePeriods[0].id_purchase;
        if( id_venta > 0 ){
          guardar_beneficiario(b_nombre,b_paterno,b_materno,b_parentesco,id_venta, b_parentesco_texto, b_porcentaje);
        }else{
          mensaje('error','Falta la confirmación de la venta');
        }
    }catch(e){
      mensaje('error','Ocurrio un error en obtener datos del vale de venta');
    }
    }
  }
});

function guardar_beneficiario(nombre,paterno,materno,parentesco,idventa,parentesco_texto,porcentaje){
    $.ajax({
        url: "<?php echo base_url('dpvale/setBeneficiario'); ?>",
        type: "GET",
        dataType: "json",
        data:{
          token          : "<?php echo $hash; ?>",
          id_relationship : parentesco,
          id_purchase : idventa,
          name : nombre,
          last_name : paterno,
          second_last_name : materno
        },
        beforeSend: function() {
             $.blockUI({ message: '<h2>Guardando Beneficiario..</h2>',timeout: 30000,baseZ: 9000 });
        },
        success:function(data) {
         try{
             var xml = data.response;
             if(typeof xml.ErrorMessage === 'undefined'){
                  console.log(xml);
                  mensaje('ok','Beneficiario guardado con exito');
                  //TICKETSEGURO = true;
                  b_nombre     = nombre +' '+paterno + ' '+ materno;
                  b_parentesco = parentesco_texto;
                  b_porcentaje = porcentaje;
                  $("#myModal-beneficiario").modal('hide');
                  if(VALEOK.remainder > 0 ){
                    mensaje('ok3','¿Desea Impresión de Re-Vale?',VALEOK);
                  }else{
                     mensaje('ok','Venta Generada con exito');
                     impresion(2);
                  }

             }else{
               mensaje('error','Favor de intentarlo de nuevo. code: 011 <br>'+xml.ErrorMessage.msn);
             }
         }catch(err) {
           $(document).ajaxStop($.unblockUI);
           mensaje('error','Favor de intentarlo de nuevo. code: 012 <br>'+err.message);
         }
        },
        complete: function() {
            $(document).ajaxStop($.unblockUI);
       }
    });
}

function print(tickets){
  var tipo_respuesta = '';
  var importe_final = getFinalMonto();
  var variable = 'APTOS';
  $.confirm({
    content: function () {
          var self = this;
          return $.ajax({
              url: '<?=base_url('dpvale/tickets')?>',
              dataType: 'json',
              data:{
                token               : "<?php echo $hash; ?>",
                tienda              : "<?=(isset($tienda))?$tienda:0; ?>",
                caja                : "<?=(isset($caja))?$caja:0; ?>",
                tienda_nombre       : "<?=(isset($tienda_nombre))?$tienda_nombre:''; ?>",
                tienda_calle_numero : "<?=(isset($tienda_calle_numero)?$tienda_calle_numero:''); ?>",
                tienda_colonia      : "<?=(isset($tienda_colonia)?$tienda_colonia:''); ?>",
                tienda_cp           : "<?=(isset($tienda_cp)?$tienda_cp:''); ?>",
                tienda_telefono     : "<?=(isset($tienda_telefono)?$tienda_telefono:''); ?>",
                tienda_ciudad       : "<?=(isset($tienda_ciudad)?$tienda_ciudad:''); ?>",
                tienda_estado       : "<?=(isset($tienda_estado)?$tienda_estado:''); ?>",
                tienda_vendedor     : "<?=(isset($tienda_vendedor)?$tienda_vendedor:''); ?>",
                folio_vale          : folio,
                folio_canjeante     : idCustomer,
                folio_distribuidor  : distributor,
                distribuidor        : nombre_distributor,
                canjeante           : nombre_canjeante,
                quincenas           : promociones[2],
                fecha_pago          : promociones[1],
                tickets             : tickets,
                seguro              : TICKETSEGURO,
                revale              : TICKETREVALE,
                folio_revale        : (typeof REVALEOK.coupon != "undefined")?REVALEOK.coupon.id:'',
                fecha_exp           : (typeof REVALEOK.coupon != "undefined")?REVALEOK.coupon.expirationDate:'',
                name                : (typeof REVALEOK.coupon != "undefined")?REVALEOK.customer.name:'',
                middleName          : (typeof REVALEOK.coupon != "undefined")?REVALEOK.customer.middleName:'',
                lastName            : (typeof REVALEOK.coupon != "undefined")?REVALEOK.customer.lastName:'',
                secondLastName      : (typeof REVALEOK.coupon != "undefined")?REVALEOK.customer.secondLastName:'',
                telefono_canjeante  : telefono_canjeante,
                importepago         : importe_final,
                impoteOrig          : amount,
                monto               : (typeof REVALEOK.coupon != "undefined")?REVALEOK.coupon.amount:VALEOK.coupon.amount,
                firma_canjeante     : firma,
                rfc                 : rfc_canjeante,
                sexo                : sexo_canjeante,
                b_nombre            : b_nombre,
                b_parentesco        : b_parentesco,
                b_porcentaje        : b_porcentaje,
                seguro_quincenas    : seguro_quincenas,
                seguro_total        : seguro_total,
                seguro_desde        : seguro_desde,
                seguro_hasta        : seguro_hasta,
                seguro_costo        : seguro_costo,
                ca                  : CA
              },
              method: 'get'
          }).done(function (response) {
             if(tickets.toLowerCase() == 'aptos' || tickets.toLowerCase() === 'aptos'){
                //console.log(response);
                //console.log('RESPONDIO CON APTOS');
                var jsonC = JSON.stringify(response);
                //$("#muestraJson").html(jsonC);
                //console.log(jsonC);
                RespuestaApi(jsonC);
                //self.setContent('Ticket enviado a impresión');
                //self.setTitle("Impresión de Tickets");
              }else if(tickets.toLowerCase() == 'ec'){
                self.setContent('Exito en Venta');
                self.setTitle("Venta dpvale");
                console.log(response);
                console.log('RESPONDIO CON ECCOMERCE');
                try{
                    parent.RespuestaApi(response);
                }catch{
                    console.log('Error: No se encuentra en viewer');
                }
              }else if(tickets.toLowerCase() == 'pruebas'){
                cadena = response.HTML_R;
                response.HTML_R = cadena.toString();
                var jsonC = JSON.stringify(response);
                RespuestaApi(jsonC);
              }else{
                htm = response;
                console.log(response);
                console.log('RESPNDIO CON PRUEBAS');
                impR = decodeHTML(response.HTML_R[0]);
                impT = decodeHTML(response.HTML_T[0]);
                if( impR != ''){
                   var impLaser = window.open("", "ImpresionLaser", "width=1024,height=400");
                   impLaser.document.write(impR);
                }
                self.setContent(impT);
                self.setTitle("Impresión de Tickets");
                contenido = impT;
                setTimeout(function () {
                    $(".container-fluid, .jconfirm").css("display",'none');
                    $('#div-ticket').html(response).removeClass('hide');
                    window.print();
                    $(".container-fluid, .jconfirm").css("display",'');
                    $('#div-ticket').html('').addClass('hide');
                }, 995500);
              }
          }).fail(function(){
              self.setTitle("Impresión de Tickets");
              self.setContent('Error en obtener el ticket');
          });
      },
      columnClass: 'medium',
      buttons: {
          boton1: {
              text: 'OK',
              btnClass: 'btn-green',
              action: function(){
              },
           }
          }
  });
}

$("#registro_fnacimiento").on('blur',function(){
  existeFecha($(this).val());
});

function existeFecha (fecha) {
  var fechaf = fecha.split("-");
         var d = fechaf[2];
         var m = fechaf[1];
         var y = fechaf[0];
         return  m > 0 && m < 13 && y > 0 && y < 32768 && d > 0 && d <= (new Date(y, m, 0)).getDate();
}

function validaDatos(){
  if(! existeFecha($("#registro_fnacimiento").val()) ){
    alert('error en Fecha');
    return false;
  }
  return true;
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

var decodeHTML = function (html) {
	var txt = document.createElement('textarea');
	txt.innerHTML = html;
	return txt.value;
};

$(document).on("keypress", ":input:not(textarea):not([type=submit])", function(event) {
  if (event.keyCode == 13) {
    event.preventDefault();
    var fields = $("#form-beneficiario").find("input, textarea, select, button");
    var index = fields.index(this) + 1;
    var field;
    fields.eq(
      fields.length <= index
      ? 0
      : index
    ).focus();
  }
});



</script>
