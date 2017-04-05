<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\BidRequest;
use App\Http\Controllers\Controller;
use App\Bid;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class BidsController extends Controller {


    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');
        //$this->beforeFilter('@init',['only'=>['show','edit','create','destroy']]);
    }

    public function init(Route $route)
    {
        $parameter = $route->getParameter('bids');
        if (isset ($parameter))
        {
            $this->bid = Bid::findOrFail($parameter);
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $items = Bid::paginate();

        return view ('admin.common.index',['name'=>'bids','set'=>$items]);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'bids']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(BidRequest $request)
	{
        $item = new Bid($request->all());
        $item->save();

        return redirect()->route($this->indexPage("bids"));
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
        return view('admin.common.edit',['name'=>'bids','element' => $this->bid]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(BidRequest $request, $id)
	{
        $this->bid = Bid::findOrFail($id);
        $this->bid->fill($request->all());
        $this->bid->save();

        return redirect()->route($this->indexPage("bids"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->bid = Bid::findOrFail($id);
        $this->bid->delete();
        $message = $this->bid->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Bid::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("bids"));
	}

}
