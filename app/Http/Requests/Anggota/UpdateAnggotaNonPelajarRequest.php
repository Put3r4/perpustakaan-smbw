<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnggotaNonPelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $anggota = $this->route('nonPelajar');

        return [
            'no_anggota'   => [
                'required',
                'string',
                'max:20',
                Rule::unique('anggota_non_pelajar', 'no_anggota')->ignore($anggota->id),
            ],
            'nik'          => ['required', 'string', 'max:30'],
            'nama_anggota' => ['required', 'string', 'max:100'],
            'pekerjaan'    => ['required', 'string', 'max:100'],
            'ttl'          => ['required', 'string', 'max:100'],
            'alamat'       => ['required', 'string'],
            'kode_pos'     => ['required', 'string', 'max:10'],
            'no_telp1'     => ['required', 'string', 'max:20'],
            'no_telp2'     => ['nullable', 'string', 'max:20'],
            'email'        => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($anggota->user_id),
            ],
            'password'     => ['nullable', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return (new StoreAnggotaNonPelajarRequest())->attributes();
    }
}
