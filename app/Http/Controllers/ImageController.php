<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\MoreImage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $image=null;
    protected $more_image=null;

    public function __construct(Image $image,MoreImage $more_image){
        $this->image=$image;
        $this->more_image=$more_image;
    }


    public function index()
    {
        $images=$this->image->all();
        return view('image.index')->with('images',$images);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('image.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $rules=$this->image->getValidationRule();
        $request->validate($rules);
        $data=$request->all();
        if($request->pic){
            $file_name=uploadImage($request->pic,"images");
            if($file_name){
                $data['pic']=$file_name;
            }
        }
      
        // dd($data);
        $this->image->fill($data);
        $success=$this->image->save();

        if($success){
            if($request->more_images){
                foreach($request->more_images as $mi){
                    $file_name=uploadImage($mi,"more_images");
                    // dd($this->image->id);
                    if($file_name){
                        $temp=array(
                            'ref_img'=>$this->image->id,
                            'more_image'=>$file_name
                        );
                        MoreImage::insert($temp);
                    }
                }
            }
            return redirect()->route('image.index');
        }
      


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        return view('image.form')->with('image',$image);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        // dd($request->all());
        $rules=$this->image->getValidationRule();
        $request->validate($rules);

        $data=$request->all();
        // dd($request->all());

        if($request->del_img){
            if($image->pic && file_exists(public_path().'/uploads/images/'.$image->pic)){
                    unlink(public_path().'/uploads/images/'.$image->pic);
                    $data['pic']=null;
            }
        }

        $more_images=$image->more_images;
        foreach($more_images as $mi){
            $name="del_".$mi->id;
            // dd($request->$name);
            if($request->$name){
                if($mi->more_image && file_exists(public_path().'/uploads/more_images/'.$mi->more_image)){
                    unlink(public_path().'/uploads/more_images/'.$mi->more_image);
                    $mi->delete();
                }

            }
        }



        if ($request->pic) {
            $file_name=uploadImage($request->pic, "images");
            if ($file_name) {
                if (isset($image->image) && file_exists(public_path().'/uploads/images/'.$image->pic)) {
                    unlink(public_path().'/uploads/images/'.$image->pic);
                }
                $data['image']=$file_name;
            }
        }
        
      
        // dd($data);
      

            if($request->more_images){
                foreach($request->more_images as $mi){
                    $file_name=uploadImage($mi,"more_images");
                    // dd($this->image->id);
                        $temp=array(
                            'ref_img'=>$image->id,
                            'more_image'=>$file_name
                        );
                        MoreImage::insert($temp);
                
                }
            }

            $image->fill($data);
            $success=$image->save();
            // dd($success);
            if($success){
                return redirect()->route('image.index');
            }

            
        }
      

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        if($image->pic){
            if(file_exists(public_path().'/uploads/images/'.$image->pic)){
                unlink(public_path().'/uploads/images/'.$image->pic);
            }

        }
        $more_images=$image->more_images;
        // dd($more_images);
        if($more_images){
            foreach($more_images as $img){
                if(file_exists(public_path().'/uploads/more_images/'.$img->more_image)){
                    unlink(public_path().'/uploads/more_images/'.$img->more_image);
                }
                $img->delete();
            }
        }
        $success=$image->delete();
        if($success){
            return redirect()->route('image.index');
        }
    }
}
