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
            'name'                      => 'required',
            'activity_id'               => 'required',
            'location_id'               => 'required'
        ];
	}



}
