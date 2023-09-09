<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\Categories;
use App\Models\User;
use App\Models\Orders;
use App\Events\OrderEvent;
use Carbon\Carbon;

class OrdersController extends Controller
{
    
    /**
     * @OA\Get (
     *     path="/api/orders/total/{id}",
     *      operationId="all_total",
     *     tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *     summary="All orders total",
     *     description="All orders total",
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
    public function total($id)
    {
        try{

            $data['orders']['today'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereDate('created_at', Carbon::today())->count();
            $data['orders']['total_today'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereDate('created_at', Carbon::today())->sum('total');

            $data['orders']['month'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereMonth('created_at', Carbon::now()->month)->count();
            $data['orders']['total_month'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereMonth('created_at', Carbon::now()->month)->sum('total');

            $data['orders']['year'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereYear('created_at', Carbon::now()->year)->count();
            $data['orders']['total_year'] = Orders::where('id_entity','=',$id)->where('status','Facturada')->whereYear('created_at', Carbon::now()->year)->sum('total');

            $data['totales']['categories'] = Categories::where('id_entity','=',$id)->count();
            $data['totales']['products'] = Products::where('id_entity','=',$id)->count();
            $data['totales']['users'] = User::where('id_entity','=',$id)->count();

            return response()->json(["data"=>$data],200);
        }catch (Exception $e) {
            return response()->json(["data"=>[]],200);
        }
    }

     /**
     * @OA\Get (
     *     path="/api/orders/all/{id}",
     *      operationId="all_orders",
     *     tags={"Orders"},
     *     security={{ "apiAuth": {} }},
     *     summary="All orders",
     *     description="All orders",
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
        try{
            $orders = Orders::where('id_entity','=',$id)->get();
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
