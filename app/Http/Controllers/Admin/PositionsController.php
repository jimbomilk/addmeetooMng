<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\LocationPosition;
use App\Http\Requests\PositionRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class PositionsController extends Controller {

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

    public function init(Position $position)
    {
        if (isset($position))
        {
            $this->position = LocationPosition::findOrFail($position);
        }
    }


    public function index(Request $request)
    {
        $positions = LocationPosition::paginate();
        return view ('admin.common.index',['name'=>'positions','set'=>$positions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.common.create',['name'=>'positions']);
    }


    public function store(PositionRequest $request)
    {

        $position = new LocationPosition($request->all());
        $position->save();

        return redirect()->route('admin.positions.index');
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
        $position = LocationPosition::findOrFail($id);
        return view ('admin.common.edit',['name'=>'positions','element'=>$position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(PositionRequest $request, $id)
    {

        $this->position = LocationPosition::findOrFail($id);
        $this->position->fill($request->all());
        $this->position->save();

        return redirect()->route('admin.positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id,Request $request)
    {
        $this->position = LocationPosition::findOrFail($id);
        $this->position->delete();
        $message = $this->position->description. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => LocationPosition::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->route('admin.positions.index');
    }

}
