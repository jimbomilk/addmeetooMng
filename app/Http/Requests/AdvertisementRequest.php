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

        if ($this->method() == 'PUT')
        {
            // Update operation, exclude the required
            $imgBig = 'mimes:jpeg,jpg,png|max:1000';
            $imgSml = 'mimes:jpeg,jpg,png|max:1000';
        }
        else
        {
            // Create operation. There is no id yet.
            $imgBig = 'required|mimes:jpeg,jpg,png|max:1000';
            $imgSml = 'required|mimes:jpeg,jpg,png|max:1000';
        }


        return [
            'name'          => 'required',
            'imagebig'      => $imgBig,
            'imagesmall'    => $imgSml
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
