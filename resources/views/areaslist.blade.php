<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link href="css/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <form method="POST" action="/" style="padding: 20px 15px 0 15px;">
                {{ csrf_field() }}
                <div class="form-group row">
                    <select name="area" class="form-control" onchange="this.form.submit()">
                        <option>{{$currArea}}</option>
                        @foreach($areasInFilter as $key => $area)
                            @if($area != $currArea)
                                <option value="{{$area}}">{{$area}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </form>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                      <th>Area</th>
                        @if($isFiltered)
                            <th>Distance (kms)</th>
                        @else
                            <th>Latitude</th>
                            <th>Longitude</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($isFiltered)
                        @foreach($areas as $area => $distance)
                            @if ($area != $currArea)
                                <tr>
                                    <td>{{$area}}</td>
                                    <td>{{$distance}}</td>
                                </tr>
                            @endif
                        @endforeach
                    @else
                        @foreach($areas as $area => $coords)
                            <tr>
                                <td>{{$area}}</td>
                                <td>{{$coords['lat']}}</td>
                                <td>{{$coords['long']}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </body>
</html>
