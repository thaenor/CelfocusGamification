<?php namespace App\Http\Controllers;

use App\Http\Requests;
//use App\Http\Controllers\Controller;
//use Carbon\Carbon;
use App\Group;
//use App\Ticket;
//use App\User;
//use App\Article;
use Illuminate\Http\Request;

class GroupController extends Controller {

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
		$groups = Group::all();
        //return $allGroups = Group::paginate(15); //returns JSON separated by pages with data
		return view('groups.index', compact('groups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$group = new Group();

		$group->title = $request->input("title");
        $group->variant_name = $request->input("variant_name");
        $group->points = $request->input("points");

		$group->save();

		return redirect()->route('groups.index')->with('message', 'Item created successfully.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group = Group::findOrFail($id);

		return view('groups.show', compact('group'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$group = Group::findOrFail($id);

		return view('groups.edit', compact('group'));
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
		$group = Group::findOrFail($id);

		$group->title = $request->input("title");
        $group->variant_name = $request->input("variant_name");
        $group->points = $request->input("points");

		$group->save();

		return redirect()->route('groups.index')->with('message', 'Item updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$group = Group::findOrFail($id);
		$group->delete();

		return redirect()->route('groups.index')->with('message', 'Item deleted successfully.');
	}

}
