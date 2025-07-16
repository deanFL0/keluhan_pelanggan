<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeluhanPelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nama' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:100',
            'nomor_hp' => 'required|digits_between:10,15',
            'status_keluhan' => 'required|string|in:0,1,2',
            'keluhan' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.min' => 'Nama harus minimal 3 karakter.',
            'nama.max' => 'Nama tidak boleh lebih dari 50 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 100 karakter.',
            'nomor_hp.required' => 'Nomor HP harus diisi.',
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
            'nomor_hp.max' => 'Nomor HP tidak boleh lebih dari 15 digit.',
            'status_keluhan.required' => 'Status keluhan harus dipilih.',
            'keluhan.required' => 'Keluhan harus diisi.',
            'keluhan.string' => 'Keluhan harus berupa teks.',
            'keluhan.max' => 'Keluhan tidak boleh lebih dari 255 karakter.',
        ];
    }
}
