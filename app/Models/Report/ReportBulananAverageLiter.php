<?php

namespace App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class ReportBulananAverageLiter extends Model
{
    protected $table = 'report_bulanan_average_liter';
    protected $primaryKey = 'MAINKEY';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['MAINKEY', 'KODECUSTOMER', 'NAMACUSTOMER', 'KODENAMACUSTOMER', 'SEGMENT', 'NO', 'TAHUN', 'BULAN', 'TAHUNBULAN', 'NAMATAHUNBULAN', 'LITER', 'STATUSORDER', 'KOTA', 'PROVINSI', 'KODESALES', 'NAMASALES', 'ROWNUM', 'DIVISI'];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false, fn ($query, $search) => $query
                ->where('NAMACUSTOMER', 'like', '%' . $search . '%')
                ->orWhere('NAMASALES', 'like', '%' . $search . '%')
        );
    }
}
