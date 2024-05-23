<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Pincode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PincodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:pincode-list|pincode-create|pincode-edit|pincode-delete', ['only' => ['index']]);
        $this->middleware('permission:pincode-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:pincode-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:pincode-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pincodes = Pincode::paginate(100);
        return view('pincodes.index', ['pincodes' => $pincodes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('pincodes.add', ['cities' => $cities]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_id' => 'required',
            'pincode' => 'required|unique:pincodes,pincode',
        ]);

        DB::beginTransaction();

        try {
            $pincode = new Pincode();
            $pincode->city_id = $request->city_id;
            $pincode->pincode = $request->pincode;
            $pincode->save();

            DB::commit();
            return redirect()->route('pincodes.index')->with('success', 'Pincode Created Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pincode = Pincode::findOrFail($id);
        $cities = City::all();
        return view('pincodes.edit', ['pincode' => $pincode, 'cities' => $cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'city_id' => 'required',
            'pincode' => 'required|unique:pincodes,pincode,' . $id,
        ]);

        DB::beginTransaction();

        try {
            $pincode = Pincode::findOrFail($id);
            $pincode->city_id = $request->city_id;
            $pincode->pincode = $request->pincode;
            $pincode->save();

            DB::commit();
            return redirect()->route('pincodes.index')->with('success', 'Pincode Updated Successfully.');

        } catch (\Throwable $th) {
            // Rollback and return with Error
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            // Delete 
            Pincode::whereId($id)->delete();

            DB::commit();
            return redirect()->route('pincodes.index')->with('success', 'Pincode Deleted Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getPincodes(Request $request)
    {
        $data = [];
        try {
            $pincodes = Pincode::select('id', 'pincode');
            if (isset($request->q)) {
                $pincodes = $pincodes->where('pincode', 'like', '%' . $request->q . '%');
            } else if ($request->city_id) {
                $pincodes = $pincodes->where('city_id', $request->city_id);
            } else {
                $pincodes = $pincodes->inRandomOrder()->limit(30);
            }
            $pincodes = $pincodes->orderBy('pincode', 'asc')->get();

            if (sizeof($pincodes)) {
                foreach ($pincodes as $key) {
                    $data[] = array('id' => $key->id, 'text' => $key->pincode);
                }
                return $data;
            }
            return response()->json([
                'status' => false,
                'message' => 'Pincode not found.',
                'errors' => "Pincode not found."
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
