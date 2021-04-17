<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\File;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:testimonial-list|testimonial-create|testimonial-edit|testimonial-delete', ['only' => ['index','show']]);
         $this->middleware('permission:testimonial-create', ['only' => ['create','store']]);
         $this->middleware('permission:testimonial-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $testimonials = Testimonial::OrderBy('id', 'ASC')->paginate(50);
        
        return view('testimonials.index', compact('testimonials'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',            
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',         
        ]);        
        $data = $request->all();
        $data['image'] = '';
        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Testimonials';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Testimonials'), $imageName);

            $data['image'] = $imageName;
        endif;

        $testomonial = Testimonial::create($data);
                
        toastr()->success('Testimonial created successfully');

        return redirect()->route('testimonials.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonial = Testimonial::find($id);
        
        return view('testimonials.show',compact('testimonial'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonial::find($id);  
              
        return view('testimonials.edit',compact('testimonial')); 
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
            'name' => 'required',
            'content' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',                        
        ]); 
        
        $testimonial = Testimonial::find($id);

        $data = $request->all();
        $data['image'] = $testimonial->image;
        if(!empty($request->image)):
            $imageName = time().'.'.$request->image->extension();

            $path = public_path().'/images/Testimonials';

            if (! File::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $request->image->move(public_path('images/Testimonials'), $imageName);

            if(!empty($testimonial->image)):
                $oldImg = $path.'/'.$testimonial->image;

                if (File::exists($oldImg)) : // unlink or remove previous image from folder
                    unlink($oldImg);                             
                endif;
            endif;

            $data['image'] = $imageName;
        endif;

        $testimonial->update($data);       
                
        toastr()->success('Testimonial updated successfully');

        return redirect()->route('testimonials.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        $testimonial->delete();     

        // unlink or remove previous image from folder
        $path = public_path().'/images/Testimonials';
        $oldImg = $path.'/'.$testimonial->image;
            if (File::exists($oldImg)) : 
                unlink($oldImg);
            endif;  
            
        toastr()->success('Testimonial deleted successfully');
        return redirect()->route('testimonials.index');
    }
}
