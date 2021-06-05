<?php

namespace App\Http\Controllers;

use App\Models\TreatmentGuides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;



class TreatmentGuidesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $treatmentguides = TreatmentGuides::OrderBy('id', 'DESC')->paginate(50);
    return view('treatmentGuides.index', compact('treatmentguides'))->with('i', (request()->input('page', 1) - 1) * 5);
  }

  public function create()
  {
    return view('treatmentGuides.create');
  }

  public function store(Request $request)
  {
    $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
    $this->validate($request, [

      'title' => 'required|unique:products,name|regex:/^[\pL\s\-]+$/u',
      'sub_title' => 'required',
      'status' => 'required|not_in:0',
      'detail' => 'required',
      'guides_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
    ]);
    $data = $request->all();

    if(!empty($request->guides_image)):
      $imageName = time().'.'.$request->guides_image->extension();

      $path = public_path().'/images/TreatmentGuides';

      if (! File::exists($path)) {
        File::makeDirectory($path, $mode = 0777, true, true);
      }

      $request->guides_image->move(public_path('images/TreatmentGuides'), $imageName);
      $data['guides_image'] = $imageName;
    endif;

    $treatmentGuides = TreatmentGuides::create($data);

    toastr()->success('Treatment Guides created successfully');
    return redirect()->route('treatmentGuides.index');
  }

  public function show($id)
  {

    $treatmentGuides = TreatmentGuides::find($id);
    if(isset($treatmentGuides)):
      return view('treatmentGuides.show',compact('treatmentGuides'));
    else:
      return redirect()->away('http://'.$id);
    endif;
  }

  public function edit($id)
  {
    $treatmentguides = TreatmentGuides::find($id);        
    return view('treatmentGuides.edit',compact('treatmentguides'));
  }

  public function update(Request $request, $id)
  {

   $treatmentguides = TreatmentGuides::find($id);
   $data = $request->all();

   $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
   $this->validate($request, [
    'title' => 'required',
    'sub_title' => 'required',
    'status' => 'required|not_in:0',
    'detail' => 'required',
   /* 'guides_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',*/
  ]); 

   if(!empty($request->guides_image)):
    $imageName = time().'.'.$request->guides_image->extension();

    $path = public_path().'/images/TreatmentGuides';

    if (! File::exists($path)) {
      File::makeDirectory($path, $mode = 0777, true, true);
    }

    $request->guides_image->move(public_path('images/TreatmentGuides'), $imageName);

    $oldImg = $path.'/'.$treatmentguides->guides_image;

            if (File::exists($oldImg)) : // unlink or remove previous image from folder
            unlink($oldImg);
          endif;

          $data['guides_image'] = $imageName;              
        endif; 
        
        $treatmentguides->update($data);       
        
        toastr()->success('Treatment Guides updated successfully');
        return redirect()->route('treatmentGuides.index');
      } 
      
      public function destroy($id)
      {

        $treatmentGuides = TreatmentGuides::find($id);
        $treatmentGuides->delete();
        toastr()->success('Treatment Guides deleted successfully');
        return redirect()->route('treatmentGuides.index');
      }

    }