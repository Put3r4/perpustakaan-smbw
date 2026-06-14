<?php

namespace App\Http\Requests\Anggota;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnggotaPelajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'no_anggota'      => ['required', 'string', 'max:20', 'unique:anggota_pelajar,no_anggota'],
            'nim_nis'         => ['required', 'string', 'max:30'],
            'nama_anggota'    => ['required', 'string', 'max:100'],
            'email'           => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'asal_sekolah'    => ['required', 'string', 'max:100'],
            'tanggal_lahir'   => ['required', 'date', 'before:today'],
            'alamat'          => ['required', 'string'],
            'kode_pos'        => ['nullable', 'string', 'max:10'],
            'no_telp1'        => ['required', 'string', 'max:20'],
            'no_telp2'        => ['nullable', 'string', 'max:20'],
            'nama_ortu'       => ['required', 'string', 'max:100'],
            'alamat_ortu'     => ['required', 'string'],
            'no_telp_ortu'    => ['required', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'no_anggota'    => 'nomor anggota',
            'nim_nis'       => 'NIM/NIS',
            'nama_anggota'  => 'nama anggota',
            'asal_sekolah'  => 'asal sekolah',
            'tanggal_lahir' => 'tanggal lahir',
            'kode_pos'      => 'kode pos',
            'no_telp1'      => 'telepon 1',
            'no_telp2'      => 'telepon 2',
            'nama_ortu'     => 'nama orang tua',
            'alamat_ortu'   => 'alamat orang tua',
            'no_telp_ortu'  => 'telepon orang tua',
        ];
    }
}
