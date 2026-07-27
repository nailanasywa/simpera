<?php

namespace App\Imports;

use App\Models\Pasien;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class PasienImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsEmptyRows
{
    use Importable, SkipsFailures;

    public int $berhasil = 0;
    public int $duplikat = 0;

    public function model(array $row)
    {
        // Lewati jika No. RM sudah ada
        if (Pasien::where('no_rm', trim((string) $row['no_rm']))->exists()) {
            $this->duplikat++;
            return null;
        }

        // Konversi tanggal lahir
        if (is_numeric($row['tanggal_lahir'])) {
            // Format serial Excel
            $tanggalLahir = Date::excelToDateTimeObject($row['tanggal_lahir']);
        } else {
            // Format string (YYYY-MM-DD)
            $tanggalLahir = Carbon::parse($row['tanggal_lahir']);
        }

        $this->berhasil++;
        return new Pasien([
            'no_rm'          => trim((string) $row['no_rm']),
            'nama_pasien'    => trim($row['nama_pasien']),
            'jenis_kelamin'  => str_replace('-', '_', strtolower(trim($row['jenis_kelamin']))),
            'tanggal_lahir'  => $tanggalLahir->format('Y-m-d'),
            'umur'           => Carbon::parse($tanggalLahir)->age,
            'nama_kk'        => trim($row['nama_kk']),
            'alamat'         => trim($row['alamat']),
            'status_rm'      => 'tersedia',
        ]);
    }

    public function rules(): array
    {
        return [
            '*.no_rm' => 'required',
            '*.nama_pasien' => 'required',
            '*.jenis_kelamin' => 'required|in:laki-laki,perempuan',
            '*.tanggal_lahir' => 'required',
            '*.nama_kk' => 'required',
            '*.alamat' => 'required',
        ];
    }
}
