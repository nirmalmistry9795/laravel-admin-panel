<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:country-list|country-create|country-edit|country-delete', ['only' => ['index']]);
        $this->middleware('permission:country-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:country-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:country-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::paginate(50);
        return view('country.index', ['countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('country.add');
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
            'short_name' => 'required',
            'country_name' => 'required|unique:countries,country_name',
            'phonecode' => 'required',
            'continent' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $country = new Country();
            $country->short_name = $request->short_name;
            $country->country_name = $request->country_name;
            $country->flag = getSlug($request->short_name);
            $country->slug = getSlug($request->name);
            $country->phonecode = $request->phonecode;
            $country->continent = $request->continent;
            $country->save();

            DB::commit();
            return redirect()->route('countries.index')->with('success', 'Country Created Successfully.');

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
        $country = Country::findOrFail($id);
        return view('country.edit', ['country' => $country]);
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
            'short_name' => 'required',
            'country_name' => 'required|unique:countries,country_name,' . $id,
            'phonecode' => 'required',
            'continent' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $country = Country::findOrfail($id);
            $country->short_name = $request->short_name;
            $country->country_name = $request->country_name;
            $country->flag = getSlug($request->short_name);
            $country->slug = getSlug($request->name);
            $country->phonecode = $request->phonecode;
            $country->continent = $request->continent;
            $country->save();

            DB::commit();
            return redirect()->route('countries.index')->with('success', 'Country Updated Successfully.');


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
            Country::whereId($id)->delete();

            DB::commit();
            return redirect()->route('countries.index')->with('success', 'Country Deleted Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function export($id)
    {
        //
    }

    public function getCountries(Request $request)
    {
        $data = [];
        try {

            if (isset($request->q)) {

                $countries = Country::where('country_name', 'like', '%' . $request->q . '%')->orderBy('country_name', 'asc')->get(['id', 'country_name']);


            } else {
                $countries = Country::select('id', 'country_name')->inRandomOrder()->limit(30)->get();
            }

            if (sizeof($countries)) {
                foreach ($countries as $key) {

                    $data[] = array('id' => $key->id, 'text' => $key->country_name);
                }
                return $data;
            }
            return response()->json([
                'status' => false,
                'message' => 'Countries not found.',
                'errors' => "Countries not found."
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
