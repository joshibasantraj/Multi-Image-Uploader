<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-sm-8 mt-3">
            <h1 class="text-center">Registration Form</h1>
            @if(@$image)
                <form action="{{ route('image.update',$image->id) }}" class="form" method="POST" enctype="multipart/form-data">
                @method('PUT')   
                @csrf
            @else
                <form action="{{ route('image.store') }}" class="form" method="POST" enctype="multipart/form-data">
                    @csrf
            @endif  


                <div class="form-group row">
                    <div class="col-sm-3">
                          <label for="image">Upload Image:</label>
                    </div>
                    <div class="col-sm-7">
                        <input type="file"  name="pic" id="image"><br>
                        @if(@$image->pic)
                        <div class="pull-right">
                             <img src="{{ asset('uploads/images/'.$image->pic) }}" style="max-width:150px;" alt="" class="img img-thumbnail img-responsive"><br>
                            <input type="checkbox" name="del_img"> DELETE
                        </div>
                           
                        @endif
                    </div>
                    
                </div>

                
                <div class="form-group row">
                    <div class="col-sm-3">
                          <label for="more_image">More Image:</label>
                    </div>
                    <input type="file" class="col-sm-7" name="more_images[]" id="more_image" multiple accept="image/*"><br>
                    @if(@$image->more_images)
                        <div class="pull-right">
                            @foreach($image->more_images as $key=>$img)
                                <div>
                                      <img src="{{ asset('uploads/more_images/'.@$img->more_image) }}" alt="" style="max-width:150px;" class="img img-responsive img-thumbnail">
                                      <br><input type="checkbox" name="del_{{ $img->id }}"> DELETE
                                    </div>                         
                            @endforeach
                        </div>
                    @endif
                </div>

                
                
             



               <div class="form-group row">
                   <div class="col-sm-3">
                        <a href="{{ route('image.index') }}" class="btn btn-primary">Go Back</a>
                   </div>
                   <input type="submit" class="btn btn-success"><br>
               </div>

                
              





        </form>

            </div>
        </div>
   

    </div>
   
    
</body>
</html>