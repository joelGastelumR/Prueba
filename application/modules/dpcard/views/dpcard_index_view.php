<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club DP</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
        .main-logo {
            width: 65%;
            margin: 10px 0;
        }
        button.disabled {
            cursor: not-allowed;
        }
        .mensaje{
            font-weight: bold;
            margin-bottom: -5px;
        }
        .mensaje_pago{
            margin-bottom: 3px;
        }
        #lbl_mensaje{
            margin-top: -15px;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center">
                <img class="main-logo" src="<?= base_url('/assets/imgs/dpcard.jpg') ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="mensaje_pago"><b>Monto a pagar con tarjeta ClubDP: $<?=number_format($monto,2,'.',',')?></b></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Tarjeta:</div>
                            </div>
                            <input type="text" class="form-control" placeholder="Número de 16 digitos" maxlength="16" id="txtDpCard">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="button" id="btnValidarDpCard"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Cliente:</div>
                            </div>
                            <input type="text" class="form-control" placeholder="Nombre completo" readonly id="txtCliente">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Promos:</div>
                            </div>
                            <select class="form-control" id="selPromos" autocomplete="off">
                                <option value="">.:SELECCIONE:.</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <small>ORDEN: #<?= $ordenid ?></small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12">
                <button class="btn btn-success float-right disabled" id="btnSiguiente" disabled>Siguiente</button>
                <button class="btn btn-danger float-right mr-3" id="btnCancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <footer class="footer fixed-bottom" style="height: 25px !important">
        <div class="container">
            <div class="row">
                <div class="col-auto" style="margin: 0 auto;">
                    <span class="text-muted">Pago clubdp-ecommerce &copy; <?php echo date("Y"); ?></span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Compra Correcta-->
    <div class="modal fade" id="modalCompraCorrecta" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <img class="main-logo" src="<?= base_url('/assets/imgs/dpcard.jpg') ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h3 class="text-center font-weight-bold">Gracias por su compra</h3>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="text-center">Su compra ha sido registrada correctamente.</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p class="text-center">Código de autorización: <span id="lblNoAutorizacion" class="font-weight-bold"></span>.</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-success" id="btnFinalizarCompra">Finalizar compra</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SMS-->
    <div class="modal fade" id="modalSMS" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
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
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="label2">DPC-</span>
                                </div>
                                <input type="text" class="form-control form-control-lg" id="txtCodeSms" placeholder="0000000" maxlength="7" >
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" id="btnReenviarCodigoSMS">Reenviar Código SMS </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btnVarificarCodeSms">Verificar</button>
                </div>
            </div>
            <!--  <p id="btn_reenvio_sms" class="form-text text-muted">Si no le ha llegado el mensaje puede volver enviarlo <button class="btn btn-primary" onclick="reenvio()">Reenviar</button></p>-->
        </div>
    </div>

    <!-- Modal Compra Correcta-->
    <div class="modal fade" id="modalCancelacion" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12 text-center">
                            <img class="main-logo" src="<?= base_url('/assets/imgs/dpcard.jpg') ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="text-center font-weight-bold">¿Seguro que desea cancelar su pedido?</h6>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Motivo</span>
                                </div>
                                <select class="form-control" id="modalCancelacion_selMotivo" onchange="if(this.value == 'Otro'){$('#modalCancelacion_txtOtro').parents('.row').show(200);}else{$('#modalCancelacion_txtOtro').parents('.row').hide(200);}">
                                    <option value="">.:SELECCIONE:.</option>
                                    <option value="Me he equivocado en el pedido, haré uno nuevo">Me he equivocado en el pedido, haré uno nuevo</option>
                                    <option value="No me convencen las promociones">No me convencen las promociones</option>
                                    <option value="Ya no lo necesitaba">Ya no lo necesitaba</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="display: none;">
                        <div class="col-md-12">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Otro</span>
                                </div>
                                <input type="text" class="form-control form-control" id="modalCancelacion_txtOtro" placeholder="Su descripción" maxlength="80"/>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-danger" id="modalCancelacion_btnCancelar">CONFIRMAR CANCELACIÓN</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="<?php echo $hash; ?>" name="idtoken" id="idtoken">

    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/cryptojs-aes/cryptojs-aes-format.js"></script>
    <script type='text/javascript' src="<?php echo base_url(); ?>assets/cryptojs-aes/cryptojs-aes.min.js"></script>
    <script>
        $.blockUI.defaults.css = {};
        $(function(){

            $("#txtDpCard").keypress(function (e) {
                var charCode = (e.which) ? e.which : event.keyCode;

                if (String.fromCharCode(charCode).match(/[^0-9]/g))
                    return false;
            });

            $("#btnCancelar").click(function(){
                $("#modalCancelacion").modal("show");
            });

            $("#btnFinalizarCompra").click(function(){
                dprespuesta=window.dpcard;
                parent.postMessage(dprespuesta,"*");
            });

            $("#modalCancelacion_btnCancelar").click(function(){
                var motivo = $("#modalCancelacion_selMotivo").val();

                if(motivo == ""){
                    mensaje("alerta", "Necesita seleccionar un motivo de cancelación.", function(){
                        setTimeout(() => {
                            $("#modalCancelacion_selMotivo").focus();
                        }, 200);
                    });
                    return;
                }

                motivo = (motivo == "Otro") ? $("#modalCancelacion_txtOtro").val() : motivo;

                ajax("<?php echo base_url('dpcard/DpCard_controller/guardar_motivo_cancelacion'); ?>", {
                    "motivo": motivo
                }, "GET").then(function (response) {
                    parent.postMessage('cerrar',"*");
                });
            });

            $("#btnSiguiente").click(function(){
                if($("#selPromos").val() == "")
                {
                    mensaje("alerta", "Necesita seleccionar una promoción. Favor de revisar.", function(){
                        setTimeout(() => {
                            $("#selPromos").focus();
                        }, 200);
                    });
                    return;
                }

                if(!parseInt($("#txtDpCard").val()) || $("#txtDpCard").val().length != 16)
                {
                    mensaje("alerta", "El número de tarjeta debe ser de 16 digitos.", function(){
                        setTimeout(() => {
                            $("#txtDpCard").focus();
                        }, 200);
                    });
                    return;
                }

                if($("#txtCliente").val() == "")
                {
                    mensaje("alerta", "Favor de validar cliente mediante código sms.", function(){
                        setTimeout(() => {
                            $("#txtCliente").focus();
                        }, 200);
                    });
                    return;
                }

                ajax("<?php echo base_url('dpcard/DpCard_controller/confirmar_compra'); ?>", {
                    "dpcard": btoa(JSON.stringify(CryptoJSAesJson.encrypt($("#txtDpCard").val(), "<?php echo $hash; ?>"))),
                    "promocion": $("#selPromos").val(),
                    "promocionDesc": $("#selPromos option:selected").text()
                }, "GET").then(function (response) {
                    if(response.status)
                    {
                        $("#lblNoAutorizacion").html(response.ca);
                        $("#modalCompraCorrecta").modal("show");
                    }
                    response.no_tarjeta = $("#txtDpCard").val();
                    window.dpcard=response;
                    console.log(response);
                });
            });

            $("#btnVarificarCodeSms").click(function(){
                $("#btnSiguiente").addClass("disabled");
                $("#btnSiguiente").attr("disabled", true);

                ajax("<?php echo base_url('dpcard/DpCard_controller/validar_codesms'); ?>", {
                    "userCode": $("#txtCodeSms").val()
                }, "GET").then(function (response) {
                    if(response.status)
                    {
                        $("#txtCliente").val(response.result.customer);
                        $("#selPromos").html('<option value="">.:SELECCIONE:.</option>');
                        $.each(response.result.promotions, function(index, value){
                            $("#selPromos").append('<option value="'+value.valor+'">'+value.descripcion+'</option>');
                        });
                        $("#btnSiguiente").removeClass("disabled");
                        $("#btnSiguiente").removeAttr("disabled");
                        $("#modalSMS").modal("hide");
                    }
                });
            });

            $("#btnValidarDpCard, #btnReenviarCodigoSMS").click(function(){
                if(parseInt($("#txtDpCard").val()) && $("#txtDpCard").val().length == 16)
                {
                    $("#btnSiguiente").addClass("disabled");
                    $("#btnSiguiente").attr("disabled", true);

                    ajax("<?php echo base_url('dpcard/DpCard_controller/validate_dpcard'); ?>", {
                        "dpcard": btoa(JSON.stringify(CryptoJSAesJson.encrypt($("#txtDpCard").val(), "<?php echo $hash; ?>")))
                    }, "GET").then(function (response) {
                        if(response.status)
                        {
                            $("#txtCodeSms").val("");
                            $("#modalSMS").modal("show");
                        }
                    });
                }
                else
                {
                    mensaje("alerta", "El número de tarjeta debe ser de 16 digitos.", function(){
                        setTimeout(() => {
                            $("#txtDpCard").focus();
                        }, 200);
                    });
                }

            });

        });


        function mensaje(tipo, mensaje,callback = null){
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
                                action: callback
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
                                action: callback
                            }
                        }
                    });
                break;
                case 'alerta':
                    $.confirm({
                        title: 'Atención',
                        content: mensaje,
                        type: 'orange',
                        typeAnimated: true,
                        columnClass: 'medium',
                        buttons: {
                            tryAgain: {
                                text: 'Aceptar',
                                    keys: ['enter', 'esc'],
                                btnClass: 'btn-orange',
                                action: callback
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
                                action: callback
                            }
                        }
                    });
                break;
            }
        }


        function ajax(url_ajax, data_ajax, type_ajax){
            return new Promise(function(resolve, reject) {
                var resultado = null;
                type_ajax = type_ajax || "POST";
                data_ajax["token"] = "<?php echo $hash; ?>";
                data_ajax["itoken"] = $("#idtoken").val();
                $.ajax({
                    url: url_ajax,
                    method: type_ajax,
                    data: data_ajax,
                    async: true,
                    beforeSend: function(){
                        $("#modal_loading").modal("show");
                        $.blockUI({ message: '<h2>Espere un momento...</h2>',timeout: 60000,baseZ: 9000 });
                    },
                    complete: function(){
                        $("#modal_loading").modal("hide");
                        $(document).ajaxStop($.unblockUI);
                    },
                    success: function(data){
                        try {
                            if(data = jQuery.parseJSON(data))
                            {
                                if(!data.status) throw data.message;
                                resultado = jQuery.isEmptyObject(data) ? [] : data;
                            }
                            else
                            {
                                throw "Atención, ha ocurrido un error inesperado, contacte a soporte.";
                            }
                        } catch (error)
                        {
                            if(url_ajax == "<?php echo base_url('dpcard/DpCard_controller/confirmar_compra'); ?>")
                            {
                                error += "\n\nSe reenviará un código vía sms para volver a validar al cliente.";
                                mensaje("alerta", error, function(){
                                    $("#btnValidarDpCard").click();
                                });
                            }
                            else
                            {
                                mensaje("alerta", error);
                            }
                        }
                        resolve(resultado);
                    },
                    error: function (request, status, error) {
                        mensaje("error", "Atención, ha ocurrido un error inesperado, contacte a soporte.\n\nError: "+request.status+" "+request.statusText+".");
                    }
                });
            });
        }
    </script>
</body>
</html>
