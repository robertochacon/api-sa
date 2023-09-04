<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['clear_cache','run_ws','stop_ws','login', 'register']]);
    }

    /**
     * @OA\Get (
     *     path="/api/clear_cache",
     *      operationId="clear_cache",
     *     tags={"Clear cache"},
     *     summary="Clear cache",
     *     description="Clear cache",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     * )
     */

     public function clear_cache()
     {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:cache');
     
        return "Cache cleared successfully"; 
     }

     /**
     * @OA\Get (
     *     path="/api/run_ws",
     *      operationId="run_ws",
     *     tags={"WS"},
     *     summary="Run websockets",
     *     description="Run websockets",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     * )
     */

    public function run_ws()
    {
        try {
            Artisan::call('websockets:serve');
            return json_encode(["success"=>"success", "msg"=>"Started"]);
        } catch (\Throwable $th) {
            return json_encode(["success"=>"false", "msg"=>$th ]);
        }   
    }

    /**
     * @OA\Get (
     *     path="/api/stop_ws",
     *      operationId="stop_ws",
     *     tags={"WS"},
     *     summary="Stop websockets",
     *     description="Stop websockets",
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     ),
     * )
     */

    public function stop_ws()
    {
        try {
            Artisan::call('websockets:serve --stop');
            return json_encode(["success"=>"success", "msg"=>"Started"]);
        } catch (\Throwable $th) {
            return json_encode(["success"=>"false", "msg"=>$th ]);
        }   
    }

    /**
     * @OA\Post(
     * path="/api/login",
     * summary="Sign in",
     * description="Login by code",
     * operationId="authLogin",
     * tags={"Login"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(
     *       required={"code"},
     *       @OA\Property(property="code", type="string", format="string", example="2023"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */

    public function login()
    {
        $credentials = request(['code']);
        $credentials['password'] = '2023';

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('id',auth()->user()['id'])->first();
        $datos['token'] = $token;
        $datos['user'] = $user;
        return $this->respondWithToken($datos);

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }


    /**
    * @OA\Post(
    * path="/api/register",
    * operationId="Register",
    * tags={"Register"},
    * summary="User Register",
    * description="User Register here",
    *      @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *               required={"code","name"},
    *               @OA\Property(property="code", type="string"),
    *               @OA\Property(property="name", type="string"),
    *         ),
    *      ),
    *      @OA\Response(
    *          response=201,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=200,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(
    *          response=422,
    *          description="Unprocessable Entity",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=400, description="Bad request"),
    *      @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function register(Request $request)
    {

        try {
            $data = $request->all();
            $data['password'] = bcrypt('2023');
            $user = User::create($data);
    
            return response()->json([
                'message' => '¡Usuario registrado exitosamente!',
                'user' => $user
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th,
            ], 500);
        }

    }
}