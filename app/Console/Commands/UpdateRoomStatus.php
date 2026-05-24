<?php

namespace App\Console\Commands;

use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Carbon\Carbon;

class UpdateRoomStatus extends Command
{
    protected $signature = 'room:update-status';
    protected $description = 'Update room availability status based on tenant check-in and checkout dates';

    public function handle()
    {
        $today = Carbon::today()->toDateString();
        $lateLimitDate = Carbon::today()->subDays(7)->toDateString();

        $roomsToOccupy = Tenant::whereDate('start_date', $today)
            ->pluck('room_id');
        $roomsToRelease = Tenant::whereDate('end_date', $lateLimitDate)
            ->pluck('room_id');

        if ($roomsToOccupy->isNotEmpty()) {
            Room::whereIn('id', $roomsToOccupy)
                ->where('available', 1)
                ->update(['available' => 0]);

            $this->info('Status kamar berhasil di-ubah menjadi TIDAK TERSEDIA (0) untuk tenant baru hari ini.');
        }

        if ($roomsToRelease->isNotEmpty()) {
            Room::whereIn('id', $roomsToRelease)
                ->where('available', 0)
                ->update(['available' => 1]);

            $this->info('Status kamar berhasil di-ubah menjadi TERSEDIA (1) setelah batas telat 7 hari.');
        }

        $this->info('Proses update status kamar berdasarkan data tenant selesai.');
    }
}
