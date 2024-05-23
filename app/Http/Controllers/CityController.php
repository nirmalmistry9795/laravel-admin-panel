<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:city-list|city-create|city-edit|city-delete', ['only' => ['index']]);
        $this->middleware('permission:city-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:city-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(100);
        return view('cities.index', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return view('cities.add', ['states' => $states]);
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
            'state_id' => 'required',
            'name' => 'required|unique:cities,name',
        ]);

        DB::beginTransaction();

        try {
            $city = new City();
            $city->state_id = $request->state_id;
            $city->name = $request->name;
            $city->save();

            DB::commit();
            return redirect()->route('cities.index')->with('success', 'City Created Successfully.');

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
        $city = City::findOrFail($id);
        $states = State::all();
        return view('cities.edit', ['city' => $city, 'states' => $states]);
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
            'state_id' => 'required',
            'name' => 'required|unique:cities,name,' . $id,
        ]);

        DB::beginTransaction();

        try {
            $city = City::findOrFail($id);
            $city->state_id = $request->state_id;
            $city->name = $request->name;
            $city->save();

            DB::commit();
            return redirect()->route('cities.index')->with('success', 'City Updated Successfully.');

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
            City::whereId($id)->delete();

            DB::commit();
            return redirect()->route('cities.index')->with('success', 'City Deleted Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getCities(Request $request)
    {
        $data = [];
        try {
            $cities = City::select('id', 'name');
            if (isset($request->q)) {
                $cities = $cities->where('name', 'like', '%' . $request->q . '%');
            } else if ($request->state_id) {
                $cities = $cities->where('state_id', $request->state_id);
            } else {
                $cities = $cities->inRandomOrder()->limit(30);
            }
            $cities = $cities->orderBy('name', 'asc')->get();

            if (sizeof($cities)) {
                foreach ($cities as $key) {

                    $data[] = array('id' => $key->id, 'text' => $key->name);
                }
                return $data;
            }
            return response()->json([
                'status' => false,
                'message' => 'Cities not found.',
                'errors' => "Cities not found."
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
