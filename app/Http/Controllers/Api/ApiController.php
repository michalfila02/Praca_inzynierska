<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Mesurments; 
use Illuminate\Support\Facades\Cache;


class ApiController extends Controller
{
    public function decider(string $device)
    {
        $devices = Cache::get('esp_decider', []);
        if (!in_array($device, $devices)) {
        $devices[] = $device;
        }
        Cache::put('esp_decider', $devices);
    return 'OK';
    }
    
    public function speaker(Request $request)
    {
        return response(
            Cache::get('esp_decider', ''),
            200
        )->header('Content-Type', 'text/plain');
    }
    
    public function reciver(Request $request): JsonResponse
    {
 
        $body = $request->getContent();
        $lines = explode("\n", trim($body));
        $deviceId = $lines[0] ?? null;
        $devices = Cache::get('esp_decider', []);
        
        if (($key = array_search($deviceId, $devices)) !== false) {
        unset($devices[$key]);
        Cache::put('esp_decider', array_values($devices));
        }

    $data = [
        'Device_ID'   => $lines[0] ?? null,
        'Temperature' => isset($lines[1]) ? floatval($lines[1]) : null,
        'Pressure'    => isset($lines[2]) ? floatval($lines[2]) : null,
        'Humidity'    => isset($lines[3]) ? floatval($lines[3]) : null,
        'Date'        => isset($lines[4]) ? date('Y-m-d H:i:s', intval($lines[4])) : null,
    ];

    Mesurments::create($data);
        
    return response()->json([
            'status' => 'ok'
        ]);
    }
}