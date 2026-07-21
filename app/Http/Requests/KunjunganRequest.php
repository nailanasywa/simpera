<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KunjunganRequest extends FormRequest
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
            'pasien_id'     => 'required|exists:pasien,id',
            'poli_id'       => 'required|exists:polis,id',
            'kepesertaan'   => 'required|in:bpjs,umum',
            'tanggal_kunjungan' => 'required|date',
        ];
    }

    public function messages(): array {
        return [
            'pasien_id.required'        => 'Pasien tidak ditemukan',
            'poli_id.required'          => 'Poli wajib dipilih',
            'kepesertaan.required'      => 'Kepesertaan wajib dipilih',
            'tanggal_kunjungan.required'=> 'Tanggal kunjungan wajib diisi'
        ];
    }
}
