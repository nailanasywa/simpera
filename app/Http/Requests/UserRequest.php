<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user');

        return [
            'name'      => 'required|string|max:100',
            'email'     => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'role'      => ['required', Rule::in(['admin','petugas_poli','kepala_puskesmas']) ],
            'poli_id'   => [
                Rule::requiredIf($this->role === 'petugas_poli'),
                'nullable',
                'exists:polis,id',
            ],
            'no_hp'     => 'required|string|max:12',
            'password'  => $this->isMethod('post') ? 'required|confirmed|min:8' : 'nullable|confirmed|min:8',
        ];
    }

    public function messages(): array {
        return [
            'name.required'     => 'Username wajib diisi',
            'email.required'    => 'Email wajib diisi',
            'email.unique'      => 'Email sudah digunakan',
            'role.required'     => 'Role wajib dipilih',
            'poli_id.required'  => 'Poli wajib dipilih',
            'password.confirmed'=> 'Konfirmasi password tidak sesuai',
        ];
    }
}
