<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_pasien'       => 'required|string|max:100',
            'jenis_kelamin'     => 'required|in:laki_laki,perempuan',
            'tanggal_lahir'     => 'required|date',
            'nama_kk'           => 'required|string|max:100',
            'alamat'            => 'required|string'
        ];
    }


    public function messages(): array {
        return [
            'nama_pasien.required'          => 'Nama pasien wajib diisi',
            'jenis_kelamin.required'        => 'Jenis Kelamin wajib dipilih',
            'tanggal_lahir.required'        => 'Tanggal lahir wajib diisi',
            'nama_kk.required'              => 'Nama kepala keluarga wajib diisi',
            'alamat.required'               => 'Alamat wajib diisi',
        ];
    }
}
