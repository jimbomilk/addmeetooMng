<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuctionRequest;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class ItemsController extends Controller {


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
        $items = Item::paginate();

        return view ('admin.common.index',['name'=>'items','set'=>$items]);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'items']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ItemRequest $request)
	{
        $item = new Item($request->all());
        $item->save();

        return redirect()->route($this->indexPage("items"));
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
        $item = Item::findOrFail($id);
        if (!isset($id))
            return;
        else
            return view('admin.common.edit',['name'=>'items','element' => $item]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ItemRequest $request, $id)
	{
        $this->item = Item::findOrFail($id);
        $this->item->fill($request->all());
        $this->item->save();

        return redirect()->route($this->indexPage("items"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->item = Item::findOrFail($id);
        $this->item->delete();
        $message = $this->item->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Item::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("items"));
	}

}
