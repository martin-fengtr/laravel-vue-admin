<?php

namespace App\Imports;

use App\Models\Badge;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;

class BadgeImport implements ToModel, WithUpserts
{
    /**
     * @param array $row
     *
     * @return Badge|null
     */
    public function model(array $row)
    {
        if (!isset($row[0]) || !isset($row[1])) {
            return null;
        }

        return new Badge([
            'uuid' => $row[0],
            'hex' => $row[1],
        ]);
    }

    /**
     * * @return string|array
     */
    public function uniqueBy()
    {
        return ['uuid', 'hex'];
    }
}
