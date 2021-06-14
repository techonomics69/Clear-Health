<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offers;
use Carbon\Carbon;
use DB;
use Hash;
use Auth;

class OfferController extends Controller
{
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/

	function __construct()
	{
		
	}
	
	public function index(Request $request)
	{	
		
		
		
		//$data = Offers::where('to_date','>=',Carbon::now()->toDateString())->orderBy('id','DESC')->get();
		$data = Offers::orderBy('id','DESC')->get();//->where('to_date','>=',Carbon::now()->toDateString())where('from_date','>=',Carbon::now()->toDateString())
		//$affected = DB::table('offers')->update(['view_status' => 1]);
		return view('offers.index',compact('data'));
	}


	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/

	public function create()
	{	
		return view('offers.create');
	}

	


	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request)
	{
		echo'<pre>';
		print_r($request->all());
		echo'</pre>';
		die();
		$this->validate($request, [
			'promocode' => 'required',
			'from_date' => 'required',
			'to_date' => 'required',
			'description' => 'required',
			'promocode_type' => 'required',
			'promocode_value' => 'required',	
		]);

		$offer = Offers::create(array(
			'promocode'=>$request->promocode,
			'from_date'=>date('Y-m-d', strtotime($request->from_date)),
			'to_date'=>date('Y-m-d', strtotime($request->to_date)),
			'description'=>$request->description,
			'promocode_type'=>$request->promocode_type,
			'promocode_value'=>$request->promocode_value,
		));
		
		
		toastr()->success('Offer created successfully');

		return redirect()->route('offers.index');
	}

	

	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
		//$user = User::find($id);
		//return view('admin.users.show',compact('user'));
	}


	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/

	public function edit($id)
	{	
		$offer = Offers::find($id);
		return view('offers.edit',compact('offer'));
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
		
		$this->validate($request, [
			'promocode' => 'required',
			'from_date' => 'required',
			'to_date' => 'required',
			'description' => 'required',
			'promocode_type' => 'required',
			'promocode_value' => 'required',	
		]);

		$offer = Offers::find($id);

		
		$offer->update(array(
			'promocode'=>$request->promocode,
			'from_date'=>date('Y-m-d', strtotime($request->from_date)),
			'to_date'=>date('Y-m-d', strtotime($request->to_date)),
			'description'=>$request->description,
			'promocode_type'=>$request->promocode_type,
			'promocode_value'=>$request->promocode_value

		));

		toastr()->success('Offer updated successfully');

		return redirect()->route('offers.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$offers = Offers::find($id);
		$offers->delete();
		/*if ($offers) :
			Offers::find($id)->delete();
		endif;*/

		toastr()->success('Offer deleted successfully');
		return redirect()->route('offers.index');
	}
}