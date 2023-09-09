<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get (
     *     path="/api/users",
     *      operationId="all_users",
     *     tags={"Users"},
     *     security={{ "apiAuth": {} }},
     *     summary="All users",
     *     description="All users",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="name", type="string", example="example"),
     *              @OA\Property(property="role", type="string", example="user"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
     *     ),
    *      @OA\Response(
    *          response=401,
    *          description="Unauthorized",
    *          @OA\JsonContent()
    *       ),
     *      @OA\Response(
     *          response=404,
     *          description="NOT FOUND",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="No query results"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        $users = User::with('entity')->get();
        return response()->json(["data"=>$users],200);
    }

    /**
     * @OA\Get (
     *     path="/api/users/{id}",
     *      operationId="watch_users",
     *     tags={"Users"},
     *     security={{ "apiAuth": {} }},
     *     summary="Get user",
     *     description="Get user",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="name", type="string", example="Roberto"),
     *              @OA\Property(property="role", type="string", example="user"),
     *              @OA\Property(property="created_at", type="string", example="2023-02-23T00:09:16.000000Z"),
     *              @OA\Property(property="updated_at", type="string", example="2023-02-23T12:33:45.000000Z")
     *         )
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
            $user = User::find($id);
            return response()->json(["data"=>$user],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"fail"],200);
        }
    }

    /**
     * @OA\Post (
     *     path="/api/users/{id}",
     *      operationId="update_user",
     *     tags={"Users"},
     *     security={{ "apiAuth": {} }},
     *     summary="Update user",
     *     description="Update user",
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Property(property="email", type="string", example="example@gmail.com"),
     *              @OA\Property(property="name", type="string", example="Roberto"),
     *              @OA\Property(property="role", type="string", example="user"),
     *         ),
     *      ),
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

    public function update(Request $request, $id){
        try{
            $user = User::where('id',$id)->first();
            $user->update($request->all());
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="delete_user",
     *      tags={"Users"},
     *     security={{ "apiAuth": {} }},
     *      summary="Delete user",
     *      description="Delete user",
     *    @OA\Parameter(
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
            $user = User::destroy($id);
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }
}
