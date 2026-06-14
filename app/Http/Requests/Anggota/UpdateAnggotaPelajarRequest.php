<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAnggotaPelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $anggota = $this->route('pelajar');

        return [
            'no_anggota'    => [
                'required',
                'string',
                'max:20',
                Rule::unique('anggota_pelajar', 'no_anggota')->ignore($anggota->id),
            ],
            'nim_nis'       => ['required', 'string', 'max:30'],
            'nama_anggota'  => ['required', 'string', 'max:100'],
            'email'         => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($anggota->user_id),
            ],
            'password'      => ['nullable', 'string', 'min:8', 'confirmed'],
            'asal_sekolah'  => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'alamat'        => ['required', 'string'],
            'kode_pos'      => ['nullable', 'string', 'max:10'],
            'no_telp1'      => ['required', 'string', 'max:20'],
            'no_telp2'      => ['nullable', 'string', 'max:20'],
            'nama_ortu'     => ['required', 'string', 'max:100'],
            'alamat_ortu'   => ['required', 'string'],
            'no_telp_ortu'  => ['required', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return (new StoreAnggotaPelajarRequest())->attributes();
    }
}
