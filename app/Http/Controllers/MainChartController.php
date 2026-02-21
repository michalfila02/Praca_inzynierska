<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesurments; 
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Carbon\Carbon;

class MainChartController extends Controller
{
    public function index(Request $request)
    {
        $RANGES = [                                                 //podział dat
            '1 day' => '1 Day',
            '1 week' => '1 Week',
            '1 month' => '1 Month',
            '3 months' => '3 Months',
            '6 months' => '6 Months',
            '1 year' => '1 Year',
        ];

        $range = $request->query('range', '1 month'); 

        $endDate = Carbon::now();
        switch ($range) {
            case '1 day':
                $startDate = $endDate->copy()->subDay();
                $time = "hour";
                break;
            case '1 week':
                default:
                $startDate = $endDate->copy()->subWeek();
                $time = "day";
                break;
            case '1 month':
                $startDate = $endDate->copy()->subMonth();
                $time = "day";
                break;
            case '3 months':
                $startDate = $endDate->copy()->subMonths(3);
                $time = "month";
                break;
            case '6 months':
                $startDate = $endDate->copy()->subMonths(6);
                $time = "month";
                break;
            case '1 year':
                $startDate = $endDate->copy()->subYear();
                $time = "month";
                break;
        }

        $data = Mesurments::whereBetween('Date', [$startDate, $endDate])                        
                ->orderBy('Date', 'asc')
                ->get();

                $labels = $data->pluck('Date')->map(function($date) {
                    return Carbon::parse($date)->timestamp * 1000;  
                })->toArray();
                
                $temp = $data->pluck('Temperature')->toArray();
                $higr = $data->pluck('Pressure')->toArray();
                $wet = $data->pluck('Humidity')->toArray();
                $chunkSize = 14 * 24 * 60 * 60; 


        $chunkStartIndex = 0;
        foreach ($data as $datum) {
            $baseTimestamp = Carbon::parse($datum['Date'])->timestamp * 1000;
            $baseTemperature = $datum['Temperature'];
            $baseHumidity = $datum['Humidity'];
            $basePressure = $datum['Pressure'];
            $chartTemp[] = ['x' => $baseTimestamp, 'y' => $baseTemperature];
            $chartHum[] = ['x' => $baseTimestamp, 'y' => $baseHumidity];
            if($basePressure != 0)$chartPres[] = ['x' => $baseTimestamp, 'y' => $basePressure];
        }
        if(!isset($chartTemp))
        {
            $chartTemp[] = null;
            $chartHum[] = null;
            $chartPres[] = null;
        }
        

        $chart1 = Chartjs::build()
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 200, 'height' => 150])
            ->labels($labels)
            ->datasets([[
                "label" => "Temperatura",
                'backgroundColor' => "rgba(538, 185, 154, 0.31)",
                'borderColor' => "rgba(238, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => $chartTemp,  
                "fill" => false,
            ]])
            ->options([
                'responsive' => true,
                'parsing' => false,
                'scales' => [
                    'x' => [
                        'type' => 'time',  
                        'time' => [
                            'unit' => $time, 
                            'min' => $startDate->format("Y-m-d"),
                        ],
                        'ticks' => [
                            'maxRotation' => 0,
                            'autoSkip' => true,  
                            'autoSkipPadding' => 10,
                        ],
                    ],
                ],
            ]);
        

        $chart2 = Chartjs::build()
            ->name('a')
            ->type('line')
            ->size(['width' => 200, 'height' => 150])
            ->labels($labels)
            ->datasets([[
                "label" => "Wilgotność",
                'backgroundColor' => "rgba(538, 185, 154, 0.31)",
                'borderColor' => "rgba(238, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => $chartHum,  
                "fill" => false,
            ]])
            ->options([
                'responsive' => true, 
                'parsing' => false,
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => $time, 
                            'min' => $startDate->format("Y-m-d"),
                        ],
                        'ticks' => [
                            'maxRotation' => 0,
                            'autoSkip' => true,
                            'autoSkipPadding' => 10,
                        ],
                    ],
                    'y' => [
                        'beginAtZero' => true,
                    ],
                ],
                
            ]);
        

        $chart3 = Chartjs::build()
            ->name('b')
            ->type('line')
            ->size(['width' => 200, 'height' => 150])
            ->labels($labels)
            ->datasets([[
                "label" => "Ciśnienie",
                'backgroundColor' => "rgba(538, 185, 154, 0.31)",
                'borderColor' => "rgba(238, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                "data" => $chartPres,  
                "fill" => false,
            ]])
            ->options([
                'responsive' => true, 
                'parsing' => false,
                'scales' => [
                    'x' => [
                        'type' => 'time',
                        'time' => [
                            'unit' => $time, 
                            'min' => $startDate->format("Y-m-d"),
                        ],
                        'ticks' => [
                            'maxRotation' => 0,
                            'autoSkip' => true,
                            'autoSkipPadding' => 10,
                        ],
                    ],
                ],
                
            ]);
        
        return view('welcome', compact('chart1', 'chart2', 'chart3', 'data', 'range', 'RANGES'));
        
    }
}