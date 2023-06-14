<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Products;

class CategoriesController extends Controller
{
     /**
     * @OA\Get (
     *     path="/api/categories",
     *      operationId="all_categories",
     *     tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *     summary="All categories",
     *     description="All categories",
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
    public function index()
    {
        $categories = Categories::orderBy('id', 'DESC')->get();
        return response()->json(["data"=>$categories],200);
    }

         /**
     * @OA\Get (
     *     path="/api/categories/products",
     *      operationId="all_categories_with_products",
     *     tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *     summary="All categories with products",
     *     description="All categories with products",
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
    public function indexWithProducts()
    {
        $categories = Categories::orderBy('id', 'DESC')->get();
        $data = [];
        foreach ($categories as $item) {
            $item['products'] = Products::where('category_id',$item['id'])->get()->makeHidden(['category_id']);
            $data['category'][] = $item;
        }
        return response()->json(["data"=>$data],200);
    }

    /**
     * @OA\Get (
     *     path="/api/categories/{id}",
     *      operationId="all_by_id_categories",
     *     tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *     summary="All by id categories",
     *     description="All by id categories",
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
            $categories = Categories::where('id','=',$id)->get();
            return response()->json(["data"=>$categories],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/categories",
     *      operationId="store_categories",
     *      tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *      summary="Store categories",
     *      description="Store categories",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name"},
     *            @OA\Property(property="name", type="string", format="string", example="name"),
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

    public function register()
    {
        $category = new Categories(request()->all());
        $category->save();
        return response()->json(["data"=>$category],200);
    }

     /**
     * @OA\Put(
     *      path="/api/categories/{id}",
     *      operationId="update_categories",
     *      tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *      summary="Update categories",
     *      description="Update categories",
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
     *            @OA\Property(property="name", type="string", format="string", example="name"),
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
            $category = Categories::find($id);
            $category->update($request->all());
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

     /**
     * @OA\Delete(
     *      path="/api/categories/{id}",
     *      operationId="delete_categories",
     *      tags={"Categories"},
     *     security={{ "apiAuth": {} }},
     *      summary="Delete categories",
     *      description="Delete categories",
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
            $category = Categories::destroy($id);
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }
}
