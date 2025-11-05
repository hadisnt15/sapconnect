<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class OrdrExport implements WithEvents
{
    use Exportable;

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $user = Auth::user();

                // 🔹 Ambil data
                $data = DB::table('ordr_local')
                    ->join('rdr1_local', 'ordr_local.id', '=', 'rdr1_local.OdrId')
                    ->join('ocrd_local', 'ocrd_local.CardCode', '=', 'ordr_local.OdrCrdCode')
                    ->join('oslp_local', 'oslp_local.SlpCode', '=', 'ordr_local.OdrSlpCode')
                    ->join('oitm_local', 'oitm_local.ItemCode', '=', 'rdr1_local.RdrItemCode')
                    ->where('ordr_local.is_checked', 1)
                    ->where('ordr_local.is_deleted', 0)
                    ->where('ordr_local.is_synced', 0)
                    ->orderBy('ordr_local.OdrRefNum')
                    ->orderBy('rdr1_local.id')
                    ->select(
                        'ordr_local.id as HeadId',
                        'ordr_local.OdrRefNum',
                        'ordr_local.OdrDocDate',
                        'ordr_local.OdrCrdCode',
                        'ocrd_local.CardName',
                        'ordr_local.OdrSlpCode',
                        'oslp_local.SlpName',
                        'ordr_local.note',
                        'rdr1_local.RdrItemCode',
                        'oitm_local.FrgnName',
                        'rdr1_local.RdrItemQuantity',
                        'rdr1_local.RdrItemSatuan',
                        'rdr1_local.RdrItemPrice',
                        'rdr1_local.RdrItemDisc',
                        'rdr1_local.RdrItemProfitCenter',
                        'rdr1_local.RdrItemKetHKN',
                        'rdr1_local.RdrItemKetFG'
                    )
                    ->get()
                    ->groupBy('OdrRefNum');

                $row = 1;

                foreach ($data as $refNum => $items) {
                    $head = $items->first();

                    // 🟩 Header Pesanan
                    $sheet->setCellValue("A{$row}", "No Ref Pesanan");
                    $sheet->setCellValue("B{$row}", $head->OdrRefNum);
                    $row++;

                    $sheet->setCellValue("A{$row}", "Tanggal Pesanan");
                    $sheet->setCellValue("B{$row}", \Carbon\Carbon::parse($head->OdrDocDate)->format('d.m.Y'));
                    $row++;

                    $sheet->setCellValue("A{$row}", "Kode Pelanggan");
                    $sheet->setCellValue("B{$row}", $head->OdrCrdCode);
                    $row++;

                    $sheet->setCellValue("A{$row}", "Nama Pelanggan");
                    $sheet->setCellValue("B{$row}", $head->CardName);
                    $row++;

                    $sheet->setCellValue("A{$row}", "Kode Penjual");
                    $sheet->setCellValueExplicit("B{$row}", (string)$head->OdrSlpCode, DataType::TYPE_STRING);
                    $row++;

                    $sheet->setCellValue("A{$row}", "Nama Penjual");
                    $sheet->setCellValue("B{$row}", $head->SlpName);
                    $row++;

                    $sheet->setCellValue("A{$row}", "Catatan");
                    $sheet->setCellValue("B{$row}", $head->note ?? '-');
                    $row += 2;

                    // 🟦 Header Barang
                    $sheet->setCellValue("A{$row}", "No");
                    $sheet->setCellValue("B{$row}", "Kode Barang");
                    $sheet->setCellValue("C{$row}", "Nama Barang");
                    $sheet->setCellValue("D{$row}", "Kuantitas");
                    $sheet->setCellValue("E{$row}", "Satuan");
                    $sheet->setCellValue("F{$row}", "Harga");
                    $sheet->setCellValue("G{$row}", "Diskon");
                    $sheet->setCellValue("H{$row}", "Profit Center");
                    $sheet->setCellValue("I{$row}", "Ket HKN");
                    $sheet->setCellValue("J{$row}", "Ket FG");

                    // Bold header item
                    $sheet->getStyle("A{$row}:J{$row}")->getFont()->setBold(true);
                    $row++;

                    // 🟨 Detail Barang
                    $no = 1;
                    foreach ($items as $item) {
                        $sheet->setCellValue("A{$row}", $no++);
                        $sheet->setCellValueExplicit("B{$row}", (string)$item->RdrItemCode, DataType::TYPE_STRING);
                        $sheet->setCellValue("C{$row}", $item->FrgnName);
                        $sheet->setCellValue("D{$row}", $item->RdrItemQuantity);
                        $sheet->setCellValue("E{$row}", $item->RdrItemSatuan);
                        $sheet->setCellValue("F{$row}", $item->RdrItemPrice);
                        $sheet->setCellValue("G{$row}", $item->RdrItemDisc);
                        $sheet->setCellValue("H{$row}", $item->RdrItemProfitCenter);
                        $sheet->setCellValue("I{$row}", $item->RdrItemKetHKN);
                        $sheet->setCellValue("J{$row}", $item->RdrItemKetFG);
                        $row++;
                    }

                    $row += 3; // Spasi antar pesanan

                    // Update status synced
                    DB::table('ordr_local')
                        ->where('id', $head->HeadId)
                        ->update(['is_synced' => 1]);
                }

                // 🧾 Auto width
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
