@section('title','exportacion de datos a xml')

@section('links')
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection


@section('content')
<!--// Create a new DOMDocument -->
@$doc = new DOMDocument(); 
  
// Load the HTML file 
@$doc->loadHTML( 
"<html> 
<head> 
    <title> 
    </title> 
</head>   
    <body>
         <div id="content1">
        <!--<p>the first page</p> -->
        <table class="table table-hover table-striped" align="center" width="100%"> 


                            <thead>
                               <tr>
                                   @foreach($data[0] as $key => $value)
                                       <th>{{ ucfirst($key) }}</th>
                                   @endforeach
                               </tr>
                            </thead>
                        
                            <tbody>
                            @foreach($data as $row)
                                <tr>
                                    @foreach ($row as $value)
                                       <td>{{ $value }}</td>
                                    @endforeach        
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

    </body>
</html>"); 
  
 <!-- Creates an HTML document and display it  -->
 @echo $doc->saveHTML(); 

@endsection

@section('request')
<link rel="stylesheet" type="text/css" href="style.css">
@endsection

@section('javascript')

@endsection