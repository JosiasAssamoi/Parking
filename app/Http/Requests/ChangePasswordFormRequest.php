<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordFormRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
             'password' => 'required',
             'newpassword' => 'required|min:6',
             'confirm-password' => 'required|same:newpassword',
        ];
    }

    public function messages()
    {
        return [
             'password.required' => 'Le mot de passe est requis',
             'confirm-password.required' => 'la confirmation du mot de passe est requise',
             'confirm-password.same' => 'Les 2 mots de passe doivent correspondre !',
        ];
    }
}
