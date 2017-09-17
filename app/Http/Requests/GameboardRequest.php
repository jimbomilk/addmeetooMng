<?php namespace App\Http\Requests;



class GameboardRequest extends Request {


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
            'name'              => 'required',
            'activity_id'       => 'required',
            'location_id'       => 'required',
            'endgame'           => 'after:startgame',
            'startgame'         => 'before:endgame',
            'deadline'          => 'after:startgame',
            'deadline'          => 'before:endgame',
            'image'             => 'mimes:jpeg,jpg,png|max:500'
        ];
	}


    public  function messages()
    {
        return [
            'image.max' => 'La imagen debe ser menor de 500KB',
            'image.mimes' => 'La imagen debe ser jpg o png'
        ];
    }


}
