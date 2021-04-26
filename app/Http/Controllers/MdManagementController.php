<?php
    
namespace App\Http\Controllers;

use App\Models\Language;   
use App\Models\Mdmanagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
    
class MdManagementController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
            
        //$arrayName = array(['language_id']);
        $mdmanagement = Mdmanagement::all();


        foreach ($mdmanagement as $mdmanagementkey => $mdmanagementvalue) {
            $language_ids = explode(',',$mdmanagementvalue->language_id);
            $languages = Language::whereIn('id',$language_ids)->select('name')->get()->toArray();
            $mdmanagement[$mdmanagementkey]->languages = implode(",", array_column($languages, "name"));
            
        }
        return view('mdmanagement.index', compact('mdmanagement'));
    }

    public function create()
    {
        $language = Language::pluck('name', 'id')->toArray();
        return view('mdmanagement.create',compact('language'));        
    }

    public function store(Request $request)
    {               
            $this->validate($request, [
            'name' => 'required|unique:md_managment,name',
            'status' => 'required|not_in:0',
            'language_id' => 'required|not_in:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',                        
        ]);

        $language_id =  implode(",",$request->language_id);
        $request['language_id']=$language_id;

        $imageName = time().'.'.$request->image->extension();

        $path = public_path().'/images/Mdmanagement';

        if (! File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        $request->image->move(public_path('images/Mdmanagement'), $imageName);


        $mdmanagement = Mdmanagement::create(['name' => $request->input('name'),'image' => $imageName,
            
            'language_id' => $request->input('language_id'),

            'status' => $request->input('status'),'case_id' => $request->input('case_id')]);
            
        toastr()->success('Md Management created successfully');

        return redirect()->route('mdmanagement.index');

    }

    public function show($id)
    {
        $mdmanagement = Mdmanagement::find($id);
        $language_ids = explode(',',$mdmanagement->language_id);
        $languages = Language::whereIn('id',$language_ids)->select('name')->get()->toArray();
        $mdmanagement->languages = implode(",", array_column($languages, "name"));

        if(isset($mdmanagement)):
            return view('mdmanagement.show',compact('mdmanagement'));
        else:
            return redirect()->away('http://'.$id);
        endif;
    }

    public function edit($id)
    {
        $mdmanagement = Mdmanagement::find($id);

        $selected_language = explode(',',$mdmanagement->language_id);
        $language = Language::pluck('name', 'id')->toArray();


        return view('mdmanagement.edit',compact('mdmanagement','language','selected_language'));
    }

    public function update(Request $request, $id)
    {
         
       
        $mdmanagement = Mdmanagement::find($id);

        $this->validate($request, [
            //'name' => 'required|unique:md_managment,name',
            //'status' => 'required|not_in:0',
            //'language_id' => 'required|not_in:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',         
        ]);

        $language_id =  implode(",",$request->language_id);
        $request['language_id']=$language_id;

        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Mdmanagement';

        if (! File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Mdmanagement'), $imageName);

            $oldImg = $path.'/'.$mdmanagement->image;

            if (File::exists($oldImg)) : // unlink or remove previous image from folder
                unlink($oldImg);
            endif;

            $mdmanagement->image = $imageName;
            endif;

            $mdmanagement->name = $request->input('name');
            $mdmanagement->status = $request->input('status');
            $mdmanagement->language_id = $request->input('language_id');
            $mdmanagement->save();       
             
           toastr()->success('MdManagement updated successfully');

            return redirect()->route('mdmanagement.index');
        }

    public function destroy($id)
    {
        Mdmanagement::find($id)->delete();
        toastr()->success('MdManagement deleted successfully');

        return redirect()->route('mdmanagement.index');
    }
}