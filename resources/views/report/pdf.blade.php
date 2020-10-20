<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Report : {{ $date[0] }} ~ {{ $date[1] }}</h3>
    <table id="data_table" style="margin-left:100px">          
        <tbody>
            <tr>
                <td rowspan="2" style="text-align:center;border:1px solid black">#</td>            
                <td rowspan="2" style="text-align:center;border:1px solid black">ID</td>            
                <td rowspan="2" style="text-align:center;border:1px solid black">Name</td>                            
                <td colspan="2" style="text-align:center;border:1px solid black">{{ $date[0] }}</td>     
            </tr>        
            <tr>
                <td  style="text-align:center;border:1px solid black">Arrival</td>
                <td  style="text-align:center;border:1px solid black">Time home</td>       
            </tr>            
            @foreach ($abcent as $key => $value)
                <tr>
                    <td style="border:1px solid black">{{ $key+1 }}</td>                    
                    <td style="border:1px solid black;text-align:left">{{ $value->nim }}</td>                    
                    <td style="border:1px solid black">{{ $value->name}}</td>

                @if (count($value->abcent) > 0)                        
                    @foreach($value->abcent as $key2 => $abcent2)
                        @php
                            $arrival = new DateTime($abcent2->arrival);
                            $waktu_pulang = new DateTime($abcent2->waktu_pulang);
                            $dates = $date[0]; //
                        @endphp

                        @if ($date[1] !== '')                        
                            @if ($arrival->format('Y-m-d') == $dates)
                            <td style="text-align:center;border:1px solid black">{{ $abcent2->arrival ?? '-'}}</td>
                                <td style="text-align:center;border:1px solid black">{{ $abcent2->waktu_pulang ?? '-'}}</td>
                                @else
                                <td style="text-align:center;border:1px solid black">-</td>
                                @endif
                        @else
                            <td style="text-align:center;border:1px solid black">{{ $abcent2->arrival ?? '-'}}</td>
                            <td style="text-align:center;border:1px solid black">{{ $abcent2->waktu_pulang ?? '-'}}</td>
                        @endif
                    @endforeach
                    @else
                        @php                            
                            $dates = $date[0]; //
                        @endphp
                        @if ($date[1] !== '')                        
                            <td style="text-align:center;border:1px solid black">-</td>                             
                            <td style="text-align:center;border:1px solid black">-</td>                             
                        @else
                            <td style="text-align:center;border:1px solid black">-</td>                             
                            <td style="text-align:center;border:1px solid black">-</td>   
                        @endif
                    @endif
                </tr>
            @endforeach
        </tbody>
         @php            
            $dates = $date[0]; //
        @endphp
         @if ($date[1] !== '')                        
            @while ($dates < $date[1])                                                                
             @php            
                $dates++
            @endphp
            <tbody>
                <tr>
                    <td rowspan="2" style="text-align:center;border:1px solid black">#</td>            
                    <td rowspan="2" style="text-align:center;border:1px solid black">ID</td>            
                    <td rowspan="2" style="text-align:center;border:1px solid black">Name</td>                            
                    <td colspan="2" style="text-align:center;border:1px solid black">{{ $dates }}</td>     
                </tr>        
                <tr>
                    <td  style="text-align:center;border:1px solid black">Arrival</td>
                    <td  style="text-align:center;border:1px solid black">Time home</td>       
                </tr>            
                @foreach ($abcent as $key => $values)
                    <tr>
                                                
                        
                        <td style="border:1px solid black">{{ $key+1 }}</td>                    
                        <td style="border:1px solid black;text-align:left">{{ $values->nim }}</td>                    
                        <td style="border:1px solid black">{{ $values->name}}</td>
                        

                        @if (count($value->abcent) > 0)                        
                            @foreach($values->abcent as $key2 => $abcent)                
                                <td style="text-align:center;border:1px solid black">{{ $abcent->arrival ?? '-'}}</td>
                                <td style="text-align:center;border:1px solid black">{{ $abcent->waktu_pulang ?? '-'}}</td>
                            @endforeach
                        @else                                                
                                <td style="text-align:center;border:1px solid black">-</td>                             
                                <td style="text-align:center;border:1px solid black">-</td>                           
                        @endif
                    </tr>
                @endforeach
            </tbody>
               
            @endwhile
        @endif
    </table>
</body>
</html>