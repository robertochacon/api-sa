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
     *     path="/api/orders/total",
     *      operationId="all_total",
     *     tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *     summary="All orders total",
     *     description="All orders total",
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
    public function total()
    {
        try{

            $data[] = DB::select("SELECT SUM(total) as day, COUNT(id) as total_day FROM orders WHERE DATE(created_at) = CURDATE() AND status = 'Facturada'");
            $data[] = DB::select("SELECT SUM(total) as week, COUNT(id) as total_week FROM orders WHERE YEARWEEK(`created_at`, 1) = YEARWEEK(CURDATE(), 1) AND status = 'Facturada'");
            $data[] = DB::select("SELECT SUM(total) as month, COUNT(id) as total_month FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) AND status = 'Facturada'");

            return response()->json(["data"=>$data],200);
        }catch (Exception $e) {
            return response()->json(["data"=>[]],200);
        }
    }

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
                $item['products'] = json_decode($item['products'], TRUE);
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
                $item['products'] = json_decode($item['products'], TRUE);
                $data[] = $item;
            }
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
