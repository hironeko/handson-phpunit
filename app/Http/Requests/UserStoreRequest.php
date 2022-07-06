<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => [
                'required',
                'string'
            ],
            'email' => [
                'required',
                'email:strict,dns,spoof',
                function ($_, $v, $fail) {
                    $isExists = User::where([
                        'email' => $v
                    ])
                        ->whereNull('deleted_at')
                        ->first();
                    if ($isExists) {
                        $fail('すでに登録されているアドレスになります。');
                    }
                }
            ],
            'password' => [
                'required',
                'max:10',
                'min:8'
            ]
        ];
    }
}
