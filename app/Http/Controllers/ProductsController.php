<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Products;

class ProductsController extends Controller
{
     /**
     * @OA\Get (
     *     path="/api/products/all/{id}",
     *      operationId="all_products",
     *     tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *     summary="All products",
     *     description="All products",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */
    public function index($id)
    {
        $products = Products::where('id_entity','=',$id)->with('categories')->orderBy('id', 'DESC')->get();
        return response()->json(["data"=>$products],200);
    }

    /**
     * @OA\Get (
     *     path="/api/products/category/{id}",
     *      operationId="all_by_category_products",
     *     tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *     summary="All by category products",
     *     description="All by category products",
     *     @OA\Parameter(
     *         in="path",
     *         name="category_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */

     public function AllByCategory($category_id){
        try{
            $products = Products::with('categories')->where('category_id','=',$category_id)->get();
            return response()->json(["data"=>$products],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/products/{id}",
     *      operationId="all_by_id_products",
     *     tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *     summary="All by id products",
     *     description="All by id products",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results for model [App\\Models\\Cliente] #id"),
     *          )
     *      )
     * )
     */

    public function watch($id){
        try{
            $products = Products::with('categories')->where('id','=',$id)->get();
            return response()->json(["data"=>$products],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="store_products",
     *      tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *      summary="Store products",
     *      description="Store products",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name"},
     *            @OA\Property(property="category_id", type="number", format="number", example="1"),
     *            @OA\Property(property="name", type="string", format="string", example="name"),
     *            @OA\Property(property="description", type="string", format="string", example="description"),
     *            @OA\Property(property="price", type="number", format="number", example="0.00"),
     *            @OA\Property(property="image", type="string", format="string", example="image"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */

    public function register(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $uploadFile = $request->file('image');
            $file_name = $uploadFile->hashName();
            $uploadFile->storeAs('public/products', $file_name);
            $data['image'] = request()->getSchemeAndHttpHost().'/storage/products/'.$file_name;
        }
        $product = new Products($data);
        $product->save();
        return response()->json(["data"=>$product],200);
    }

     /**
     * @OA\Post(
     *      path="/api/products/{id}",
     *      operationId="update_products",
     *      tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *      summary="Update products",
     *      description="Update products",
    *       @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name"},
     *            @OA\Property(property="category_id", type="number", format="number", example="1"),
     *            @OA\Property(property="name", type="string", format="string", example="name"),
     *            @OA\Property(property="description", type="string", format="string", example="description"),
     *            @OA\Property(property="price", type="number", format="number", example="0.00"),
     *            @OA\Property(property="image", type="string", format="string", example="image"),
     *            @OA\Property(property="status", type="string", format="string", example="Disponible"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */

    public function update(Request $request, $id){
        try{
            $data = $request->all();
            if ($request->hasFile('image')) {
                $uploadFile = $request->file('image');
                $file_name = $uploadFile->hashName();
                $uploadFile->storeAs('public/products', $file_name);
                $data['image'] = request()->getSchemeAndHttpHost().'/storage/products/'.$file_name;
            }
            $product = Products::where('id',$id)->first();
            $product->update($data);
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

     /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      operationId="delete_products",
     *      tags={"Products"},
     *     security={{ "apiAuth": {} }},
     *      summary="Delete products",
     *      description="Delete products",
    *       @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response=200, description="Success",
     *          @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example=""),
     *             @OA\Property(property="data",type="object")
     *          )
     *       )
     *  )
     */

    public function delete($id){
        try{
            $product = Products::destroy($id);
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }
}
