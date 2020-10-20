<table id="data_table" class="display">
        <tbody>
            <tr>
                <td rowspan="2" style="text-align:center;border:1px solid black">#</td>            
                <td rowspan="2" style="text-align:center;border:1px solid black">ID</td>            
                <td rowspan="2" style="text-align:center;border:1px solid black">Name</td>                            
                <td colspan="2" style="text-align:center;border:1px solid black">{{ $date[0] }}</td>     
                @php
                    $dates = $date[0]; //
                    @endphp
                @if ($date[1] !== '')                
                    @while ($dates < $date[1])                                    
                        <td colspan="2" style="text-align:center;border:1px solid black">{{ $dates++ }}</td>
                    @endwhile
                @endif          
            </tr>        
            <tr>
                <td  style="text-align:center;border:1px solid black">Arrival</td>
                <td  style="text-align:center;border:1px solid black">Time home</td>       
                @php
                $dates = $date[0]; //
                @endphp

                @if ($date[1] !== '')                
                    @while ($dates < $date[1])                                    
                        <td  style="text-align:center;border:1px solid black">Arrival</td>
                        <td  style="text-align:center;border:1px solid black">Time home</td>      
                    @php
                        $dates++;
                    @endphp
                    @endwhile
                @endif              
            </tr>            
            @foreach ($abcent as $key => $value)
                <tr>
                    <td style="border:1px solid black">{{ $key+1 }}</td>                    
                    <td style="border:1px solid black;text-align:left">{{ $value->nim }}</td>                    
                    <td style="border:1px solid black">{{ $value->name}}</td>

                
                    
                    @if (count($value->abcent) > 0)                        
                    @foreach($value->abcent as $key2 => $abcent)
                        @php
                            $arrival = new DateTime($abcent->arrival);
                            $waktu_pulang = new DateTime($abcent->waktu_pulang);
                            $dates = $date[0]; //
                        @endphp

                        @if ($date[1] !== '')                        
                            @while ($dates < $date[1])                                                                
                            @if ($arrival->format('Y-m-d') == $dates)
                            <td style="text-align:center;border:1px solid black">{{ $abcent->arrival ?? '-'}}</td>
                                <td style="text-align:center;border:1px solid black">{{ $abcent->waktu_pulang ?? '-'}}</td>
                                @else
                                <td style="text-align:center;border:1px solid black">-</td>
                                @endif
                                
                                
                                @php
                                    $dates++;
                                    @endphp
                            @endwhile
                        @else
                            <td style="text-align:center;border:1px solid black">{{ $abcent->arrival ?? '-'}}</td>
                            <td style="text-align:center;border:1px solid black">{{ $abcent->waktu_pulang ?? '-'}}</td>
                        @endif
                    @endforeach
                    @else
                        @php                            
                            $dates = $date[0]; //
                        @endphp
                        @if ($date[1] !== '')                        
                        @while ($dates < $date[1])                           
                            <td style="text-align:center;border:1px solid black">-</td>                             
                            <td style="text-align:center;border:1px solid black">-</td>                             
                            @php
                                $dates++;
                            @endphp
                        @endwhile
                        @else
                            <td style="text-align:center;border:1px solid black">-</td>                             
                            <td style="text-align:center;border:1px solid black">-</td>   
                        @endif
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>