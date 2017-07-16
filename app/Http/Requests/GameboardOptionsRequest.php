<?php namespace App\Http\Requests;



class GameboardOptionsRequest extends Request {


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
            'description'                      => 'required',
            'image' => 'required | mimes:jpeg,jpg,png | max:1000'
		];
	}

    public  function messages()
    {
        return [
            'image.required' => 'La imagen es obligatoria y debe cumplir los requisitos',
            'image.max' => 'La imagen debe ser menor de 1 MB',
            'image.mimes' => 'La imagen debe ser jpg o png'
        ];
    }

}
