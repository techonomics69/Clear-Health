<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\faq_category;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:faq-list|faq-create|faq-edit|faq-delete', ['only' => ['index','show']]);
         $this->middleware('permission:faq-create', ['only' => ['create','store']]);
         $this->middleware('permission:faq-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:faq-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqs = Faq::OrderBy('id', 'ASC')->paginate(50);
        
        return view('faqs.index', compact('faqs'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = faq_category::where('status','1')->pluck('title', 'id')->toArray();
        return view('faqs.create',compact('category'));
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
            'question' => 'required',
            'category_id' => 'required',
            'answer' => 'required',  
            'status' => 'required|not_in:0'          
        ]);        

        $faqs = Faq::create($request->all());
                
        toastr()->success('FAQ created successfully');

        return redirect()->route('faqs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $faq = Faq::find($id);

        if(isset($faq)):
            return view('faqs.show',compact('faq'));
        else:
            return redirect()->away('http://'.$id);
        endif;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = Faq::find($id);  
        $category = faq_category::where('status','1')->pluck('title', 'id')->toArray();      
        return view('faqs.edit',compact('faq','category')); 
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
            'question' => 'required',
            'category_id' => 'required',
            'answer' => 'required',
            'status' => 'required|not_in:0'              
        ]); 
        
        $faq = Faq::find($id);
        
        $faq->update($request->all());       
                
        toastr()->success('FAQ updated successfully');

        return redirect()->route('faqs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = Faq::find($id);
        $faq->delete();       
            
        toastr()->success('FAQ deleted successfully');
        return redirect()->route('faqs.index');
    }
}
