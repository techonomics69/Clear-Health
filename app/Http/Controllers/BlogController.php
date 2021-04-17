<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Tag;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index','show']]);
         $this->middleware('permission:blog-create', ['only' => ['create','store']]);
         $this->middleware('permission:blog-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $blogs = Blog::OrderBy('id', 'ASC')->paginate(50);
        
        return view('blogs.index', compact('blogs'))->with('i', ($request->input('page', 1) -1) * 5);
    }

    public function create()
    {
        $tags = Tag::where('status','1')->pluck('tag', 'id')->toArray();

        return view('blogs.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'body' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000', 
            'author_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000', 
            'tags' => 'required|not_in:0',
            'hour' => 'required_without:minute',
            'minute' => 'required_without:hour',           
        ]);

        $imageName = '';
        if($request->hasfile('image'))
        {    
             
            foreach($request->file('image') as $file)
            {   
                $path = public_path().'/images/Blogs';
                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

                $originalName = str_replace('.'.$file->extension(), "", $file->getClientOriginalName());

                $name = $originalName."-".time()."-".date("his").'.'.$file->extension();
                $file->move(public_path('images/Blogs'), $name);  
                $imageName .= $name.',';  
            } 
        }
        $imageName = rtrim($imageName,",");
        

        //$imageName = time().'.'.$request->image->extension();
        $authorimageName = time().'.'.$request->author_image->extension();

        
        $author_image = public_path().'/images/BlogsAuthor';

        if (! File::exists($author_image)) {
            File::makeDirectory($author_image, $mode = 0777, true, true);
        }

        //$request->image->move(public_path('images/Blogs'), $imageName);
        $request->author_image->move(public_path('images/BlogsAuthor'), $authorimageName);

        $data = $request->all();

        $data['image'] = $imageName;
        $data['author_image'] = $authorimageName;
        $tags = implode(',', $request->tags);
        $data['tags'] = $tags;
        
        $blogs = Blog::create($data);
                
        toastr()->success('Blog created successfully');

        return redirect()->route('blog.index');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        $tags = Tag::pluck('tag', 'id')->toArray();
        return view('blogs.show',compact('blog','tags'));
    }

     public function edit($id)
    {
        $blog = Blog::find($id);  
        $date = date('Y-m-d', strtotime($blog->published_at)); 
        $tags = Tag::where('status','1')->pluck('tag', 'id')->toArray(); 
        $selectedTag = explode(",",$blog->tags);
        
        return view('blogs.edit',compact('blog', 'date', 'tags', 'selectedTag')); 
    }

    public function update(Request $request, $id)
    {
        

        $data = $request->all();
        

        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'body' => 'required',   
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',
            'author_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5000',       
            'tags' => 'required|not_in:0',
            'hour' => 'required_without:minute',
            'minute' => 'required_without:hour',    
        ]); 
        
        $imageName = '';
        if($request->hasfile('image'))
        {    
            
            $imgName1 = [];
            foreach($request->file('image') as $file)
            {   
                
                $path = public_path().'/images/Blogs';

                if (! File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $originalName = str_replace('.'.$file->extension(), "", $file->getClientOriginalName());

                $name = $originalName."-".time()."-".date("his").'.'.$file->extension();
                // echo $name."<br>";
                $file->move(public_path('images/Blogs'), $name);  
                array_push($imgName1, $name);
            } 
            // die();
            
            $imageName = implode(",", $imgName1);
        }
        $imageName = rtrim($imageName,",");
        $data['image'] = $imageName;
         if(!empty($request->author_image)):
            $authorimageName = time().'.'.$request->author_image->extension();

            $author_image = public_path().'/images/BlogsAuthor';


            if (! File::exists($author_image)) {
                File::makeDirectory($author_image, $mode = 0777, true, true);
            }

            $request->author_image->move(public_path('images/BlogsAuthor'), $authorimageName);

            //$oldImg = $author_image.'/'.$blog->author_image;

            // if (File::exists($oldImg)) : // unlink or remove previous image from folder
            //     unlink($oldImg);                
            // endif;

            $data['author_image'] = $authorimageName;              
        endif;

        if(!empty($request->tags)):
            $tags = implode(',', $request->tags);
            $data['tags'] = $tags;
        endif;
        // dd($data);
        unset($data['_blog']);
        unset($data['_method']);
        unset($data['_token']);
        if($data['image']==""){
            unset($data['image']);
        }
        if(isset($data['most_popular'])){
            if($data['most_popular']=="1"){
                $data['most_popular'] = '1';
            }else{
                $data['most_popular'] = null;
            }
        }else{
            $data['most_popular'] = null;
        }
        // dd($data);
        $blog = Blog::where('id',$id)->update($data);
        // $blog->save($data);       
                
        toastr()->success('Blog updated successfully');

        return redirect()->route('blog.index');
    }

     public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->delete();       
            
        toastr()->success('Blog deleted successfully');
        return redirect()->route('blog.index');
    }
}
