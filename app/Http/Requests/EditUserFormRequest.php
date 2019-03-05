<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\User;

class EditUserFormRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'firstname' => 'required|string|max:191',
            // on precise que l'email doit etre unique si on le change mais on l'ignore si il reste inchangé
             'email' => ['required','email',Rule::unique('users')->ignore($this->user)],
            'adresse' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'postal_code' => 'required|max:5',
        ];

    }
}
