<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Faq;
use App\Models\faq_category;
use Validator;

   
class FaqController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category)
    {
        $faqs = Faq::where('category_id',$category)->where('status','1')->get();

        //This is coded by daxit, please do not remove this
        if(count($faqs)>0){
            foreach ($faqs as $key => $value) {
                $faqs[$key]['answer'] = ($value['answer']);
            }
        }
        
        return $this->sendResponse($faqs, 'Faqs retrieved successfully.');
    }

    public function show($id)
    {
        $faq = Faq::find($id);
  
        if (is_null($faq)) {
            return $this->sendError('Faq not found.');
        }
   
        return $this->sendResponse($faq, 'Faq retrieved successfully.');
    }

    public function getFaqCategoryList(Request $request){
        $faqcategory = faq_category::where('status','1')->get();
        return $this->sendResponse($faqcategory,'Category Retrived successfully');
    }
}