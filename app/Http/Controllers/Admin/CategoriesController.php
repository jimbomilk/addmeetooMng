<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class CategoriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','destroy']]);
    }

    

    public function index(Request $request)
	{
        $categories = Category::paginate();
        return view ('admin.common.index',['name'=>'categories','set'=>$categories]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'categories']);
	}


    public function store(CategoryRequest $request)
    {

        $category = new Category($request->all());
        $category->save();

        return redirect()->route($this->indexPage("categories"));
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
        $category = Category::findOrFail($id);
        if (isset ($category))
            return view ('admin.common.edit',['name'=>'categories','element'=>$category]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function update(CategoryRequest $request, $id)
    {

        $this->category = Category::findOrFail($id);
        $this->category->fill($request->all());
        $this->category->save();

        return redirect()->route($this->indexPage("categories"));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
    {
        $this->category = Category::findOrFail($id);
        $this->category->delete();
        $message = $this->category->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Categories::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("categories"));
    }

}
