<?php

namespace App\Services;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WarningNotification;

class MonitoringService
{
    public function insertMonitoringData()
    {
        $activeSumurPantauIds = DB::table('sumur_pantaus')
            ->where('status', 1)
            ->pluck('id');

        if ($activeSumurPantauIds->isEmpty()) {
            return ['status' => 'error', 'message' => 'No active sumur_pantau records found.'];
        }

        foreach ($activeSumurPantauIds as $idSpantau) {
            $mukaAirTanah = rand(0, 40);
            $totalDissolveSolid = rand(500, 150000);
            $dayaHantarListrik = rand(500, 5000);

            $monitoringId = DB::table('monitorings')->insertGetId([
                'id_spantau' => $idSpantau,
                'signal' => rand(-70, -40),
                'alarm' => 'Normal',
                'power_supply' => rand(0,15),
                'temp' => rand(10, 35),
                'muka_air_tanah' => $mukaAirTanah,
                'total_dissolve_solid' => $totalDissolveSolid,
                'daya_hantar_listrik' => $dayaHantarListrik,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $kondisi = $this->calculateCondition($totalDissolveSolid, $dayaHantarListrik);
            $createdAt = Carbon::now();
            DB::table('kondisis')->insert([
                'id_monitoring' => $monitoringId,
                'kondisi' => $kondisi,
                'updated_by' => 'system',
                'created_at' => $createdAt,
                'updated_at' => Carbon::now(),
            ]);

            $adminUsers = DB::table('users')->where('role', 'admin')->pluck('email')->toArray();

            if ($kondisi == 'Rusak') {
                foreach ($adminUsers as $email) {
                    Mail::to($email)->send(new WarningNotification($idSpantau, $mukaAirTanah, $totalDissolveSolid, $dayaHantarListrik, $kondisi, $createdAt));
                }
            }
        }

        return ['status' => 'success', 'message' => 'Monitoring data inserted successfully.'];
    }

    protected function calculateCondition($totalDissolveSolid, $dayaHantarListrik)
    {
        if ($totalDissolveSolid > 100000 || $dayaHantarListrik > 5000) {
            return 'Rusak';
        } elseif ($totalDissolveSolid > 10000 || $dayaHantarListrik > 1500) {
            return 'Kritis';
        } elseif ($totalDissolveSolid >= 1000 || $dayaHantarListrik >= 1000) {
            return 'Rawan';
        } else {
            return 'Aman';
        }
    }
}
