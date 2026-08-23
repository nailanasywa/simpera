<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with([
            'pasien',
            'kunjungan.poli',
            'permintaan.user.poli'
        ])->where('status_peminjaman', 'selesai');

        // filter jenis
        if ($this->request->filled('jenis_peminjaman')) {
            $query->where('jenis_peminjaman', $this->request->jenis_peminjaman);
        }

        // filter poli
        if ($this->request->filled('poli_id')) {
            $query->where(function ($q) {
                $q->whereHas('kunjungan', function ($sub) {
                    $sub->where('poli_id', $this->request->poli_id);
                })->orWhereHas('permintaan.user', function ($sub) {
                    $sub->where('poli_id', $this->request->poli_id);
                });
            });
        }

        // filter waktu
        if ($this->request->filled('filter')) {
            switch ($this->request->filter) {
                case 'hari_ini':
                    $query->whereDate('tanggal_pinjam', today());
                    break;

                case '7_hari':
                    $query->whereBetween('tanggal_pinjam', [
                        now()->subDay(6)->startDay(),
                        now()->endOfDay()
                    ]);
                    break;

                case 'bulan':
                    if ($this->request->filled('bulan')) {
                        $query->whereMonth('tanggal_pinjam', $this->request->bulan);
                    }
                    break;

                case 'tanggal':
                    if ($this->request->filled('tanggal_awal') && $this->request->filled('tanggal_akhir')) {
                        $query->whereBetween('tanggal_pinjam', [
                            $this->request->tanggal_awal . ' 00:00:00',
                            $this->request->tanggal_akhir . ' 23:59:59'
                        ]);
                    }
                    break;
            }
        }

        return $query->get()->map(function ($item) {
            $umur = '';
            if ($item->pasien?->tanggal_lahir) {
                $umur = \Carbon\Carbon::parse($item->pasien->tanggal_lahir)->age;
            }

            return [
                // data pasien
                $item->pasien?->no_rm,
                $item->pasien?->nama_pasien,
                $item->pasien?->tanggal_lahir ? \Carbon\Carbon::parse($item->pasien->tanggal_lahir)->format('d-m-Y') : '',
                $umur,
                $item->pasien?->nama_kk,
                $item->pasien?->alamat,
                // Data Kunjungan
                $item->kunjungan?->poli?->nama_poli ?? $item->permintaan?->user?->poli?->nama_poli,
                $item->kunjungan?->jenis_kunjungan ? ucfirst($item->kunjungan->jenis_kunjungan) : '',
                $item->kunjungan?->kepesertaan ? strtoupper($item->kunjungan->kepesertaan) : '',
                // data peminjaman
                ucfirst(str_replace('_', ' ', $item->jenis_peminjaman)),
                $item->tanggal_pinjam ? $item->tanggal_pinjam->format('d-m-Y H:i') : '',
                $item->tanggal_kembali ? $item->tanggal_kembali->format('d-m-Y H:i') : '',
                \Carbon\Carbon::parse($item->tanggal_kembali)
                    ->gt(\Carbon\Carbon::parse($item->tanggal_jatuh_tempo))
                    ? 'Terlambat'
                    : 'Tepat Waktu',
            ];
        });
    }

    public function headings(): array
    {
        return [
            // data pasien
            'No. RM',
            'Nama Pasien',
            'Tanggal Lahir',
            'Umur (Tahun)',
            'Nama KK',
            'Alamat',
            // data kunjungan
            'Poli',
            'Jenis Kunjungan',
            'Kepsertaan',
            // Data peminjaman
            'Jenis Peminjaman',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status Pengembalian',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // return [
        //     1 => [
        //         'font' => [
        //             'bold'  => true,
        //             'size'  => 12,
        //         ],
        //     ],
        // ];
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => '0D6EFD'
                ]
            ],
        ]);

        return [];
    }
}
