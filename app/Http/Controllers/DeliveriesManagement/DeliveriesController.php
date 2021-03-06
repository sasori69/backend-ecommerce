<?php

namespace App\Http\Controllers\DeliveriesManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Deliveries;
use Yajra\Datatables\Datatables;

class DeliveriesController extends Controller
{
    //Protected module deliveries by slug
    public function __construct()
    {
        $this->middleware('perm.acc:deliveries');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //public index deliveries
    public function index()
    {
        return view('panel.deliveries-management.deliveries.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //view form create
    public function create()
    {
        return view('panel.deliveries-management.deliveries.form-create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //store data deliveries
    public function store(Request $request)
    {
        $taxes = new Carriers();
        $taxes->name = $request->name;
        $taxes->price = $request->price;
        $taxes->delivery = $request->delivery;
        $taxes->save();
        
        return redirect()->route('courier.index')->with('toastr', 'new');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //for getting datatable at index
    public function show(Request $request, $action){
        $carriers = Deliveries::all();
        
        return Datatables::of($carriers)
            ->addColumn('action', function ($carriers) {
                return 
                    '<a class="btn btn-success btn-sm"  href="'.route('deliveries.create'/*,['id' => $carriers->id]*/).'">
                        <i class="fa fa-search"></i>&nbsp;View</a>'.
                    '<form style="display:inline;" method="POST" action="'.
                        route('courier.destroy',['id' => $carriers->id]).'">'.method_field('DELETE').csrf_field().
                    '<button type="button" class="btn btn-danger btn-sm" onclick="removeList($(this))"><i class="fa fa-remove"></i>&nbsp;Remove</button></form>';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //view form edit
    public function edit($id)
    {
        $carriers = Carriers::find($id);
        return view('panel.deliveries-management.courier.form-edit')->with(['carriers'=>$carriers]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //update data courier
    public function update(Request $request, $id)
    {
        $taxes = Carriers::find($id);
        $taxes->name = $request->name;
        $taxes->price = $request->price;
        $taxes->delivery = $request->delivery;
        
        $taxes->save();
        return redirect()->route('courier.index')->with('update', 'Carriers updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //delete data carriers
    public function destroy($id)
    {
        $taxes = Carriers::find($id);
        $taxes->delete();
        
        return redirect()->route('courier.index')->with('dlt', 'Courier deleted!');
    }
}
