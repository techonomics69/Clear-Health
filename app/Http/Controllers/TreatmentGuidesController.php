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

    $treatmentguides = TreatmentGuides::OrderBy('id', 'ASC')->paginate(50);

    echo "<pre>";
    print_r($treatmentguides);
    echo "</pre>";
    die();
        return view('treatmentGuides.index', compact('TreatmentGuides'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
       return view('treatmentGuides.create');
 //return redirect()->route('treatmentGuides.create');

    }


    public function store(Request $request)
    {

      /*echo "<pre>";
      print_r($request->all());
      echo "</pre>";
      die();*/
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

    }

    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    } 
    public function destroy($id)
    {

    }

    
    
  }