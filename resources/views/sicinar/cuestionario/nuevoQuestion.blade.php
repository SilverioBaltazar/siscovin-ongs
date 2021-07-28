@extends('sicinar.principal')

@section('title','Cuestionario de diligencia')

@section('nombre')
{{$nombre}}
@endsection

@section('usuario')
{{$usuario}}
@endsection

@section('content')
  <div class="content-wrapper" id="principal">
    <section class="content-header">
      <h1><small>Cuestionario de diligencia</small></h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Menú</a></li>
        <li><a href="#">Agenda de diligencias</a></li>
        <li class="active">Cuestionarios</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-12">
        {!! Form::open(['route' => 'altaNuevoQuestion', 'method' => 'POST', 'id' => 'altaNuevoQuestion']) !!}

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b>Criterios de verificación</b></h3>
            </div>

            <div class="box-body">

              <div class="row">
                <div class="col-xs-6">
                    <label>Folio de visita de diligencia </label>
                    <select class="form-control m-bot15" name="visita_folio" id="visita_folio" required>
                      <option selected="true" disabled="disabled">Seleccionar folio de visita de diligencia </option>
                      @foreach($regvisita as $visita)
                        <option value="{{ $visita->visita_folio}}">{{$visita->visita_folio.' '.' Periodo:'.' '.$visita->periodo_id.' Mes:'.$visita->mes_id.' día:'.$visita->dia_id}}
                        </option>
                      @endforeach
                    </select>
                </div>  
              </div>
                
              <div class="row">               
                <div class="col-xs-6">
                  <label >Nombre de quien atendera la diligencia</label>
                  <input type="text" class="form-control" name="visitaq_spub1" id="visitaq_spub1" placeholder="Nombre de quien atendera la diligencia" onkeypress="return soloAlfa(event)" required>
                </div>

                <div class="col-xs-6">
                  <label >Cargo </label>
                  <input type="text" class="form-control" name="visitaq_cargo1" id="visitaq_cargo1" placeholder="Cargo" onkeypress="return soloAlfa(event)" required>
                </div>
              </div>

            </div>
          </div>

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b style="color: orange;">Apartado 1. Aspectos obligatorios </b></h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-xs-5"><b style="color: green;">No.  Pregunta </b></div>
                  <div class="col-xs-2"><b style="color: green;">Cumple        </b></div>
                  <div class="col-xs-2"><b style="color: green;">Rubro         </b></div>
                  <div class="col-xs-3"><b style="color: green;">Observaciones </b></div>
              </div>
              @foreach($regquestion as $pregunta)
                @if($pregunta->preg_id >= 1 AND $pregunta->preg_id <= 9)
                  <div class="row">
                      <div><input type="hidden" name="preg_id{{$pregunta->preg_id}}" id="preg_id{{$pregunta->preg_id}}" value="{{$pregunta->preg_id}}">
                      </div>                    
                      <div class="col-xs-5">
                        <b style="color: orange;">{{'1.'.$pregunta->preg_id.' '}}</b>
                        <label style="color:gray;">{{$pregunta->preg_desc}}</label>
                      </div>  
                      <div class="col-xs-2">
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        checked value="S" style="margin-right:8px;" style="color:gray;">Si
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        value="N" style="margin-right:8px;" style="color:gray;">No
                      </div>

                      <div class="col-xs-2" style="color:gray;">
                      @foreach($regrubro as $rubro)
                          @if($rubro->rubro_id == $pregunta->rubro_id)
                            {{$rubro->rubro_desc}}
                            @break
                          @endif
                      @endforeach
                      </div>

                      <div class="col-xs-3" style="color:gray;">
                        <input type="text" class="form-control" name="p_obs{{$pregunta->preg_id}}" id="p_obs{{$pregunta->preg_id}}" placeholder="Observaciones">
                      </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b style="color: orange;">Apartado 2. Aspectos de mejora </b></h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-xs-5"><b style="color: green;">No.  Pregunta </b></div>
                  <div class="col-xs-2"><b style="color: green;">Cumple        </b></div>
                  <div class="col-xs-2"><b style="color: green;">Rubro         </b></div>
                  <div class="col-xs-3"><b style="color: green;">Observaciones </b></div>
              </div>
              @foreach($regquestion as $pregunta)
                @if($pregunta->preg_id >= 10 AND $pregunta->preg_id <= 17)
                  <div class="row">
                      <div><input type="hidden" name="preg_id{{$pregunta->preg_id}}" id="preg_id{{$pregunta->preg_id}}" value="{{$pregunta->preg_id}}">
                      </div>
                      <div class="col-xs-5">
                        <b style="color: orange;">{{'2.'.$pregunta->preg_id.' '}}</b>
                        <label style="color:gray;">{{$pregunta->preg_desc}}</label>
                      </div>  
                      <div class="col-xs-2">
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        checked value="S" style="margin-right:8px;" style="color:gray;">Si
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        value="N" style="margin-right:8px;" style="color:gray;">No
                      </div>

                      <div class="col-xs-2" style="color:gray;">
                      @foreach($regrubro as $rubro)
                          @if($rubro->rubro_id == $pregunta->rubro_id)
                            {{$rubro->rubro_desc}}
                            @break
                          @endif
                      @endforeach
                      </div>

                      <div class="col-xs-3" style="color:gray;">
                        <input type="text" class="form-control" name="p_obs{{$pregunta->preg_id}}" id="p_obs{{$pregunta->preg_id}}" placeholder="Observaciones">
                      </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>          

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b style="color: orange;">Apartado 3. Beneficiarios </b></h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-xs-5"><b style="color: green;">No.  Pregunta </b></div>
                  <div class="col-xs-2"><b style="color: green;">Cumple        </b></div>
                  <div class="col-xs-2"><b style="color: green;">Rubro         </b></div>
                  <div class="col-xs-3"><b style="color: green;">Observaciones </b></div>
              </div>
              @foreach($regquestion as $pregunta)
                @if($pregunta->preg_id >= 18 AND $pregunta->preg_id <= 31)
                  <div class="row">
                      <div><input type="hidden" name="preg_id{{$pregunta->preg_id}}" id="preg_id{{$pregunta->preg_id}}" value="{{$pregunta->preg_id}}">
                      </div>
                      <div class="col-xs-5">
                        <b style="color: orange;">{{'3.'.$pregunta->preg_id.' '}}</b>
                        <label style="color:gray;">{{$pregunta->preg_desc}}</label>
                      </div>  
                      <div class="col-xs-2">
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        checked value="S" style="margin-right:8px;" style="color:gray;">Si
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        value="N" style="margin-right:8px;" style="color:gray;">No
                      </div>

                      <div class="col-xs-2" style="color:gray;">
                      @foreach($regrubro as $rubro)
                          @if($rubro->rubro_id == $pregunta->rubro_id)
                            {{$rubro->rubro_desc}}
                            @break
                          @endif
                      @endforeach
                      </div>

                      <div class="col-xs-3" style="color:gray;">
                        <input type="text" class="form-control" name="p_obs{{$pregunta->preg_id}}" id="p_obs{{$pregunta->preg_id}}" placeholder="Observaciones">
                      </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>          

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b style="color: orange;">Apartado 4. Personal </b></h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-xs-5"><b style="color: green;">No.  Pregunta </b></div>
                  <div class="col-xs-2"><b style="color: green;">Cumple        </b></div>
                  <div class="col-xs-2"><b style="color: green;">Rubro         </b></div>
                  <div class="col-xs-3"><b style="color: green;">Observaciones </b></div>
              </div>
              @foreach($regquestion as $pregunta)
                @if($pregunta->preg_id >= 32 AND $pregunta->preg_id <= 47)
                  <div class="row">
                      <div><input type="hidden" name="preg_id{{$pregunta->preg_id}}" id="preg_id{{$pregunta->preg_id}}" value="{{$pregunta->preg_id}}">
                      </div>                    
                      <div class="col-xs-5">
                        <b style="color: orange;">{{'4.'.$pregunta->preg_id.' '}}</b>
                        <label style="color:gray;">{{$pregunta->preg_desc}}</label>
                      </div>  
                      <div class="col-xs-2">
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        checked value="S" style="margin-right:8px;" style="color:gray;">Si
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        value="N" style="margin-right:8px;" style="color:gray;">No
                      </div>

                      <div class="col-xs-2" style="color:gray;">
                      @foreach($regrubro as $rubro)
                          @if($rubro->rubro_id == $pregunta->rubro_id)
                            {{$rubro->rubro_desc}}
                            @break
                          @endif
                      @endforeach
                      </div>

                      <div class="col-xs-3" style="color:gray;">
                        <input type="text" class="form-control" name="p_obs{{$pregunta->preg_id}}" id="p_obs{{$pregunta->preg_id}}" placeholder="Observaciones">
                      </div>
                  </div>
                @endif
              @endforeach
            </div>
          </div>          

          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title"><b style="color: orange;">Apartado 5. Administración </b></h3>
            </div>

            <div class="box-body">
              <div class="row">
                  <div class="col-xs-5"><b style="color: green;">No.  Pregunta </b></div>
                  <div class="col-xs-2"><b style="color: green;">Cumple        </b></div>
                  <div class="col-xs-2"><b style="color: green;">Rubro         </b></div>
                  <div class="col-xs-3"><b style="color: green;">Observaciones </b></div>
              </div>
              @foreach($regquestion as $pregunta)
                @if($pregunta->preg_id >= 48 AND $pregunta->preg_id <= 58)
                  <div class="row">
                      <div><input type="hidden" name="preg_id{{$pregunta->preg_id}}" id="preg_id{{$pregunta->preg_id}}" value="{{$pregunta->preg_id}}"></div>                    
                      <div class="col-xs-5">
                        <b style="color: orange;">{{'5.'.$pregunta->preg_id.' '}}</b>
                        <label style="color:gray;">{{$pregunta->preg_desc}}</label>
                      </div>  
                      <div class="col-xs-2">
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        checked value="S" style="margin-right:8px;" style="color:gray;">Si
                        <input type="radio" name="p_resp{{$pregunta->preg_id}}" id="p_resp{{$pregunta->preg_id}}" 
                        value="N" style="margin-right:8px;" style="color:gray;">No
                      </div>

                      <div class="col-xs-2" style="color:gray;">
                      @foreach($regrubro as $rubro)
                          @if($rubro->rubro_id == $pregunta->rubro_id)
                            {{$rubro->rubro_desc}}
                            @break
                          @endif
                      @endforeach
                      </div>

                      <div class="col-xs-3" style="color:gray;">
                        <input type="text" class="form-control" name="p_obs{{$pregunta->preg_id}}" id="p_obs{{$pregunta->preg_id}}" placeholder="Observaciones">
                      </div>
                  </div>
                @endif
              @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 offset-md-5">
                  {!! Form::submit('Guardar cuestionario',['class' => 'btn btn-success btn-flat pull-right']) !!}
                  <!--<button type="submit" class="btn btn-primary btn-block">Guardar Cuentionario</button> -->
                  <a href="{{route('verQuestions')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
                </div>
            </div>
          </div>          

        {!! Form::close() !!}

        </div>
      </div>
    </section>
  </div>
@endsection

@section('request')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\visitaquestionRequest','#altaNuevoQuestion') !!}
@endsection

@section('javascrpt')
<script type="text/javascript">
  $(document).ready(function(){
      $("#secretaria").on('change', function(){
        var sec = $(this).val();
        if(sec) {
          $.ajax({
            url: 'unidades/'+sec,
            type: "GET",
            dataType: "json",
            success:function(data){
              var html_select = '<option selected="true" disabled="disabled">Unidad Responsable</option>';
              for (var i=0; i<data.length ;++i)
                html_select += '<option value="'+data[i].depen_id+'">'+data[i].depen_desc+'</option>';
              $('#unidad').html(html_select);
            }
          });
        }else{
          var html_select = '<option selected="true" disabled="disabled">Unidad Responsable</option>';
          $("#unidad").html(html_select);
        }
      });
    });
</script>

<script>
  function soloAlfa(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function general(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.;:-_<>!%()=?¡¿/*+";
       especiales = "8-35-36-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
</script>
@endsection