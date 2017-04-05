<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Language;
use Illuminate\Http\Request;

class LanguagesController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','create','destroy']]);
    }


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $languages = Language::paginate();

        return view ('admin.common.index',['name'=>'languages','set'=>$languages]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'languages']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store(LanguageRequest $request)
    {
        $language = new Item($request->all());
        $language->save();

        return redirect()->route($this->indexPage("languajes"));
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
    {
        $item = Language::findOrFail($id);
        if (isset($item))
        {
            return view('admin.common.edit',['name'=>'items','element' => $item]);
        }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(LanguageRequest $request, $id)
    {
        $this->language = Language::findOrFail($id);
        $this->language->fill($request->all());
        $this->language->save();

        return redirect()->route($this->indexPage("languajes"));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $this->language = Language::findOrFail($id);
        $this->language->delete();
        $message = $this->language->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Language::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("languajes"));
    }

}
