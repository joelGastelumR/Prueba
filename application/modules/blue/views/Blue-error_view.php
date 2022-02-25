<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Error</title>
    <style>
    .fix{
      top: 50%;
      margin-top: 5em;
    }
    #logo{
      width: 250px;
      padding: 10px;
      margin-left: 458px;
    }
    h1{
      color:red;

      text-align: center;
    }
    .panel > .panel-heading {
    background-image: none;
    background-color: white;
    color: black;
    }

    .panel > .panel-footer {
    background-image: none;
    background-color: #3E3D3B;
    color: black;
    }
    #icono{
      font-size: 80px;
      color: #E90000;
      border-color: black;
      border: 1px;
    }
    .icone{
      text-align: center;
    }
    .panel-body {
    padding: 78px;
}

    </style>
    <div class="container-fluid">
      <div class="col-sm-10 col-sm-offset-1 fix col-xs-10 col-xs-offset-1 col-md-8 col-md-offset-2 col-lg-7 col-md-offset-2">
        <div class="panel panel-default" id="panel1">
          <div class="panel-heading panel-default">
            <img id="logo" src="<?=base_url('assets/imgs/grupo_dp.png')?>" alt="Dpvale" class="img-responsive">
          </div>
          <div class="panel-body">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1><span id="icono" class="glyphicon glyphicon-alert"></span></h1>
                    <div class="icone">
                        <h2>Esta forma de pago no cuenta con cancelacion</h2>
                    </div>
                  </div>

            </div>
            <div class="panel-footer text-right">

            </div>
          </div>
        </div>
  </div>

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
