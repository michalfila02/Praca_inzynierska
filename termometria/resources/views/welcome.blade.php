<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termometria</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <br>
    <h2 class="text-center">Termometria</h2>
    <br>

    

    <div class="row align-items-start">
            <div class="col-4">
                {!! $chart1->render() !!}
            </div>
            <div class="col-4">
                {!! $chart2->render() !!}
            </div>
            <div class="col-4">
                {!! $chart3->render() !!}
            </div>
    </div>
    <br>
    <br>
    <div class="container my-5">
        <button class="btn btn-primary" onclick="fetch('{{ url('/esp-decider/snowball_1') }}')">
        Prześlij pomiar
        </button>

        <form method="GET" action="{{ url('/') }}" class="mb-5">
            <div class="input-group">
                <select name="range" class="form-select" onchange="this.form.submit()">
                    @foreach ($RANGES as $key => $label)
                        <option value="{{ $key }}" {{ $range === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Temperatura</th>
                        <th>Wilgotność</th>
                        <th>Ciśnienie</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row["Date"] }}</td>
                            <td>{{ $row["Temperature"] }}</td>
                            <td>{{ $row["Pressure"] }}</td>
                            <td>{{ $row["Humidity"] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@latest"></script>

</body>
</html>