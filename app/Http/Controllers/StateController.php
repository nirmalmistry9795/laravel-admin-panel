<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:state-list|state-create|state-edit|state-delete', ['only' => ['index']]);
        $this->middleware('permission:state-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:state-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:state-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::paginate(50);
        return view('states.index', ['states' => $states]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();
        return view('states.add', ['countries' => $countries]);
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
            'country_id' => 'required',
            'name' => 'required|unique:states,name',
        ]);

        DB::beginTransaction();

        try {
            $state = new State();
            $state->country_id = $request->country_id;
            $state->name = $request->name;
            $state->save();

            DB::commit();
            return redirect()->route('states.index')->with('success', 'State Created Successfully.');

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
        $state = State::findOrFail($id);
        $countries = Country::all();
        return view('states.edit', ['state' => $state, 'countries' => $countries]);
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
            'country_id' => 'required',
            'name' => 'required|unique:states,name,' . $id,

        ]);

        DB::beginTransaction();

        try {
            $state = State::findOrFail($id);
            $state->country_id = $request->country_id;
            $state->name = $request->name;
            $state->save();

            DB::commit();
            return redirect()->route('states.index')->with('success', 'State Updated Successfully.');

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
            State::whereId($id)->delete();

            DB::commit();
            return redirect()->route('states.index')->with('success', 'State Deleted Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function getStates(Request $request)
    {
        $data = [];
        try {

            $states = State::select('id', 'name');
            if (isset($request->q)) {
                $states = $states->where('name', 'like', '%' . $request->q . '%');
            } else if ($request->country_id) {
                $states = $states->where('country_id', $request->country_id);
            } else {
                $states = $states->inRandomOrder()->limit(30);
            }
            $states = $states->orderBy('name', 'asc')->get();

            if (sizeof($states)) {
                foreach ($states as $key) {
                    $data[] = array('id' => $key->id, 'text' => $key->name);
                }
                return $data;
            }
            return response()->json([
                'status' => false,
                'message' => 'State not found.',
                'errors' => "State not found."
            ], 404);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
