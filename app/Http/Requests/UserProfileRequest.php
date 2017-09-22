<?php namespace App\Http\Requests;



class UserProfileRequest extends Request {


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
            $image = 'mimes:jpeg,jpg,png|max:1000';
        }
        else
        {
            $image = 'required|mimes:jpeg,jpg,png|max:1000';
        }

        return [
            'location_id'                      => 'required',
            'avatar' => $image
        ];
	}

}
