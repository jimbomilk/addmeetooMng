<?php namespace App\Http\Requests;



class AdvertisementRequest extends Request {


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
            'name'                      => 'required',
            'imagebig' => 'required | mimes:jpeg,jpg,png | max:1000',
            'imagesmall' => 'required | mimes:jpeg,jpg,png | max:1000'
		];
	}

    public  function messages()
    {
        return [
            'imagebig.required' => 'La imagen es obligatoria y debe cumplir los requisitos',
            'imagebig.max' => 'La imagen debe ser menor de 1 MB',
            'imagebig.mimes' => 'La imagen debe ser jpg o png',
            'imagesmall.required' => 'La imagen es obligatoria y debe cumplir los requisitos',
            'imagesmall.max' => 'La imagen debe ser menor de 1 MB',
            'imagesmall.mimes' => 'La imagen debe ser jpg o png'
        ];
    }

}
