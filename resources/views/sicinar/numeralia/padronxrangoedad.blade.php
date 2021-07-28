@extends('sicinar.principal')

@section('title','Estadística de padrón de beneficiarios por rango de edades')

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
        <li><a href="#">Estadísticas del Padron</a></li>
        <li class="active">Padrón de beneficiarios por rango de edades </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-6">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><b>Padrón de beneficiarios por rango de edades</b></h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
              <table id="tabla1" class="table table-striped table-bordered table-sm">
                <thead style="color: brown;" class="justify">
                  <tr>
                    <th rowspan="2" style="text-align:left;"  >PERIODO </th>
                    <th rowspan="2" style="text-align:left;"  >MENOR 5 </th>
                    <th rowspan="2" style="text-align:left;"  >6-10    </th>
                    <th rowspan="2" style="text-align:left;"  >11-17   </th>
                    <th rowspan="2" style="text-align:left;"  >18-30   </th>
                    <th rowspan="2" style="text-align:left;"  >31-60   </th>
                    <th rowspan="2" style="text-align:left;"  >61 Y MAS</th>
                    <th rowspan="2" style="text-align:center;">TOTAL   </th>
                  </tr>
                  <tr>
                  </tr>
                </thead>

                <tbody>
                  @foreach($regpadron as $padron)
                    <tr>
                        <td style="color:darkgreen;">{{$padron->periodo_id}} </td>
                        <td style="color:darkgreen;">{{$padron->emenosde5}}  </td>
                        <td style="color:darkgreen;">{{$padron->e06a10}}     </td>
                        <td style="color:darkgreen;">{{$padron->e11a17}}     </td>
                        <td style="color:darkgreen;">{{$padron->e18a30}}     </td>
                        <td style="color:darkgreen;">{{$padron->e31a60}}     </td>
                        <td style="color:darkgreen;">{{$padron->e61ymas}}    </td>
                        <td style="color:darkgreen; text-align:center;">{{$padron->total}} </td>
                    </tr>
                  @endforeach
                  @foreach($regtotal as $totales)
                    <tr>
                        <td></td>
                        <td style="color:green;"><b>TOTAL</b></td>                         
                        <td style="color:green; text-align:center;"><b>{{$totales->total}} </b></td>                      
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>


      <!-- Grafica de barras 2D-->
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box box-success">
              <!-- <div class="box-header with-border"> -->
                <!--<h3 class="box-title" style="text-align:center;">Gráfica por Rubro social 2D </h3> -->
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <div class="box-body">
                  <camvas id="top_x_div" style="width: 900px; height: 500px;"></camvas>
                </div>
              <!-- </div> -->
            </div>
          </div>
        </div>

        <!-- Grafica de barras 
        Creating Material bar charts
        https://google-developers.appspot.com/chart/interactive/docs/gallery/barchart
        -->
        <div class="col-md-12">
          <div class="box">
            <div class="box box-success">
              <!-- <div class="box-header with-border"> -->
                <!-- <h3 class="box-title" style="text-align:center;">Gráfica por Rubro social 3D </h3> -->
                <!-- BOTON para cerrar ventana x -->
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- Pinta la grafica de barras 2-->
                <div class="box-body">
                  <camvas id="barchart_material" style="width: 900px; height: 500px;"></camvas>
                </div>
              <!-- </div> -->
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

  <!-- Grafica de barras 2D Google/chart -->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ['Periodo', 'MENOS DE 5', '6-10', '11-17', '18-30', '31-60', '61 Y MAS'],
          @foreach($regpadron as $padron)
             ['{{$padron->periodo_id}}',{{$padron->emenosde5}},{{$padron->e06a10}},{{$padron->e11a17}}, 
                                        {{$padron->e18a30}}, {{$padron->e31a60}}, {{$padron->e61ymas}} ],
          @endforeach             //["King's pawn (e4)", 44],
          //["Queen's pawn (d4)", 31],
          //["Knight to King 3 (Nf3)", 12],
          //["Queen's bishop pawn (c4)", 10],
          //['Other', 3]
        ]);

        var options = {
          title: 'Padrón de beneficiarios por rango de edad',
          width: 700,                   // Ancho de la pantalla horizontal
          height: 500,                  // Alto de la pantall '75%',          
          legend: { position: 'hola....' },
          chart: { title: 'Gráfica de Barras 2D',
                   subtitle: 'Beneficiarios por rango de edad' },
          bars: 'horizontal', // Required for Material Bar Charts.
          axes: {
            x: {
              //0: { side: 'top', label: 'Total de IAPS'} // Top x-axis.
              1: { side: 'top', label: 'Total de beneficiarios'} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById('top_x_div'));
        chart.draw(data, options);
      };
  </script>  

  <!-- Grafica de dona 
  Making a donut chart
  https://developers.google.com/chart/interactive/docs/gallery/piechart#donut
  -->
  <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Periodo', 'MENOS DE 5', '6-10', '11-17', '18-30', '31-60', '61 Y MAS', { role: 'annotation' }],
          @foreach($regpadron as $padron)
             ['{{$padron->periodo_id}}',{{$padron->emenosde5}},{{$padron->e06a10}},{{$padron->e11a17}}, 
                                        {{$padron->e18a30}}, {{$padron->e31a60}}, {{$padron->e61ymas}}, '' ],
          @endforeach   
        ]);

        var options = {
            width: 600,
            height: 400,
            chart: {
            title: 'Padron de beneficiarios',
            subtitle: 'Rangos de edad',
            },
            legend: { position: 'top', maxLines: 3 },
            bar: { groupWidth: '75%' },
            isStacked: true
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      };
  </script>  
@endsection
