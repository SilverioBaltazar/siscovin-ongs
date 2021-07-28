@extends('sicinar.principal')

@section('title','Editar requisitos asistenciales')

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
                Menú
                <small> Instituciones Privadas (IAPS) - Requisitos asistenciales - Editar</small>
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Editar requisitos asistenciales</h3>
                        </div>
                        {!! Form::open(['route' => ['actualizarReqa',$regasistencia->iap_id], 'method' => 'PUT', 'id' => 'actualizarReqa', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6 offset-md-6">
                                    <label>IAP : {{$regasistencia->iap_id.' '}}</label>
                                    @foreach($regiap as $iap)
                                        @if($iap->iap_id == $regasistencia->iap_id)
                                            <label style="color:green;">{{$iap->iap_desc}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>                                     
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal de los requisitos a cumplir </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                    <option selected="true" disabled="disabled">Seleccionar Periodo fiscal </option>
                                    @foreach($regperiodos as $periodo)
                                        @if($periodo->periodo_id == $regasistencia->periodo_id)
                                            <option value="{{$periodo->periodo_id}}" selected>{{$periodo->periodo_desc}}</option>
                                        @else 
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endif                                    
                                    @endforeach
                                    </select>
                                </div>     
                            </div>

                            <div class="row">               
                                @if(!empty($contable->iap_d1)&&(!is_null($contable->iap_d1)))
                                    <div class="col-xs-4 form-group">
                                       <label >Archivo de padrón de beneficiarios en formato Excel </label><br>
                                        <a href="/images/{{$regasistencia->iap_d1}}" class="btn btn-success" title="padrón de beneficiarios"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                        </a>{{$regasistencia->iap_d1}}
                                        <input type="hidden" name="doc_id1" id="doc_id1" value="5">
                                    </div>  
                                @else
                                    <div class="col-xs-4 form-group">
                                       <label >Archivo de padrón de beneficiarios en formato Excel </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id1" id="doc_id1" value="5">
                                    </div>                                
                                @endif                                
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id1" id="formato_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id1)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de hombres </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_007" id="preg_007" placeholder="99999" value="{{$regasistencia->preg_007}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Total de mujeres </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_008" id="preg_008" placeholder="99999" value="{{$regasistencia->preg_008}}" required>
                                </div>  
                            </div>               
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id1" id="per_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id1)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id1" id="num_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id1)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo1" id="iap_edo1" required>
                                        @if($regasistencia->iap_edo1 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    @if(!empty($contable->iap_d2)&&(!is_null($contable->iap_d2)))
                                        <label >Archivo de plantilla de personal en formato excel </label><br>
                                        <a href="/images/{{$regasistencia->iap_d2}}" class="btn btn-success" title="documento de plantilla de personal"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                        </a>{{$regasistencia->iap_d2}}
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="6">
                                    @else
                                        <label >Archivo de plantilla de personal en formato excel </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id2" id="doc_id2" value="6">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id2" id="formato_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato de archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id2)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal remunerado  </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_009" id="preg_009" placeholder="99999" value="{{$regasistencia->preg_009}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal voluntario </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_010" id="preg_010" placeholder="99999" value="{{$regasistencia->preg_010}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal administrativo </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_011" id="preg_011" placeholder="99999" value="{{$regasistencia->preg_011}}" required>
                                </div>                                  
                            </div> 
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de personal operativo  </label>
                                    <input type="number" min="0" max="99999" class="form-control" name="preg_012" id="preg_012" placeholder="99999" value="{{$regasistencia->preg_012}}" required>
                                </div>                                                                        
                                <div class="col-xs-4 form-group">
                                    <label >Monto total en $ persos mexicanos del personal administrativo </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="preg_013" id="preg_013" placeholder="999999999999.99" value="{{$regasistencia->preg_013}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Monto total en $ persos mexicanos del personal operativo </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="preg_014" id="preg_014" placeholder="999999999999.99" value="{{$regasistencia->preg_014}}" required>
                                </div>                                  
                            </div>                                                                       
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id2" id="per_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id2)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id2" id="num_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id2)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo2" id="iap_edo2" required>
                                        @if($regasistencia->iap_edo2 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    @if(!empty($contable->iap_d3)&&(!is_null($contable->iap_d3)))
                                        <label >Archivo de detección de necesidades en formato Excel </label><br>
                                        <a href="/images/{{$regasistencia->iap_d3}}" class="btn btn-success" title="constancia de autorización para recibir donativos"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                        </a>{{$regasistencia->iap_d3}}
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="2">
                                    @else
                                        <label >Archivo de detección de necesidades en formato Excel </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id3" id="doc_id3" value="2">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id3" id="formato_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id3)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id3" id="per_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id3)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id3" id="num_id3" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id3)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo3" id="iap_edo3" required>
                                        @if($regasistencia->iap_edo3 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    @if(!empty($contable->iap_d4)&&(!is_null($contable->iap_d4)))
                                        <label >Archivo de programa de trabajo en formato Excel </label><br>
                                        <a href="/images/{{$regasistencia->iap_d4}}" class="btn btn-success" title="declaración anual"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                        </a>{{$regasistencia->iap_d4}}
                                        <input type="hidden" name="doc_id4" id="doc_id4" value="7">
                                    @else
                                        <label >Archivo de programa de trabajo en formato Excel </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id4" id="doc_id4" value="7">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id4" id="formato_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id4)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades programadas </label>
                                    <input type="text" class="form-control" name="preg_015" id="preg_015" placeholder="Total de actividades programadas" value="{{$regasistencia->preg_015}}" required>
                                </div>                                                                        
                            </div>                             
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id4" id="per_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id4)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id4" id="num_id4" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id4)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo4" id="iap_edo4" required>
                                        @if($regasistencia->iap_edo4 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">               
                                <div class="col-xs-4 form-group">
                                    @if(!empty($contable->iap_d5)&&(!is_null($contable->iap_d5)))
                                        <label >Archivo de Informe de labores en formato excel </label><br>
                                        <a href="/images/{{$regasistencia->iap_d5}}" class="btn btn-danger" title="cuotas 5 al millar"><i class="fa fa-file-excel-o"></i><small>Excel</small>
                                        </a>{{$regasistencia->iap_d5}}
                                        <input type="hidden" name="doc_id5" id="doc_id5" value="15">
                                    @else
                                        <label >Archivo de Informe de labores en formato excel </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id5" id="doc_id5" value="15">
                                    @endif
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Formato del archivo que se subio </label>
                                    <select class="form-control m-bot15" name="formato_id5" id="formato_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar formato del archivo </option>
                                        @foreach($regformatos as $formato)
                                            @if($formato->formato_id == $regasistencia->formato_id5)
                                                <option value="{{$formato->formato_id}}" selected>{{$formato->formato_desc}}</option>
                                            @else 
                                               <option value="{{$formato->formato_id}}">{{$formato->formato_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                                    
                                </div>                                    
                            </div>
                            <div class="row">        
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades cumplidas  </label>
                                    <input type="text" class="form-control" name="preg_016" id="preg_016" placeholder="Total de actividades cumplidas " value="{{$regasistencia->preg_016}}" required>
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Total de actividades no cumplidas  </label>
                                    <input type="text" class="form-control" name="preg_017" id="preg_017" placeholder="Total de actividades no cumplidas " value="{{$regasistencia->preg_017}}" required>
                                </div>                            
                            </div>                                                                       
                            <div class="row">                                                                 
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad de cumplimiento del requisito </label>
                                    <select class="form-control m-bot15" name="per_id5" id="per_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodicidad de cumplimiento </option>
                                        @foreach($regperiodicidad as $periodicidad)
                                            @if($periodicidad->per_id == $regasistencia->per_id5)
                                                <option value="{{$periodicidad->per_id}}" selected>{{$periodicidad->per_desc}}</option>
                                            @else 
                                               <option value="{{$periodicidad->per_id}}">{{$periodicidad->per_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">
                                    <label >Periodo de entrega  </label>
                                    <select class="form-control m-bot15" name="num_id5" id="num_id5" required>
                                        <option selected="true" disabled="disabled">Seleccionar Periodo de entrega</option>
                                        @foreach($regnumeros as $numeros)
                                            @if($numeros->num_id == $regasistencia->num_id5)
                                                <option value="{{$numeros->num_id}}" selected>{{$numeros->num_desc}}</option>
                                            @else 
                                               <option value="{{$numeros->num_id}}">{{$numeros->num_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                  
                                </div>  
                                <div class="col-xs-4 form-group">                        
                                    <label>¿Requisito cumplido y actualizado? </label>
                                    <select class="form-control m-bot15" name="iap_edo5" id="iap_edo5" required>
                                        @if($regasistencia->iap_edo5 == 'S')
                                            <option value="S" selected>Si</option>
                                            <option value="N">         No</option>
                                        @else
                                            <option value="S">         Si</option>
                                            <option value="N" selected>No</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verReqa')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                    </a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\reqasistenciaRequest','#actualizarReqa') !!}
@endsection

@section('javascrpt')
@endsection
