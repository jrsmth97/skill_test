<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Companies Data</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard-assets') }}/images/favicon.png">
    <style media="all">
        [contenteditable="true"]:hover {
            outline: lightblue auto 5px;
            outline: -webkit-focus-ring-color auto 5px;
        }

        body {
            background: #f1f1f1;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .companies {
            padding: 0;
            font-family: "Poppins", sans-serif;
            font-weight: 100;
            width: 95%;
            max-width: 1000px;
            margin: 2% auto;
            box-sizing: border-box;
            padding: 20px;
            border-radius: 5px;
            background: #fff;
            min-height: 800px;
        }

        .header {
            display: flex;
            width: 100%;
            border-bottom: 2px solid #eee;
            align-items: center;
        }

        .header--companies {
            order: 2;
            text-align: right;
            width: 40%;
            margin-right: -150%;
            padding: 0;
        }

        .companies--desc {
            margin-right: -150%;
        }

        .date,
        .sales--number {
            font-size: 12px;
            color: #494949;
            margin-right: -150%;
        }

        .companies--total {
            margin-top: 25px;
            margin-bottom: 4px;
            margin-right: -150%;
        }

        .header--logo {
            order: 1;
            font-size: 32px;
            width: 60%;
            font-weight: 900;
        }

        .logo--address {
            font-size: 12px;
            padding: 4px;
        }

        .description {
            margin-top: auto;
            text-align: justify;
        }

        .description h5 {
            margin-top: -10%;
        }

        .description p {
            margin-top: -5%;
        }

        .items--table {
            width: 100%;
            padding: 10px;
        }

        .items--table thead {
            background: #ddd;
            color: #111;
            text-align: center;
            font-weight: 800;
        }

        .items--table tbody {
            text-align: center;
        }

        .items--table .total-price {
            border: 2px solid #444;
            padding-top: 4px;
            font-weight: 800;
            background: #80ff80;
        }
    </style>
</head>


<body>
    <article class="companies">
        <header class="header">
            <h2 class="header--companies">
                <div class="companies--desc" contenteditable="true">
                    Companies Data
                </div>
                <div class="date" contenteditable="true">
                    {{ date('d M, Y') }}
                </div>
                <div class="companies--total" contenteditable="true">
                    Companies Total : {{ count($companies) }}
                </div>
            </h2>
        </header>
        <section class="line-items">
            <table class="items--table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>Logo</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($companies as $company)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $company['name'] }}</td>
                        <td>{{ $company['email'] }}</td>
                        <td>{{ $company['website'] }}</td>
                        <td><img src="{{ $company['logo'] }}" width="15%" /></td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </section>
    </article>

</body>

</html>