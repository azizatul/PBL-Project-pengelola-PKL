<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSuratRekomendasiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'nomor_surat' => 'required|string|unique:surat_rekomendasis,nomor_surat,' . $this->route('id'),
            'tanggal_surat' => 'required|date',
            'persyaratan' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'catatan' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'mahasiswa_id.required' => 'Mahasiswa harus dipilih.',
            'mahasiswa_id.exists' => 'Mahasiswa yang dipilih tidak valid.',
            'nomor_surat.required' => 'Nomor surat harus diisi.',
            'nomor_surat.unique' => 'Nomor surat sudah digunakan.',
            'tanggal_surat.required' => 'Tanggal surat harus diisi.',
            'tanggal_surat.date' => 'Format tanggal tidak valid.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ];
    }
}
