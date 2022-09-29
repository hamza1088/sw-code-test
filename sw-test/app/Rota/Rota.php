<?php

namespace App\Rota;

use Illuminate\Support\Collection;
use App\Models\Rota as RotaModel;
use App\Models\Shift;
use App\Models\ShiftBreak;

class Rota
{
    public function createRota(): Collection
    {
        $rotaId = RotaModel::where('week_commence_date', '2022-09-19')->get(['id', 'week_commence_date']);
        if (!$rotaId->isEmpty()) {
            $shifts = Shift::where(
                'rota_id',
                $rotaId->toArray()[0]['id']
            )
                ->get();
            $shiftBreaks = [];
            foreach ($shifts->toArray() as $shift) {
                $break = ShiftBreak::where(
                    'shift_id',
                    $shift['id']
                )
                    ->get(['id', 'shift_id','start_time','end_time']);
                if (!$break->isEmpty()) {
                    $shiftBreaks []= $break;
                }
            }
            $rota = collect();
            $rota->put('shifts', $shifts);
            $rota->put('breaks', ($shiftBreaks));
            return $rota;
        } else {
            return collect();
        }
        ;
    }
}
