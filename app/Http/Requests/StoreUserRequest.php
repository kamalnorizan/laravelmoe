<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email:dns|max:255|unique:users',
            'sekolah_id' => 'required|exists:sekolah,id',
        ];
    }

    /**
     * Get the custom messages for the validation rules.
     *
     * @return array<string, string>
     */
    // public function messages(): array
    // {
    //     return [
    //         'email.required' => 'Email harus diisi.',
    //         'email.email' => 'Format email tidak valid.',
    //         'email.unique' => 'Email sudah terdaftar.',
    //         'sekolah_id.required' => 'Sekolah harus dipilih.',
    //         'sekolah_id.exists' => 'Sekolah yang dipilih tidak valid.',
    //     ];
    // }
}
