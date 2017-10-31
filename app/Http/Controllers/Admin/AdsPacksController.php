<?php namespace App\Http\Controllers\Admin;

use App\Adspack;
use App\Advertisement;
use App\General;
use App\Http\Requests\AdsPackRequest;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;

class AdsPacksController extends Controller {
    public $now = null;
    public $next = null;
    public $address = null;

    public function __construct()
    {

        parent::__construct();
        $this->middleware('auth');

    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
        $id = $request->session()->get('advertisement_id');
        $adsPack = Adspack::where('advertisement_id','=',$id)->paginate();
        return view ('admin.common.index',['name'=>'adspacks','set'=>$adsPack]);
	}

    public function sendView ($element=null)
    {

        $map = General::createMap($element,true);


        if (isset($element)) {
            $element->startdate = $element->localStartdate;
            $element->enddate = $element->localEnddate;
            return view('admin.common.edit', ['name' => 'adspacks', 'element' => $element, 'map' => $map]);
        }
        else{
            //$now = Carbon::now()->format('Y-m-d\TH:i');
            return view('admin.common.create', ['name' => 'adspacks', 'map' => $map, 'now'=>$this->now,'next'=>$this->next, 'dir'=>$this->address]);
        }
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
    {
        $ad = Advertisement::find($request->session()->get('advertisement_id'));
        if (isset($ad))
        {
            $l = $ad->location;
            if (isset($l)) {
                $this->now = Carbon::now($l->timezone)->format('Y-m-d\TH:i');
                $this->next = Carbon::now($l->timezone)->addMonth()->format('Y-m-d\TH:i');
                $this->address = $l->address;
            }
        }
        return $this->sendView();
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(AdsPackRequest $request)
	{
        $ads = new Adspack($request->all());
        $id = $request->session()->get('advertisement_id');
        $ads->advertisement_id = $id;
        $ads->startdate = $ads->getUTCStartdate();
        $ads->enddate = $ads->getUTCEnddate();
        $ads->save();

        return redirect()->route($this->indexPage("adspacks"));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $ads = Adspack::findOrFail($id);

        if (isset ($ads))
        {
            return $this->sendView($ads);

        }

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(AdsPackRequest $request, $id)
	{
        $ads = Adspack::findOrFail($id);
        $ads->fill($request->all());
        $ads->startdate = $ads->getUTCStartdate();
        $ads->enddate = $ads->getUTCEnddate();
        $ads->save();

        return redirect()->route($this->indexPage("adspacks"));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
    public function destroy($id,Request $request)
	{
        $ads = Adspack::findOrFail($id);
        $ads->delete();
        $message = 'ad'.$ads->id. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Adspack::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route($this->indexPage("adspacks"));
	}

}
