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
        <table width="100%">
            <tr>
                <td align="center" valign="bottom">
                    <font size="13px">
                        <b>
                            LIBRO MAYOR POR CUENTA - GENERAL
                        </b>
                    </font>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td>
                    <font size="9px">
                        <b>Cuenta:</b>&nbsp;
                    </font>
                </td>
                <td colspan="8">
                    <font size="9px">
                        {{ $plan_cuenta->codigo . ' ' . $plan_cuenta->nombre }}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="9px">
                        <b>Desde:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        {{ $fecha_i }}
                    </font>
                </td>
                <td>
                    <font size="9px">
                        <b>Saldo Inicial:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        Bs. {{ number_format($saldo,2,'.',',') }}
                    </font>
                </td>
                <td>
                    <font size="9px">
                        <b>Total Debe:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        Bs. {{ number_format($total_debe,2,'.',',') }}
                    </font>
                </td>
            </tr>
            <tr>
                <td>
                    <font size="9px">
                        <b>Hasta:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        {{ $fecha_f }}
                    </font>
                </td>
                <td>
                    <font size="9px">
                        <b>Saldo Final:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        Bs. {{ number_format($saldo_final,2,'.',',') }}
                    </font>
                </td>
                <td>
                    <font size="9px">
                        <b>Total Haber:</b>&nbsp;
                    </font>
                </td>
                <td colspan="2">
                    <font size="9px">
                        Bs. {{ number_format($total_haber,2,'.',',') }}
                    </font>
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" class="table">
            <tr style="border-bottom: 1px solid #000000;">
                <td align="center"><font size="9px"><b>FECHA</b></font></td>
                <td align="center"><font size="9px"><b>COMPROBANTE</b></font></td>
                <td align="center"><font size="9px"><b>PROYECTO</b></font></td>
                <td align="center"><font size="9px"><b>AUXILIAR</b></font></td>
                <td align="center"><font size="9px"><b>CHEQUE</b></font></td>
                <td align="center"><font size="9px"><b>GLOSA</b></font></td>
                <td align="center"><font size="9px"><b>DEBE</b></font></td>
                <td align="center"><font size="9px"><b>HABER</b></font></td>
                <td align="center"><font size="9px"><b>SALDO</b></font></td>
            </tr>
            @foreach ($comprobantes as $datos)
                <tr style="border-bottom: 1px solid #ccc;">
                    <td align="center">
                        <font size="9px">
                            {{ $datos->fecha }}
                        </font>
                    </td>
                    <td align="center">
                        <font size="9px">
                            {{ $datos->nro_comprobante }}&nbsp;<b>{{ $datos->estado_abreviado}}</b>
                        </font>
                    </td>
                    <td align="center">
                        <font size="9px">
                            {{ $datos->proyecto }}
                        </font>
                    </td>
                    <td align="center">
                        <font size="9px">
                            {{ $datos->auxiliar }}
                        </font>
                    </td>
                    <td align="center">
                        <font size="9px">
                            {{ $datos->nro_cheque }}
                        </font>
                    </td>
                    <td align="left">
                        <font size="9px">
                            {{ $datos->glosa }}
                        </font>
                    </td>
                    <td align="right">
                        <font size="9px">
                            {{ number_format($datos->debe,2,'.',',')  }}
                        </font>
                    </td>
                    <td align="right">
                        <font size="9px">
                            {{ number_format($datos->haber,2,'.',',')  }}
                        </font>
                    </td>
                    @php
                        if($datos->debe > 0){
                            $saldo += $datos->debe;
                        }else{
                            $saldo -= $datos->haber;
                        }
                    @endphp
                    <td align="right">
                        <font size="9px">
                            {{ number_format($saldo,2,'.',',')  }}
                        </font>
                    </td>
                </tr>
            @endforeach
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
