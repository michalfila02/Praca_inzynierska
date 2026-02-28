<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termometria</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="overflow-x: hidden; background-image: linear-gradient(180deg, rgb(213, 245, 245) 0%, rgb(184, 149, 241) 25%, rgb(206, 167, 218) 50%, rgb(184, 149, 241) 75%, rgb(213, 245, 245) 100%); background-size: 100% 300vh; background-repeat: repeat-y;">
    <br>
    <h2 class="text-center">Termometria</h2>
    <br>

<div class="container my-3">
    <div id="carouselIndicators" class="carousel slide" style="background: white; box-shadow: 0 1px 2px black;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div style="height: 500px;">
                    {!! $chart1->render() !!}
                </div>
            </div>
            <div class="carousel-item">
                <div style="height: 500px;">
                    {!! $chart2->render() !!}
                </div>
            </div>
            <div class="carousel-item">
                <div style="height: 500px;">
                    {!! $chart3->render() !!}
                </div>
            </div>
        </div>
        <!--
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        -->
        <div class="carousel-indicators" style="position: static; display: flex; justify-content: center; margin: 8px 0 0 0;">
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" style="background-color: black;"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2" style="background-color: black;"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3" style="background-color: black;"></button>
        </div>
    </div>
</div>

    <div class="container my-3">
        <div class="row justify-content-start">
        <button class="btn btn-primary col-2 row-1" onclick="fetch('{{ url('/esp-decider/snowball_1') }}')">
        Prześlij pomiar
        </button> 
        <form method="GET" action="{{ url('/') }}" class="col-2">
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
    </div>
    </div>
    </div>
    <div class="container my-3">
        <div class="table-responsive-md">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Temperatura</th>
                        <th>Ciśnienie</th>
                        <th>Wilgotność</th>
                        <th>Urządzenie</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row["Date"] }}</td>
                            <td>{{ $row["Temperature"] }}</td>
                            <td>{{ $row["Pressure"] }}</td>
                            <td>{{ $row["Humidity"] }}</td>
                            <td>{{ $row["Device_ID"] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.5.0/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>