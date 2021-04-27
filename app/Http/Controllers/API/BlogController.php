<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Blog;
use App\Models\Tag;
use DB;
use URL;
use Validator;

   
class BlogController extends BaseController
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->tags==''){
            $blogs = Blog::where('most_popular','false','image')->orWhereNull('most_popular')->orderBY('id','desc')->get();
        }else if($request->tags=='all'){
            $blogs = Blog::where('most_popular','false','image')->orWhereNull('most_popular')->orderBY('id','desc')->get();       
        }else{
            $searchTag = $request->tags;
            // DB::enableQueryLog();
            $blogs = Blog::where('most_popular','false','image')->orWhereNull('most_popular')->where('tags','like','%' . $searchTag . '%')->orderBy('id','desc')->get();    
            // dd($blogs);
            // dd(DB::getQueryLog());
        }
        if(count($blogs)>0){
            foreach ($blogs as $key => $value) {
                if(strpos($value->image, ",")!==false){
                    $images = explode(",", $value->image);
                    $imgs = [];
                    if(count($images)>0){
                        foreach ($images as $key1 => $value1) {   
                            array_push($imgs, URL::to('/public/images/Blogs/'.$value1).',');
                        }
                        
                    }
                    $blogs[$key]['images'] = rtrim($imgs[0],",");
                }else{
                    $blogs[$key]['images'] = URL::to('/public/images/Blogs/'.$blogs[$key]->image);    
                }
                $blogs[$key]['author_image'] = URL::to('/public/images/BlogsAuthor/'.$value->author_image);
                $desc = explode(" ", $blogs[$key]['body']);
                $bodyText = '';
                foreach ($desc as $bkey => $body) {
                    if($bkey==30){
                        $bodyText.='.....';
                        break;
                    }else{
                        $bodyText.=$body." ";
                    }
                }
                $blogs[$key]['body'] = $bodyText;
                $tags = Tag::pluck('tag', 'id')->toArray();
                $tagId = explode(",",$value->tags);
                $tagArray = [];
                foreach ($tags as $tagkey => $tagvalue) {
                    foreach ($tagId as $tagidkey => $tagidvalue) {
                        if($tagidvalue == $tagkey){
                            array_push($tagArray, $tagvalue);
                        }
                    }
                }
                $tagname = implode(", ",$tagArray);
                $blogs[$key]['tagname'] = $tagname;
            }
        }
        
        return $this->sendResponse($blogs, 'Blogs retrieved successfully.');
    }

    public function most_popular(Request $request){
        $blogs = Blog::where('most_popular','true','image')->orderBY('id','desc')->get();
        if(count($blogs)>0){
            foreach ($blogs as $key => $value) {
                if(strpos($value->image, ",")!==false){
                    $images = explode(",", $value->image);
                    $imgs = [];
                    if(count($images)>0){
                        foreach ($images as $key1 => $value1) {   
                            array_push($imgs, URL::to('/public/images/Blogs/'.$value1).',');
                        }
                        
                    }
                    $blogs[$key]['images'] = rtrim($imgs[0],",");
                }else{
                    $blogs[$key]['images'] = URL::to('/public/images/Blogs/'.$blogs[$key]->image);    
                }
                $blogs[$key]['author_image'] = URL::to('/public/images/BlogsAuthor/'.$value->author_image);
            }
        }
        return $this->sendResponse($blogs, 'Blogs retrieved successfully.');
    }

    public function show($id)
    {
        $blog = Blog::find($id);
        $other = Blog::where('id','!=',$id)->get();
  
        if (is_null($blog)) {
            return $this->sendError('Blog not found.');
        }else{
            $tags = db::table('tags')->select('tag')->whereIn('id',explode(",", $blog['tags']))->get();
            $alltags = db::table('tags')->get();
            $tagsnames = "";
            if(count($tags)>0){
                foreach($tags as $key => $value) {
                    $tagsnames .= $value->tag.",";
                }
            }
            $tagsnames = rtrim(str_replace("#", "", $tagsnames),",");
            $blog['tagsnames'] = $tagsnames;
            if(strpos($blog['image'], ",")!==false){
                $images = explode(",", $blog['image']);
                $imgs = '';
                if(count($images)>0){
                    foreach ($images as $key => $value) {
                        $imgs.=URL::to('/public/images/Blogs/'.$value).',';
                    }
                    $imgs = rtrim($imgs,',');
                }
                $blog['images'] = $imgs;
            }else{
                $blog['images'] = URL::to('/public/images/Blogs/'.$blog['image']);    
            }
            
            $blog['author_image'] = URL::to('/public/images/BlogsAuthor/'.$blog['author_image']);
            if(count($other)>0){
                foreach ($other as $key => $value) {
                    $tags1 = db::table('tags')->select('tag')->whereIn('id',explode(",", $value->tags))->get();
                    $tagsnames1 = "";
                    if(count($tags1)>0){
                        foreach($tags1 as $key1 => $value1) {
                            $tagsnames1 .= $value1->tag.",";
                        }
                    }
                    $tagsnames1 = rtrim(str_replace("#", "", $tagsnames1),",");
                    $other[$key]['tagsnames'] = $tagsnames1; 

                    if(strpos($other[$key]['image'], ",")!==false){
                        $images = explode(",", $other[$key]['image']);
                        $imgs = '';
                        if(count($images)>0){
                            $imgs = URL::to('/public/images/Blogs/'.$images[0]);
                        }
                        $other[$key]['images'] = $imgs;
                    }else{
                        $other[$key]['images'] = URL::to('/public/images/Blogs/'.$value->image);
                    }
                    
                }
                
            }
            if(count($alltags)>0){
                $all = '';
                foreach ($alltags as $key => $value) {
                    $all .=str_replace("#", "", $value->tag).',';
                }
                $all = rtrim($all,',');
                $blog['allTags'] = $all;
            }
            $blog['otherBlogs'] = (count($other)>0) ? $other : array();
            return $this->sendResponse($blog, 'Blog retrieved successfully.');    
        }
    }

    public function getAllTags(Request $request){
        $alltags = db::table('tags')->where('status','1')->get();
        if(count($alltags)>0){
            foreach ($alltags as $key => $value) {
                $alltags[$key]->tag = str_replace("#", "", $value->tag);
            }
        }
        return $this->sendResponse($alltags, 'Tags retrieved successfully.');   
    }
}