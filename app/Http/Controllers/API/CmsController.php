<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Cms;
use Validator;

   
class CmsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cms = Cms::all();
    
        return $this->sendResponse($cms, 'Cms retrieved successfully.');
    }

    public function show($id)
    {
        $cms = Cms::find($id);
  
        if (is_null($cms)) {
            return $this->sendError('Blog not found.');
        }
   
        return $this->sendResponse($cms, 'Cms retrieved successfully.');
    }
}