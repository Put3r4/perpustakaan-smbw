<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnggotaNonPelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_anggota'   => ['required', 'string', 'max:20', 'unique:anggota_non_pelajar,no_anggota'],
            'nik'          => ['required', 'string', 'max:30'],
            'nama_anggota' => ['required', 'string', 'max:100'],
            'pekerjaan'    => ['required', 'string', 'max:100'],
            'ttl'          => ['required', 'string', 'max:100'],
            'alamat'       => ['required', 'string'],
            'kode_pos'     => ['required', 'string', 'max:10'],
            'no_telp1'     => ['required', 'string', 'max:20'],
            'no_telp2'     => ['nullable', 'string', 'max:20'],
            'email'        => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function attributes(): array
    {
        return [
            'no_anggota'   => 'nomor anggota',
            'nik'          => 'NIK',
            'nama_anggota' => 'nama anggota',
            'pekerjaan'    => 'pekerjaan',
            'ttl'          => 'tempat tanggal lahir',
            'alamat'       => 'alamat',
            'kode_pos'     => 'kode pos',
            'no_telp1'     => 'nomor telepon 1',
            'no_telp2'     => 'nomor telepon 2',
            'email'        => 'email',
            'password'     => 'password',
        ];
    }
}
