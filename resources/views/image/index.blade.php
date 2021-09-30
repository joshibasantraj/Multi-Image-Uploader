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
            <h1 class="text-center">All images</h1>
            <a href="{{ route('image.create') }}" class="btn btn-primary pull-right">Upload Image</a>
            <table class="table">
                <thead>
                    <th>Sno</th>
                    <th>Image</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @if(isset($images))
                        @foreach($images as $key=>$image)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>
                                    @if($image->pic)
                                    <img src="{{ asset('uploads/images/'.$image->pic) }}" style="max-width:100px;" alt="" class="img img-thumbnail img-responsive">
                                    @else
                                     No Image Found
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('image.edit',@$image->id) }}" class="btn btn-success">Edit</a>
                                   
                                    <form action="{{ route('image.destroy',$image->id) }}" onclick="return confirm('Are you Sure To Delete This Image ?')" method="post">
                                        @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">
                                                Delete
                                            </button>
                                     </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>


            </div>
        </div>
   

    </div>
   
    
</body>
</html>