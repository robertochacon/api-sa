<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Orders;
use App\Events\OrderEvent;

class OrdersController extends Controller
{
     /**
     * @OA\Get (
     *     path="/api/orders",
     *      operationId="all_orders",
     *     tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *     summary="All orders",
     *     description="All orders",
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
        try{
            $orders = Orders::all();
            $data = [];
            foreach ($orders as $item) {
                $ids_products = json_decode($item['products'], TRUE);
                $item['products'] = Products::with('categories')->whereIn('id',$ids_products)->get()->makeHidden(['category_id','image']);
                $data[] = $item;
            }
            return response()->json(["data"=>$data],200);
        }catch (Exception $e) {
            return response()->json(["data"=>[]],200);
        }
    }

    /**
     * @OA\Get (
     *     path="/api/orders/{id}",
     *      operationId="all_by_id_orders",
     *     tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *     summary="All by id orders",
     *     description="All by id orders",
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
            $orders = Orders::where('id','=',$id)->get();
            $data = [];
            foreach ($orders as $item) {
                $ids_products = json_decode($item['products'], TRUE);
                $item['products'] = Products::with('categories')->whereIn('id',$ids_products)->get()->makeHidden(['category_id','image']);
                $data['order'][] = $item;
            }
            return response()->json(["data"=>$data],200);
            return response()->json(["data"=>$data],200);
        }catch (Exception $e) {
            return response()->json(["data"=>[]],200);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/orders",
     *      operationId="store_orders",
     *      tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *      summary="Store orders",
     *      description="Store orders",
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"name"},
     *            @OA\Property(property="products", type="string", format="string", example="[1,2,3]"),
     *            @OA\Property(property="table", type="number", format="string", example="2"),
     *            @OA\Property(property="total", type="number", format="string", example="100.00"),
     *            @OA\Property(property="note", type="number", format="number", example="note"),
     *            @OA\Property(property="in_restaurant", type="boolean", format="boolean", example="true"),
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
        $order = new Orders(request()->all());
        $order->save();
        $msg['msg'] = 'order_insert';
        $msg['order'] = $order;
        event(new OrderEvent($msg));
        return response()->json(["data"=>$order],200);
    }

     /**
     * @OA\Put(
     *      path="/api/orders/{id}",
     *      operationId="update_orders",
     *      tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *      summary="Update orders",
     *      description="Update orders",
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
     *            @OA\Property(property="products", type="string", format="string", example="[1,2,3]"),
     *            @OA\Property(property="table", type="number", format="string", example="2"),
     *            @OA\Property(property="total", type="number", format="string", example="100.00"),
     *            @OA\Property(property="note", type="number", format="number", example="note"),
     *            @OA\Property(property="status", type="string", format="string", example="Completada"),
     *            @OA\Property(property="in_restaurant", type="boolean", format="boolean", example="true"),
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
            $order = Orders::find($id);
            $order->update($request->all());
            $msg['msg'] = 'order_update';
            $msg['order'] = $order;
            event(new OrderEvent($msg));
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }

     /**
     * @OA\Delete(
     *      path="/api/orders/{id}",
     *      operationId="delete_orders",
     *      tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *      summary="Delete orders",
     *      description="Delete orders",
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
            $order = Orders::destroy($id);
            $msg['msg'] = 'order_delete';
            event(new OrderEvent($msg));
            return response()->json(["data"=>"ok"],200);
        }catch (Exception $e) {
            return response()->json(["data"=>"none"],200);
        }
    }
}
