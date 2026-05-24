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
            ->unique();
        $roomsToRelease = Tenant::whereDate('end_date', '<=', $today)
            ->pluck('room_id')
            ->unique();
        if ($roomsToOccupy->isNotEmpty()) {
            Room::whereIn('id', $roomsToOccupy)
                ->where('available', 1)
                ->update(['available' => 0]);

            $this->info('Status kamar berhasil di-ubah menjadi TIDAK TERSEDIA (0) untuk tenant aktif.');
        }
        $actualRoomsToRelease = $roomsToRelease->diff($roomsToOccupy);

        if ($actualRoomsToRelease->isNotEmpty()) {
            Room::whereIn('id', $actualRoomsToRelease)
                ->where('available', 0)
                ->update(['available' => 1]);

            $this->info('Status kamar berhasil di-ubah menjadi TERSEDIA (1) karena masa sewa habis.');
        }

        $this->info('Proses update status kamar berdasarkan data tenant selesai.');
    }
}
