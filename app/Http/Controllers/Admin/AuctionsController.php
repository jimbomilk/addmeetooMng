<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuctionRequest;
use App\Http\Controllers\Controller;
use App\Auction;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;


class AuctionsController extends Controller {


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
        $items = Auction::paginate();


        return view ('admin.common.index',['name'=>'auctions','set'=>$items]);


	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('admin.common.create',['name'=>'auctions']);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AuctionRequest $request)
	{
        $item = new Auction($request->all());
        $item->save();

        return redirect()->route($this->indexPage("auctions"));
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
        
        $auction = Auction::findOrFail($id);
        if (isset ($auction))
            return view('admin.common.edit',['name'=>'auctions','element' => $auction]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AuctionRequest $request, $id)
	{
        $this->auction = Auction::findOrFail($id);
        $this->auction->fill($request->all());
        $this->auction->save();

        return redirect()->route($this->indexPage("auctions"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $this->auction = Auction::findOrFail($id);
        $this->auction->delete();
        $message = 'Auction for '. $this->auction->item->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Auction::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("auctions"));
	}

}
