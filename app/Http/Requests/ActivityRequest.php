<?php namespace App\Http\Requests;



class ActivityRequest extends Request {


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
            'grouping'                  => 'required',
            'selection'                 => 'required',
            'point_system'              => 'required',
            'how'                       => 'required',
            'category_id'               => 'required',
            'location_id'               => 'required',
            'location_position_id'      => 'required'
		];
	}

}
