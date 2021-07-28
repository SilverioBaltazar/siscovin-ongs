@extends('sicinar.principal')

@section('title','Estadistica del padrón por sexo')

@section('links')
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('nombre')
{{$nombre}}
@endsection

@section('usuario')
{{$usuario}}
@endsection

@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Numeralia Básica
        <small> Gráfica</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
        <li><a href="#">Numeralia</a></li>
        <li><a href="#">Estadisticas</a></li>
        <li class="active">Padrón de beneficiarios por sexo</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b>Padrón de beneficiarios por sexo</b></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
              <table id="tabla1" class="table table-striped table-bordered table-sm">
                <thead style="color: brown;" class="justify">
                  <tr>
                    <th rowspan="2" style="text-align:left;"  >SEXO   </th>
                    <th rowspan="2" style="text-align:center;">TOTAL  </th>
                  </tr>
                  <tr>
                  </tr>
                </thead>

                <tbody>
                  @foreach($regpadron as $padron)
                    <tr>
                         <td style="color:darkgreen;">{{$padron->sexo}}   </td>
                         <td style="color:darkgreen; text-align:center;">{{$padron->total}}   </td>
                    </tr>
                  @endforeach
                  @foreach($regtotal as $totales)
                    <tr>
                        <td style="color:green;"><b>TOTAL</b></td>                         
                        <td style="color:green; text-align:center;"><b>{{$totales->total}} </b></td>                      
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Grafica de pie en 3D-->
        <div class="col-md-6">
          <div class="box">
            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title" style="text-align:center;">Gráfica de Pay 3D </h3> 
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <div class="box-body">
                  <camvas id="piechart_3d" style="width: 900px; height: 500px;"></camvas>
                </div>
              </div> 
            </div>
          </div>
        </div>


      </div>      

    </section>
  </div>
@endsection

@section('request')
  <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
  
  <!-- Grafica de pay, barras y otras
    https://google-developers.appspot.com/chart/interactive/docs/gallery/piechart
    https://www.youtube.com/watch?v=Y83fxTpNSsY
  -->
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endsection

@section('javascrpt')

  
  <!-- Grafica de piechart 3D Google/chart -->
  <script type="text/javascript">
      // https://www.youtube.com/watch?v=Y83fxTpNSsY ejemplo de grafica de pay google
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['sexo', 'total'],
          @foreach($regpadron as $padron)
             ['{{$padron->sexo}}', {{$padron->total}} ],
          @endforeach
          //['Work',     11],
          //['Eat',      2],
          //['Commute',  2],
          //['Watch TV', 2],
          //['Sleep',    7]
        ]);

        var options = {
          title: 'Padrón de beneficiarios por sexo',
          //chart: { title: 'Gráfica de Pay',
          //         subtitle: 'IAPS por Rubro Social' },          
          is3D: true,
          width: 700,                   // Ancho de la pantalla horizontal
          height: 500,                  // Alto de la pantall '75%',          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }
  </script>

    
@endsection
