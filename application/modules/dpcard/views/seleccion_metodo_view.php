<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPortenis - Selección forma pago</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        a.opcion_forma_pago img {
            border: 1px solid gray;
            border-radius: 10px;
            width: 70%;
        }
        a.opcion_forma_pago img:hover {
            border: 2px solid #071d84;
        }
        #modal_loading .modal-dialog{
            width: 70% !important;
        }
        span.letreroQAS {
            color: red;
            float: right;
            margin-top: -50px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php 
        if(ENVIRONMENT=="development"){
            echo "<span class='letreroQAS'>QAS</span>";
       }
     ?>
    
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-12">
                <p class="text-center font-weight-bold">Seleccione la opción con la que desea pagar.</p>
            </div>
        </div>

        <?php if(strpos($tiposPago, "DPCARD") !== false) { ?>
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <a href="<?php echo base_url('dpcard/DpCard_controller/dpcard_index') . "?key=" . $key; ?>" class="opcion_forma_pago"><img class="main-logo" src="<?= base_url('/assets/imgs/dpcard.jpg') ?>"></a>
                </div>
            </div>
        <?php } ?>

        <?php if(strpos($tiposPago, "DPVALE") !== false) { ?>
            <div class="row">
                <div class="col-md-12 text-center">
                    <a href="<?php echo base_url('dpvalecom') . "?key=" . $key; ?>" class="opcion_forma_pago"><img class="main-logo" src="<?= base_url('/assets/imgs/dpvale_reflex.png') ?>"></a>
                </div>
            </div>
        <?php } ?>

    </div>

    <!-- Modal cargando -->
    <div id="modal_loading" class="modal" role="dialog" data-backdrop="static" data-keyboard="false" style="z-index: 2000">
        <div class="modal-dialog" style="width: 30%; margin: 35vh auto;">
            <div class="modal-content" style="-webkit-box-shadow: none; box-shadow: none; border-radius: unset; border: 3px solid rgb(170, 170, 170)">
                <div class="modal-body text-center" style="padding: 0;">
                    <h3>Espere, sea paciente.</h3>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        $(function(){
            $(".opcion_forma_pago").click(function(){
                $("#modal_loading").modal("show");
            });
        });
    </script>
</body>
</html>