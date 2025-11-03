<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdrCombinedExport implements FromCollection, WithHeadings, WithStyles
{
    protected $finalData = [];
    protected $exportedIds = [];

    public function collection()
    {
        $user = Auth::user();

        // 🔹 Ambil divisi & cabang user
        $userDivisions = DB::table('user_division')
            ->join('division', 'user_division.div_id', '=', 'division.id')
            ->where('user_division.user_id', $user->id)
            ->pluck('division.div_name')
            ->toArray();

        $userBranches = DB::table('user_branch')
            ->join('branch', 'user_branch.branch_id', '=', 'branch.id')
            ->where('user_branch.user_id', $user->id)
            ->pluck('branch.branch_name')
            ->toArray();

        // 🔹 Ambil order head + row yang sesuai
        $data = DB::table('rdr1_local')
            ->join('ordr_local', 'ordr_local.id', '=', 'rdr1_local.OdrId')
            ->where('ordr_local.is_synced', 0)
            ->where('ordr_local.is_checked', 1)
            ->where('ordr_local.is_deleted', 0)
            ->whereIn('ordr_local.branch', $userBranches)
            ->whereIn('rdr1_local.RdrItemProfitCenter', $userDivisions)
            ->select(
                'ordr_local.id as HeadId',
                'ordr_local.OdrRefNum',
                'ordr_local.OdrDocDate',
                'ordr_local.note',
                'rdr1_local.id as RowId',
                'rdr1_local.RdrItemCode',
                'rdr1_local.RdrItemQuantity',
                'rdr1_local.RdrItemSatuan',
                'rdr1_local.RdrItemPrice',
                'rdr1_local.RdrItemDisc',
                'rdr1_local.RdrItemProfitCenter',
                'rdr1_local.RdrItemKetHKN',
                'rdr1_local.RdrItemKetFG',
                'ordr_local.OdrSlpCode',
                'ordr_local.OdrCrdCode'
            )
            ->orderBy('ordr_local.OdrRefNum')
            ->orderBy('rdr1_local.id')
            ->get();

        if ($data->isEmpty()) {
            return collect([]);
        }

        // 🔹 Simpan ID order yang akan diupdate
        $this->exportedIds = $data->pluck('HeadId')->unique()->toArray();

        // 🔹 Tambahkan baris kosong setiap kali OdrRefNum berubah
        $previousRef = null;

        foreach ($data as $row) {
            if ($previousRef !== null && $previousRef !== $row->OdrRefNum) {
                $this->finalData[] = (object)array_fill_keys([
                    'OdrRefNum', 'OdrDocDate', 'Note', 'RowId', 'RdrItemCode', 'RdrItemQuantity',
                    'RdrItemSatuan', 'RdrItemPrice', 'RdrItemDisc', 'RdrItemProfitCenter',
                    'RdrItemKetHKN', 'RdrItemKetFG', 'OdrSlpCode', 'OdrCrdCode'
                ], null);
            }

            $this->finalData[] = $row;
            $previousRef = $row->OdrRefNum;
        }

        // 🔹 Update status synced
        DB::table('ordr_local')
            ->whereIn('id', $this->exportedIds)
            ->update(['is_synced' => 1]);

        return collect($this->finalData);
    }

    public function headings(): array
    {
        return [
            'OdrRefNum',
            'OdrDocDate',
            'Note',
            'RowId',
            'RdrItemCode',
            'RdrItemQuantity',
            'RdrItemSatuan',
            'RdrItemPrice',
            'RdrItemDisc',
            'RdrItemProfitCenter',
            'RdrItemKetHKN',
            'RdrItemKetFG',
            'OdrSlpCode',
            'OdrCrdCode'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Auto width
        foreach (range('A', 'N') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Header bold dan warna abu
        $sheet->getStyle('A1:N1')->getFont()->setBold(true);
        $sheet->getStyle('A1:N1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFD9D9D9');

        // Border semua sel
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        return [];
    }
}
