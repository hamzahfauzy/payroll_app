<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        th,
        td {
            padding: 6px;
        }

        .p6 {
            padding: 6px;
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

    <table class="table2">
        <tr>
            <td>
                <h3>PT {{$installation->company_name}}</h3>
            </td>

            <td class="t-right">
                <h3>SLIP GAJI KARYAWAN</h3>
            </td>
        </tr>

        <tr>
            <td>
                <p>{{$installation->address}}</p>
            </td>
            <td class="t-right">
                <p><b>{{$employeePeriod->period->name}} {{$employeePeriod->period->year}}</b></p>
            </td>
        </tr>

        <tr>
            <td>
                <p>Telp. {{$installation->phone_number}}</p>
            </td>
            <td></td>
        </tr>
    </table>

    <hr>

    <table>
        <tr>
            <td>
                <p>Nama : <b> {{$user->employee->name}}</b></p>
            </td>

            <td class="t-right">
                <p>Area Kerja : <b> {{$user->employee->work_around}}</b></p>
            </td>
        </tr>

        <tr>
            <td>
                <p>Jabatan : <b>{{$user->employee->position->name}}</b></p>
            </td>
            <td class="t-right">
                <p>N.I.K : <b>{{$user->employee->NIK}}</b></p>
            </td>
        </tr>
    </table>

    <hr>

    <table border="1">
        <tr>
            <th>PENDAPATAN</th>
            <th>POTONGAN</th>
        </tr>
        <tr>
            <td>
                @foreach($data['pendapatan'] as $key => $value)
                <p class="p6">{{$key}} <b class="right">Rp.{{number_format($value)}}</b></p>
                @endforeach
            </td>
            <td>

                @foreach($data['potongan'] as $key => $value)
                <p class="p6">{{$key}} <b class="right">Rp.{{number_format($value)}}</b></p>
                @endforeach
            </td>
        </tr>
        <tr>
            <th>Total Penerimaan</th>
            <th>Rp.{{number_format($total)}}</th>
        </tr>
    </table>

    <hr>

    <div id="ttd" class="right mb-auto">
        <p>Penerima, </p>
        <br><br><br>
        <p>( {{$user->employee->name}} )</p>
    </div>

</body>

</html>