<?php

namespace Database\Seeders;

use App\Mail\WarningNotification;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Auth;

class MonitoringSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $startDate = Date::create(2024, 7, 20); // Mulai dari tanggal 20 Juli 2024
        $endDate = $startDate->copy()->addDays(3); // Sampai 3 hari ke depan

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $this->insertDailyMonitoringData($startDate);
            $startDate->addDay(); // Pindah ke hari berikutnya
        }
    }

    private function insertDailyMonitoringData($date)
{
    $spantauIds = DB::table('sumur_pantaus')->pluck('id')->toArray(); // Get all IDs from sumur_pantau

    // Get all admin users
    $adminUsers = DB::table('users')->where('role', 'admin')->pluck('email')->toArray();

    for ($hour = 0; $hour < 24; $hour++) {
        // Generate random monitoring data
        $randomSpantauId = $spantauIds[array_rand($spantauIds)];
        $totalDissolveSolid = $this->generateRandomValue(500, 150000);
        $dayaHantarListrik = $this->generateRandomValue(500, 5000);
        $signal = $this->generateRandomValue(1, 100);
        $ps = $this->generateRandomValue(1, 100);
        $mukaAirTanah = rand(0, 100); // Generate muka air tanah

        // Insert monitoring data
        $monitoringId = DB::table('monitorings')->insertGetId([
            'id_spantau' => $randomSpantauId,
            'signal' => $signal,
            'alarm' => Str::random(10),
            'power_supply' => $ps,
            'temp' => rand(20, 35),
            'muka_air_tanah' => $mukaAirTanah,
            'total_dissolve_solid' => $totalDissolveSolid,
            'daya_hantar_listrik' => $dayaHantarListrik,
            'created_at' => $date->copy()->setTime($hour, 0),
            'updated_at' => now(),
        ]);

        // Determine kondisi based on the criteria
        $kondisi = $this->determineKondisi($totalDissolveSolid, $dayaHantarListrik);

        // Insert kondisi data
        DB::table('kondisis')->insert([
            'id_monitoring' => $monitoringId,
            'kondisi' => $kondisi,
            'updated_by' => null,
            'created_at' => $date->copy()->setTime($hour, 0),
            'updated_at' => now(),
        ]);

        // Send email if kondisi is 'Rusak'
        if ($kondisi === 'Rusak') {
            foreach ($adminUsers as $email) {
                Mail::to($email)->send(new WarningNotification($mukaAirTanah, $totalDissolveSolid, $dayaHantarListrik, $kondisi));
            }
        }
    }
}

private function generateRandomValue($min, $max)
{
    return rand($min, $max);
}

private function determineKondisi($tds, $dhl)
{
    if ($tds < 1000 || $dhl < 1000) {
        return 'Aman';
    } elseif ($tds >= 1000 && $tds <= 10000 || $dhl >= 1000 && $dhl <= 1500) {
        return 'Rawan';
    } elseif ($tds > 10000 && $tds <= 100000 || $dhl > 1500 && $dhl <= 5000) {
        return 'Kritis';
    } else {
        return 'Rusak';
    }
}

}
