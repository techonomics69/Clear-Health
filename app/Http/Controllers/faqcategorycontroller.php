<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\faq_category;

class faqcategorycontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         // $this->middleware('permission:faq_category-list|faq-category-create|faq-category-edit|faq-category-delete', ['only' => ['index','show']]);
         // $this->middleware('permission:faq_category-create', ['only' => ['create','store']]);
         // $this->middleware('permission:faq_category-edit', ['only' => ['edit','update']]);
         // $this->middleware('permission:faq_category-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqs_category = faq_category::OrderBy('id', 'ASC')->paginate(50);
        
        return view('faq_category.index', compact('faqs_category'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faq_category.create');
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
            'title' => 'required',
            'status' => 'required|not_in:0'          
        ]);        

        $faqs_category = faq_category::create($request->all());
                
        toastr()->success('FAQ category created successfully');

        return redirect()->route('faqcategory.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = faq_category::find($id);  
              
        return view('faq_category.edit',compact('faq'));
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
            'status' => 'required|not_in:0'              
        ]); 
        
        $faq = faq_category::find($id);
        $faq->update($request->all());       
                
        toastr()->success('FAQ category updated successfully');

        return redirect()->route('faqcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = faq_category::find($id);
        $faq->delete();       
            
        toastr()->success('FAQ category deleted successfully');
        return redirect()->route('faqcategory.index');
    }
}
