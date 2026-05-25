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

        $roomsToOccupy = Tenant::whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>', $today)
            ->pluck('room_id')
            ->unique()
            ->toArray();

        if (!empty($roomsToOccupy)) {
            Room::whereIn('id', $roomsToOccupy)
                ->where('available', 1)
                ->update(['available' => 0]);

            $this->info('Status kamar di-ubah menjadi TIDAK TERSEDIA (0) untuk tenant aktif. ID Kamar: ');
        }

        $queryRelease = Room::where('available', 0);
        if (!empty($roomsToOccupy)) {
            $queryRelease->whereNotIn('id', $roomsToOccupy);
        }

        $roomsReleasedCount = $queryRelease->update(['available' => 1]);
        if ($roomsReleasedCount > 0) {
            $this->info("Berhasil merilis $roomsReleasedCount kamar menjadi TERSEDIA (1) karena berada di luar masa sewa.");
        } else {
            $this->info('Tidak ada kamar di luar masa sewa yang perlu dirilis hari ini.');
        }

        $this->info('Proses update status kamar selesai.');
    }
}
