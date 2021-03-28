<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <style>
        h3,p {
            margin:0;
            padding:0;
        }

        hr {
            margin: 12px 0;
        }

        body {
            padding: 24px;
            font-size:12px;
        }

        table {
            width: 100%;
        }

        .p6 {
            padding:3px;
        }

        #ttd {
            margin-top: 12px;
        }

        .right {
            float: right;
        }

        .t-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <center>
        <img src="{{$logo}}" alt="" width="300px">
    </center>
    <table cellpadding="5" cellspacing="0">
        <tr>
            <td style="vertical-align: top">
                <h3 style="margin:0;padding:0">{{$installation->company_name}}</h3>
            </td>

            <td style="vertical-align: top" class="t-right">
                <h3 style="margin:0;padding:0">SLIP GAJI KARYAWAN</h3>
            </td>
        </tr>
        <tr>
            <td style="vertical-align: top">
                <p style="margin:0;padding:0">{{$installation->address}}</p>
                <p>Telp. {{$installation->phone_number}}</p>
            </td>
            <td style="vertical-align: top" class="t-right">
                <p style="margin:0;padding:0"><b>{{$employeePeriod->period->name}} {{$employeePeriod->period->year}}</b></p>
            </td>
        </tr>
    </table>

    <hr>

    <table cellpadding="5" cellspacing="0">
        <tr>
            <td width="50%">
                Nama
                <br>
                <b>{{$employeePeriod->employee->name}}</b>
            </td>
            <td class="t-right" width="50%">
                Area Kerja
                <br><b> {{$employeePeriod->employee->work_around}}</b>
            </td>
        </tr>

        <tr>
            <td>
                Jabatan
                <br><b>{{$employeePeriod->employee->position->name}}</b>
            </td>
            <td class="t-right">
                N.I.K
                <br><b>{{$employeePeriod->employee->NIK}}</b>
            </td>
        </tr>
    </table>

    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th style="padding:3px">PENDAPATAN</th>
            <th style="padding:3px">POTONGAN</th>
        </tr>
        <tr>
            <td style="vertical-align: top;padding:3px">
                <p class="p6">Gaji Pokok <b class="right">{{number_format($employeePeriod->employee->gaji_pokok)}}</b>
                @foreach($employeePeriod->all_bonus as $key => $value)
                <p class="p6">{{$value->sallary->name}} <b class="right">{{number_format($value->amount)}}</b></p>
                @endforeach
            </td>
            <td style="vertical-align: top;padding:3px">
                @forelse($employeePeriod->all_potongan as $key => $value)
                <p class="p6">{{$value->sallary->name}} <b class="right">{{number_format($value->amount)}}</b></p>
                @empty
                <i>Tidak ada potongan</i>
                @endforelse
            </td>
        </tr>
        <tr>
            <td><p class="p6"><b>GAJI KOTOR</b> <b class="right">{{number_format($employeePeriod->bonus+$employeePeriod->employee->gaji_pokok)}}</b></p></td>
            <td><p class="p6"><b>TOTAL POTONGAN</b> <b class="right">{{number_format($employeePeriod->potongan)}}</b></p></td>
        </tr>
        <tr>
            <td style="border-right: 0px"></td>
            <td style="padding:3px;border-left: 0px">
                <p class="p6"><b>TOTAL PENERIMAAN </b> <b class="right">{{$employeePeriod->sallary_total_format}}</b></p>
            </td>
        </tr>
    </table>

    <div id="ttd" class="right mb-auto">
        <p>Penerima, </p>
        <br><br><br>
        <p>( {{$employeePeriod->employee->name}} )</p>
    </div>

</body>

</html>