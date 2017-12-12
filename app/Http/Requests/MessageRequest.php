<?php namespace App\Http\Requests;



class MessageRequest extends Request {


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
            'start'  => 'required',
            'end'  => 'required|after:start',
            'file.image' => 'mimes:jpeg,bmp,png',
            'duration' => 'digits_between:0,1'
		];
	}

    public function messages()
    {
        return [
            'start.required' => 'La hora de inicio del mensaje es obligatoria',
            'end.required'  => 'La hora de inicio del mensaje es obligatoria',
            'start.date_format' => 'El formato de la fecha de inicio es incorrecto',
            'end.date_format' => 'El formato de la fecha de fin es incorrecto',
            'duration.digits_between' => 'La duración debe estar comprendida entre 0 y 9 minutos'
        ];
    }

}
