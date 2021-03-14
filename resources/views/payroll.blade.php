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
        }

        table {
            width: 100%;
        }

        .p6 {
            padding:6px;
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
    <img src="{{$logo}}" alt="" height="80px" width="100%" style="object-fit: contain;object-position: center">
    <table cellpadding="5" cellspacing="0">
        <tr>
            <td style="vertical-align: top">
                <h2 style="margin:0;padding:0">{{$installation->company_name}}</h2>
                <p style="margin:0;padding:0">{{$installation->address}}</p>
                <p>Telp. {{$installation->phone_number}}</p>
            </td>

            <td style="vertical-align: top" class="t-right">
                <h2 style="margin:0;padding:0">SLIP GAJI KARYAWAN</h2>
                <p style="margin:0;padding:0"><b>{{$employeePeriod->period->name}} {{$employeePeriod->period->year}}</b></p>
            </td>
        </tr>
    </table>

    <hr>

    <table cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <td width="50px">
                Nama
            </td>
            <td>
                : <b>{{$user->employee->name}}</b>
            </td>
            <td class="t-right" width="100px">
                Area Kerja
            </td>
            <td width="120px">
                : <b> {{$user->employee->work_around}}</b>
            </td>
        </tr>

        <tr>
            <td>
                Jabatan
            </td>
            <td>
                : <b>{{$user->employee->position->name}}</b>
            </td>
            <td class="t-right">
                N.I.K
            </td>
            <td>
                : <b>{{$user->employee->NIK}}</b>
            </td>
        </tr>
    </table>

    <hr>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th style="padding:6px">PENDAPATAN</th>
            <th style="padding:6px">POTONGAN</th>
        </tr>
        <tr>
            <td style="vertical-align: top;padding:6px">
                <?php $gaji_kotor = 0; ?>
                @foreach($data['pendapatan'] as $key => $value)
                <?php $gaji_kotor+=$value ?>
                <p class="p6">{{$key}} <b class="right">{{number_format($value)}}</b></p>
                @endforeach
            </td>
            <td style="vertical-align: top;padding:6px">
                <?php $potongan = 0; ?>
                @foreach($data['potongan'] as $key => $value)
                <?php $potongan+=$value ?>
                <p class="p6">{{$key}} <b class="right">{{number_format($value)}}</b></p>
                @endforeach
            </td>
        </tr>
        <tr>
            <td><p class="p6"><b>GAJI KOTOR</b> <b class="right">{{number_format($gaji_kotor)}}</b></p></td>
            <td><p class="p6"><b>TOTAL POTONGAN</b> <b class="right">{{number_format($potongan)}}</b></p></td>
        </tr>
        <tr>
            <td style="border-right: 0px"></td>
            <td style="padding:6px;border-left: 0px">
                <p class="p6"><b>TOTAL PENERIMAAN </b> <b class="right">Rp. {{number_format($total)}}</b></p>
            </td>
        </tr>
    </table>

    <div id="ttd" class="right mb-auto">
        <p>Penerima, </p>
        <br><br><br>
        <p>( {{$user->employee->name}} )</p>
    </div>

</body>

</html>