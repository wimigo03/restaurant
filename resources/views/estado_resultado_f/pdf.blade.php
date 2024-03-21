<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        html {
            margin: 20px 50px 30px 50px;
        }
        
        body {
            font-family: verdana,arial,helvetica;
            font-size: 10px;
        }

        .table {
            border-collapse: collapse;
            border: 1px solid black;
        }

        .table td, th {
            padding: 5px;
        }

        .page_break{
            page-break-before: always;
        }
    </style>
    <body>
        <br>
        <table width="100%" class="table">
            <tr style="border-bottom: 1px solid #000000;">
                <td><font size="9px"><b>CODIGO</b></font></td>
                <td><font size="9px"><b>CUENTA</b></font></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            @foreach ($ingresos as $ing)
                @php
                    $nroPuntos = 1;
                    for ($i=0; $i < strlen($ing->codigo); $i++) { 
                        if($ing->codigo[$i] == '.'){
                            $nroPuntos++;
                        }
                    }
                    $nroColumna = $nroMaxColumna - $nroPuntos;
                @endphp
                <tr style="border-bottom: 1px solid #ccc;">
                    <td>
                        <font size="9px">
                            <b>
                                {{ $ing->codigo }}
                            </b>
                        </font>
                    </td>
                    <td>
                        <font size="9px">
                            <b>
                                {{ $ing->nombre  }}
                            </b>
                        </font>
                    </td>
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                    <td align="right">
                        <font size="9px">
                            {{ number_format($totales[$ing->id],2,'.',',') }}
                        </font>
                    </td>
                    @php
                        $nroColumna = $nroMaxColumna - $nroColumna -1;
                    @endphp
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
            @foreach ($costos as $costo)
                @php
                    $nroPuntos = 1;
                    for ($i=0; $i < strlen($costo->codigo); $i++) { 
                        if($costo->codigo[$i] == '.'){
                            $nroPuntos++;
                        }
                    }
                    $nroColumna = $nroMaxColumna - $nroPuntos;
                @endphp
                <tr style="border-bottom: 1px solid #ccc;">
                    <td>
                        <font size="9px">
                            <b>
                                {{ $costo->codigo }}
                            </b>
                        </font>
                    </td>
                    <td>
                        <font size="9px">
                            <b>
                                {{ $costo->nombre  }}
                            </b>
                        </font>
                    </td>
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                    <td align="right">
                        <font size="9px">
                            {{ number_format($totales[$costo->id],2,'.',',') }}
                        </font>
                    </td>
                    @php
                        $nroColumna = $nroMaxColumna - $nroColumna - 1;
                    @endphp
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
            @foreach ($gastos as $gasto)
                @php
                    $nroPuntos = 1;
                    for ($i=0; $i < strlen($gasto->codigo); $i++) { 
                        if($gasto->codigo[$i] == '.'){
                            $nroPuntos++;
                        }
                    }
                    $nroColumna = $nroMaxColumna - $nroPuntos;
                @endphp
                <tr style="border-bottom: 1px solid #ccc;">
                    <td>
                        <font size="9px">
                            <b>
                                {{ $gasto->codigo }}
                            </b>
                        </font>
                    </td>
                    <td>
                        <font size="9px">
                            <b>
                                {{ $gasto->nombre  }}
                            </b>
                        </font>
                    </td>
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                    <td align="right">
                        <font size="9px">
                            {{ number_format($totales[$gasto->id],2,'.',',') }}
                        </font>
                    </td>
                    @php
                        $nroColumna = $nroMaxColumna - $nroColumna - 1;
                    @endphp
                    @for ($i = 0; $i < $nroColumna; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td><font size="9px"><b>TOTAL</b></font></td>
                <td align="right"><font size="9px"><b>{{ number_format($total,2,'.',',') }}</b></font></td>
            </tr>
        </table>
    </body>
</html>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("verdana");
            $pdf->text(40, 765, "{{ date('d/m/Y H:i') }} - {{ Auth()->user()->username }}", $font, 6);
            $pdf->text(530, 765, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 6); 
        ');
    }
</script>
