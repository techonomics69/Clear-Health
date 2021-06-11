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
		$headerLeftContent = "<p class='name-page'>Offers</p>";
		
		$headerRightContent = "<p><a class='btn btn-light' href=".url('/')."/admin/offers/create>&plus; Create New Offer</a></p>";
		
		
		//$data = Offers::where('to_date','>=',Carbon::now()->toDateString())->orderBy('id','DESC')->get();
		$data = Offers::orderBy('id','DESC')->get();//->where('to_date','>=',Carbon::now()->toDateString())where('from_date','>=',Carbon::now()->toDateString())
		//$affected = DB::table('offers')->update(['view_status' => 1]);
		return view('offers.index',compact('data','headerLeftContent','headerRightContent'));
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

		//dd($request->all());
		$this->validate($request, [
			'title' => 'required',
			'from_date' => 'required',
			'to_date' => 'required',
			'description' => 'required',
			//'photo' => 'mimes:jpeg,jpg,png,PNG,JPG,JPEG',	
			'offer_type' => 'required',	
			'vehicle'=> 'required',	
		]);

	/*foreach($request->vehicle as $vehicle){

			echo "<pre>";
			print_r($vehicle);
			echo "<pre>";
			exit();	

	}
*/

		if(isset($request->percentage) && $request->percentage != null){
			$this->validate($request, [
			'percentage'=>'numeric',
			
		]);
		}

		if(isset($request->amount) && $request->amount != null){
			$this->validate($request, [
			'amount' =>'numeric',
		]);
		}

		if(isset($request->offer_type) && $request->offer_type == 5){
			$this->validate($request, [
			'promocode' =>'required',
			'promocode_type' =>'required',
			'promocode_value' =>'required',
		]);
		}



		$offer = Offers::create(array(
			'title'=>$request->title,
			'from_date'=>date('Y-m-d', strtotime($request->from_date)),
			'to_date'=>date('Y-m-d', strtotime($request->to_date)),
			'description'=>$request->description,
			'offer_type'=>$request->offer_type,
			'percentage'=>isset($request->percentage) ? $request->percentage:0,
			'amount'=>isset($request->amount) ? $request->amount:0,
			'gift'=>isset($request->gift) ? $request->gift:'',
			'addon'=>isset($request->addon) ? implode(',', $request->addon):'',
			'vehicle'=>isset($request->vehicle) ? implode(',', $request->vehicle):'',
			'promocode'=>isset($request->promocode) ? $request->promocode:'',
			'promocode_type'=>isset($request->promocode_type) ? $request->promocode_type:'',
			'promocode_value'=>isset($request->promocode_value) ? $request->promocode_value:'',
			'promocode_description'=>isset($request->promocode_description) ? $request->promocode_description:'',

		));
		$insertedId = $offer->id;
		$input=array();
		$input_addon=array();
		$input['offer_id'] = $insertedId;

		if(isset($request->vehicle)){
			foreach ($request->vehicle as  $vahi) {
				$input['vehicle_id'] = $vahi;
			$offer_vehicle = Offersonvehicle::create($input);
			}
			

			
		}

		$input_addon['offer_id'] = $insertedId;

		if(isset($request->addon)){
			foreach ($request->addon as  $addon) {
				$input_addon['addon_id'] = $addon;
				$offer_addon = Offersaddon::create($input_addon);
			}
			

			
		}

		toastr()->success('Offer created successfully');
		//return redirect()->back();
		return redirect('/admin/offers');
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

		$vehicle = Vehicle::join('brand', 'vehicles.brand_name', '=', 'brand.id')
				->join('model', 'vehicles.model', '=', 'model.id')
				->orderBy('vehicles.id','DESC')
				->select('vehicles.id AS vehicle_id','vehicles.vehicle_ref','model.model_name','brand.brand_name','vehicles.trim','vehicles.km_driven','vehicles.year','vehicles.status')
				->where('vehicles.status',1)
				->get();

		$addonProducts = AddonProducts::orderBy('id','DESC')->get();

		$headerLeftContent = "<p class='name-page'>Edit Offer</p>";
		

		$headerRightContent = '<ol class="breadcrumb m-0">
        <li class="breadcrumb-item"><a href="' . url('/admin/home'). '">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="'.url('/admin/offers/').'">Offers</a></li>
        <li class="breadcrumb-item active">Edit Offer</li> 
        </ol>';

		return view('offers.edit',compact('offer','vehicle','addonProducts','headerLeftContent','headerRightContent'));
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
			'title' => 'required',
			'from_date' => 'required',
			'to_date' => 'required',
			'description' => 'required',
			//'photo' => 'mimes:jpeg,jpg,png,PNG,JPG,JPEG',	
			'offer_type' => 'required',	
			'vehicle'=> 'required',	
			
		]);

		if(isset($request->percentage) && $request->percentage != null){
			$this->validate($request, [
			'percentage'=>'numeric',
			
		]);
		}

		if(isset($request->amount) && $request->amount != null){
			$this->validate($request, [
			'amount' =>'numeric',
		]);
		}

		if(isset($request->offer_type) && $request->offer_type == 5){
			$this->validate($request, [
			'promocode' =>'required',
			'promocode_type' =>'required',
			'promocode_value' =>'required',
		]);
		}

		$offer = Offers::find($id);

		if ($offer) {
			$offer_vehicle = Offersonvehicle::where('offer_id',$id)->get();
			if(!empty($offer_vehicle)):
				foreach ($offer_vehicle as $key => $value):
					Offersonvehicle::where('offer_id',$id)->delete();
				endforeach;
			endif;
			$offer_addon = Offersaddon::where('offer_id', $id)->get();

			if(!empty($offer_addon)):
				foreach ($offer_addon as $key => $value):
					Offersaddon::where('offer_id', $id)->delete();
				endforeach;
			endif;
		}

		$offer->update(array(
	        'title'=>$request->title,
			//'from_date'=>$request->from_date,
			//'to_date'=>$request->to_date,
			'from_date'=>date('Y-m-d', strtotime($request->from_date)),
			'to_date'=>date('Y-m-d', strtotime($request->to_date)),
			'description'=>$request->description,
			'offer_type'=>$request->offer_type,
			'percentage'=>isset($request->percentage) ? $request->percentage:0,
			'amount'=>isset($request->amount) ? $request->amount:0,
			'gift'=>isset($request->gift) ? $request->gift:'',
			'addon'=>isset($request->addon) ? implode(',', $request->addon):'',
			'vehicle'=>isset($request->vehicle) ? implode(',', $request->vehicle):'',
			'promocode'=>isset($request->promocode) ? $request->promocode:'',
			'promocode_type'=>isset($request->promocode_type) ? $request->promocode_type:0,
			'promocode_value'=>isset($request->promocode_value) ? $request->promocode_value:'',
			'promocode_description'=>isset($request->promocode_description) ? $request->promocode_description:'',

      	));

		$insertedId = $offer->id;
		$input=array();
		$input_addon=array();
		$input['offer_id'] = $insertedId;

		if(isset($request->vehicle)){
			foreach ($request->vehicle as  $vahi) {
				$input['vehicle_id'] = $vahi;
			$offer_vehicle = Offersonvehicle::create($input);
			}
			

			
		}

		$input_addon['offer_id'] = $insertedId;

		if(isset($request->addon)){
			foreach ($request->addon as  $addon) {
				$input_addon['addon_id'] = $addon;
				$offer_addon = Offersaddon::create($input_addon);
			}
			

			
		}
		
		toastr()->success('Offer updated successfully');

		return redirect()->back();
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
		if ($offers) :
			$offer_vehicle = Offersonvehicle::where('offer_id',$id)->get();
			if(!empty($offer_vehicle)):
				foreach ($offer_vehicle as $key => $value):
					Offersonvehicle::where('offer_id',$id)->delete();
				endforeach;
			endif;
			$offer_addon = Offersaddon::where('offer_id', $id)->get();
			if(!empty($offer_addon)):
				foreach ($offer_addon as $key => $value):
					Offersaddon::where('offer_id', $id)->delete();
				endforeach;
			endif;
		
			Offers::find($id)->delete();
			toastr()->success('Offer deleted successfully');
			return redirect()->back();
		endif;
	}
}