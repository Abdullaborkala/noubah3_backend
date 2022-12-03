<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required',
            'discription' => 'required',
            'image' => 'file|required',
        ]);

        
        $file = $request->file('image');

        //File Name
        $file->getClientOriginalName();

        //Display File Real Path
        $file->getRealPath();

        //Display File Size
        $file->getSize();

        //Display File Mime Type
        $file->getMimeType();

        //Move Uploaded File
        $destinationPath = 'uploads/';
        $filename = uniqid(). '.' .$file->getClientOriginalName();
        Storage::disk('local')->put($destinationPath.$filename,file_get_contents($file));


        Post::create([
            'title'=> $validateData['title'],
            'discription'=> $validateData['discription'],
            'image'=> $destinationPath.''.$filename
        ]);

        return response([
            'success' => true,
            'message' => 'Data added'
        ], 200);
    }
    public function show(Request $request)
    {
        $params = $request->all();
        $per_page = isset($params['per_page']) ? $params['per_page']: 10;
        $searchKey = isset($params['searchKey']) ? $params['searchKey']: '';

        if(isset($params['searchKey']) && isset($params['searchKey']) != ''){
            $post = Post::where('title', 'LIKE' , '%'.$searchKey.'%')
                                    ->orWhere('discription', 'LIKE' , '%'.$searchKey.'%')
                                    ->paginate($per_page)->toArray();
        }else{
            $post = Post::paginate($per_page)->toArray();
        }
        
        if(!$post){
            return response(["message" => 'No data found!']);
        }

        $res = [];
        foreach($post['data'] as $arr){
            $arr['image'] = asset('/public/storage/app').'/'.$arr['image'];
            $res[] = $arr;
        }

        return response([
            'success' => true,
            'data' => $arr
        ],200);
    }
    public function edit($id)
    {
        $post = Post::find($id);
        if(!$post){
            return response(["message" => 'No data found!']);
        }
        return response($post);
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if(!$post){
            return response(["message" => 'No data found!'], 200);
        }
        
        Post::where('id', $id)->update($request->all());
        
        return response([
            "status" => "Success", 
            "message" => "Data updated"
        ], 200);
    }
    public function destroy($id)
    {
        Post::where('id', $id)->delete();

        return response([
            "status" => "Success", 
            "message" => "Data deleted"
        ], 200);
    }
}
