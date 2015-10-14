<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\League;
use Illuminate\Http\Request;

class LeagueController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$leagues = League::all();

		return view('leagues.index', compact('leagues'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('leagues.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$league = new League();

		$league->title = $request->input("title");
        $league->promise_reward = $request->input("promise_reward");
        $league->max_points = $request->input("max_points");
        $league->min_points = $request->input("min_points");

		$league->save();

		return redirect()->route('leagues.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$league = League::findOrFail($id);

		return view('leagues.show', compact('league'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$league = League::findOrFail($id);

		return view('leagues.edit', compact('league'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @param Request $request
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$league = League::findOrFail($id);

		$league->title = $request->input("title");
        $league->promise_reward = $request->input("promise_reward");
        $league->max_points = $request->input("max_points");
        $league->min_points = $request->input("min_points");

		$league->save();

		return redirect()->route('leagues.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$league = League::findOrFail($id);
		$league->delete();

		return redirect()->route('leagues.index')->with('message', 'Item deleted successfully.');
	}

}
