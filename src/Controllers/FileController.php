<?php

namespace CMS\Controllers;

use CMS\Models\File;
use CMS\Models\Page;
use CMS\Models\PageDetail;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function foo\func;

class FileController extends Controller
{

    public function index(){
//        $limit = "12";
//        $start = request()->get("start");
//        if(  is_nan($start) ){
//            $start = 0;
//        }
//        $files = File::offset($start)->limit($limit)->get()->toJson();
        $files = File::all()->toJson();
        return response()->json($files);
    }

    public function getFilePage(){
        $key = request()->post("key");
        $page = request()->post("page");
        $files = File::join("file_page","files.id","=","file_page.file_id")
            ->where("file_page.page_id",$page)
            ->where("file_page.key", $key)
            ->select("files.id")
            ->get();
        return response()->json($files);
    }

    public function getFilePageDetail(){
        $key = request()->post("key");
        $pageDetail = request()->post("pageDetail");
        $files = File::join("file_page_detail","files.id","=","file_page_detail.file_id")
            ->where("file_page_detail.page_detail_id",$pageDetail)
            ->where("file_page_detail.key", $key)
            ->select("files.id")
            ->get();
        return response()->json($files);
    }

    public function saveFilePage(){
        $key = request()->post("key");
        $page = request()->post("page");
        $files = request()->post("files");
        DB::table('file_page')
            ->where("key",$key)
            ->where("page_id",$page)->delete();
        foreach($files as $f){
            DB::table('file_page')
                ->insert([
                        'key' => $key,
                        'page_id' => $page,
                        'file_id' => $f
                    ]
                );
        }
        return response()->json($files);
    }

    public function saveFilePageDetail(){
        $key = request()->post("key");
        $pageDetail = request()->post("pageDetail");
        $files = request()->post("files");
        DB::table('file_page_detail')
            ->where("key",$key)
            ->where("page_detail_id",$pageDetail)->delete();
        foreach($files as $f){
            DB::table('file_page_detail')
                ->insert([
                    'key' => $key,
                    'page_detail_id' => $pageDetail,
                    'file_id' => $f
                ]
            );
        }

        return response()->json($files);
    }

    public function uploadFile(){
        $rules = [
            'file' => 'required|mimes:jpeg,png,jpg,bmp,svg,pdf,doc,docx,xls,xlsx,ppt,pptx|max:3000',
        ];
        $f = request()->file("file");
        $valid = Validator::make(['file' => $f],$rules);
        if($valid->fails()) {

        } else {
            $fname = Str::slug(basename($f->getClientOriginalName(), '.'.$f->getClientOriginalExtension())).'_'.time();
            $fextension = $f->getClientOriginalExtension();
            $ffull = $fname.".".$fextension;
            try
            {
                $f->storePubliclyAs("public/uploads",$ffull);
                $file = new File();
                $file->name =  $fname;
                $file->extension = $fextension;
                $file->path = 'uploads/'.$ffull;
                $file->mimetype = $f->getClientMimeType();
                $file->size = $f->getSize();
                $file->status = 1;
                $file->save();
            }
            catch(\Exception $e)
            {
                dd($e);
            }
        }

    }

//    public function store($file,$file_name=null,$page_detail_id=null,$page_id=null,$key)
//    {
//        try
//        {
//            $file->storePubliclyAs("public/uploads/images",$file_name.'.'.$file->getClientOriginalExtension());
//        }
//        catch(\Exception $e)
//        {
//            return redirect()->back();
//        }
//
//        $f = new File();
//        $f->name =  $file_name;
//        $f->extension = $file->getClientOriginalExtension();
//        $f->path = 'uploads/images/'.$f->name.'.'.$f->extension;
//        $f->mimetype = $file->getClientMimeType();
//        $f->size = $file->getSize();
//        $f->status =1;
//        $f->save();
//        if ($page_detail_id)
//        {
//            $this->updatePivot($page_detail_id,null,$key);
//            $f->page_detail()->attach($page_detail_id,['key' => $key]);
//        }else{
//            $this->updatePivot(null,$page_id,$key);
//            $f->page()->attach($page_id,['key' => $key]);
//        }
//    }
//
//    public function validateImageFile($file)
//    {
//        $input = ['file' => $file];
//        $validator = Validator::make($input, [
//            'file' => 'required|mimes:jpeg,png,jpg|max:1024',
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//        return true;
//    }
//
//    public function validatePdfFile($file)
//    {
//        $input = ['file' => $file];
//        $validator = Validator::make($input, [
//            'file' => 'required|mimes:pdf|max:1024',
//        ]);
//        if ($validator->fails()) {
//            return redirect()->back()->withErrors($validator)->withInput();
//        }
//        return true;
//    }
//
//    public function updatePivot($page_detail_id=null,$page_id=null,$key)
//    {
//        if ($page_detail_id)
//        {
//            $detail = PageDetail::where('id',$page_detail_id)->whereHas('files', function($query) use ($key,$page_detail_id){
//                $query->where('key',$key);
//            })->first();
//            if($detail)
//            {
//                $detail->files()->wherePivot('key','=',$key)->detach();
//            }
//        }else{
//            $page = Page::where('id',$page_id)->whereHas('files' , function($query) use ($key,$page_id){
//               $query->where('key',$key);
//            })->first();
//            if ($page)
//            {
//                $page->files()->wherePivot('key',$key)->detach();
//            }
//        }
//    }
//
//    public function ajax(Request $request)
//    {
//        $detail_id = $request->page_detail_id;
//        $file_id = $request->file_id;
//        $key = $request->key;
//        $file = File::where('id',$file_id)->whereHas('page_detail',function ($query) use ($key,$detail_id){
//           $query->where('key',$key)->where('page_detail_id',$detail_id);
//        })->first();
//        if ($file)
//        {
//            $file->page_detail()->wherePivot('key',$key)->detach();
//        }else{
//            $file = File::find($file_id);
//            $file->page_detail()->attach($detail_id,['key' => $key]);
//        }
//        return response()->json(["Message" => "Ok"]);
//    }

    public function storeCategoryFile($file)
    {
        $file_name = "category".rand(10000,1000000);
        try
        {
            $file->storePubliclyAs("public/uploads/images/categories/",$file_name.'.'.$file->getClientOriginalExtension());
        }
        catch(\Exception $e)
        {
            return redirect()->back();
        }

        $f = new File();
        $f->name =  $file_name;
        $f->extension = $file->getClientOriginalExtension();
        $f->path = 'uploads/images/categories/'.$f->name.'.'.$f->extension;
        $f->mimetype = $file->getClientMimeType();
        $f->size = $file->getSize();
        $f->status =1;
        $f->save();

        return $f->path;
    }

}
