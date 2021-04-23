<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cms;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:cms-list|cms-create|cms-edit|cms-delete', ['only' => ['index','show']]);
         $this->middleware('permission:cms-create', ['only' => ['create','store']]);
         $this->middleware('permission:cms-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:cms-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cms = Cms::OrderBy('id', 'ASC')->paginate(50);

        return view('cms.index', compact('cms'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, [
            'title' => 'required',
           /* 'url' => ['regex:'.$regex,'nullable'],*/
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
            'status' => 'required',
            'description' => 'required'
        ],[

        ]
        );        

        $cms = Cms::create($request->all());
                
        toastr()->success('CMS created successfully');

        return redirect()->route('cms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cms = Cms::find($id);
        
        if(isset($cms)):
            return view('cms.show',compact('cms'));
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
        $cms = Cms::find($id);        
        return view('cms.edit',compact('cms')); 
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
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, [
            'title' => 'required',
            /*'url' => ['regex:'.$regex,'nullable'],*/
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
            'status' => 'required',
            'description' => 'required'
        ]);  
        
        $cms = Cms::find($id);
        $cms->update($request->all());       
                
        toastr()->success('CMS updated successfully');

        return redirect()->route('cms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cms = Cms::find($id);
        $cms->delete();
        toastr()->success('CMS deleted successfully');
        return redirect()->route('cms.index');
    }
}
