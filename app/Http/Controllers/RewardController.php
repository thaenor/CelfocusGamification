<?php namespace App\Http\Controllers;
require('otrsDAL.php');
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Reward;
use Illuminate\Http\Request;

class RewardController extends Controller {

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
		$rewards = Reward::all();

		return view('rewards.index', compact('rewards'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('rewards.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$reward = new Reward();

		$reward->title = $request->input("title");
        $reward->assigned_user = $request->input("assigned_user");
        $reward->winner = $request->input("winner");

		$reward->save();

		return redirect()->route('rewards.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$reward = Reward::findOrFail($id);

        return view('rewards.show', compact('reward','jsonData'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$reward = Reward::findOrFail($id);

		return view('rewards.edit', compact('reward'));
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
		$reward = Reward::findOrFail($id);

		$reward->title = $request->input("title");
        $reward->assigned_user = $request->input("assigned_user");
        $reward->winner = $request->input("winner");

		$reward->save();

		return redirect()->route('rewards.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$reward = Reward::findOrFail($id);
		$reward->delete();

		return redirect()->route('rewards.index')->with('message', 'Item deleted successfully.');
	}

}
