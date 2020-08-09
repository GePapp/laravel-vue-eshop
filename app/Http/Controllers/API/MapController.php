<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Map;

class MapController extends Controller
{
  /**
   * Create api auth.
   *
   * @return void
   */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $maps = Map::paginate(2);
    }

    // search input
    public function search(){
      // if condition to check that search input is't empty and the axios request has a q variable
        if ($search = \Request::get('q')) {
            $maps = Map::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%")
                        ->orWhere('description','LIKE',"%$search%")
                        ->orWhere('imageName','LIKE',"%$search%")
                        ->orWhere('price','LIKE',"%$search%");
            })->paginate(2);
        }else{
            $maps = Map::paginate(2);
        }
        return $maps;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
        'title' => 'required|string|max:80',
        'description' => 'required',
        'imageName' => 'required',
        'price' => 'required',
      ]);

      // take from base64 picture img extension, .png or .jpg and merge with time name
      $name = time().'.' . explode('/', explode(':', substr($request->imageName, 0, strpos($request->imageName, ';')))[1])[1];
      // save base64 picture in public folder with image intervention: \Image::make(..)
      \Image::make($request->imageName)->save(public_path('img/maps/').$name);
      // push new photo name in $request array
      $request->merge(['imageName' => $name]);

      return Map::create([
        'title' => $request['title'],
        'description' => $request['description'],
        'imageName' => $request['imageName'],
        'price' => $request['price'],
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      $map = Map::findOrFail($id);

     $request->validate([
        'title' => 'required|string|max:80',
        'description' => 'required',
        'imageName' => 'required',
        'price' => 'required',
      ]);
      // $currentPhoto is the rezent photo from database
      $currentPhoto = $map->imageName;
      // pick image format (png or jpg ...) and merge it to new image date name
      if($request->imageName != $currentPhoto) {
        // take from base64 picture img extension, .png or .jpg and merge with time name
        $name = time().'.' . explode('/', explode(':', substr($request->imageName, 0, strpos($request->imageName, ';')))[1])[1];
        // save base64 picture in pablic folder with image intervention: \Image::make(..)
        \Image::make($request->imageName)->save(public_path('img/maps/').$name);
        // delete old photo if new photo entry
        $mapPhoto = public_path('img/maps/').$currentPhoto;
        if(file_exists($mapPhoto)){
            @unlink($mapPhoto);
        }
        // push new photo name in $request array
        $request->merge(['imageName' => $name]);
      };

      $map->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $map = Map::findOrFail($id);
      $map->delete();
      $currentPhoto = $map->imageName;
      $mapPhoto = public_path('img/maps/').$currentPhoto;
      if(file_exists($mapPhoto)){
          @unlink($mapPhoto);
      }
      return ['message' => 'Map Daleted'];
    }
}
