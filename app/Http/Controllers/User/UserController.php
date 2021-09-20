<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Recommended;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\RecommendedCollection;
use App\Http\Resources\RecommendedsCollection;
use App\Http\Resources\User as ResourcesUser;
use App\Http\Resources\UserCollection;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\Rule;
use League\Flysystem\Util;
use Illuminate\Support\Facades\File;

class UserController extends ApiController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->$user = $user;
        $this->middleware('jwt', ['except' => ['login','register','users']]);
    }


    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->errorResponse('Credenciales Invalidas', 400);
            }
        } catch (JWTException $e) {
            return $this->errorResponse('No encontro ningún token', 500);

        }
        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->logout();
        return $this->showMessage('Sesión cerrado con exito!', 200);
    }


    public function register(UserRequest $request)
    {
        $recomendation = false;
        try {
            DB::beginTransaction();

            // si acepta los terminos y condicones
            if ($request->accepted == 0) {
                return $this->errorResponse('Debe aceptar las politicas de datos para poder registrarse', 409);
            }
            $user = new User($request->all());
            $user->id = $request->document_number;
            $user->password = bcrypt($request->password);

            // si tiene telefono fijo
            if(isset($request->telefonofijo)){
                $user->cell_fixed = $request->telefonofijo;
            }
            //validamos  si viene con imagen de ususario
            if($request->hasFile("image_user")){
                $file = $request->file("image_user");
                $name = time().$file->getClientOriginalName();
                $path = $file->move(public_path().'/img/user/', $name);
                $user->image_user = Util::normalizePath($path);
            }
            // validar si viene con recomendaciones
            if (isset($request->recomendado)) {
                if (User::find($request->recomendado)) {
                    if(Recommendation::where('id_recomendado',$request->recomendado)->where('status',1)->count() >= 4 ){
                        return $this->errorResponse('Este usuario ya excedió las recomendaciones permitidas',409);
                    }
                    $recomendation = true;
                }else{
                    return $this->errorResponse('El usuario que lo recomendo, no se encuentra registrado',409);
                }
            }
            $user->save();
            // se valida si se guardo el recomendado
            if ($recomendation) {
                $recomendation = Recommendation::create([
                    'id_recomendado' => $request->recomendado,
                    'id_user' => $user->id
                ]);
            }
            $token = JWTAuth::fromUser($user);
            DB::commit();

            return response()->json(compact('user','token'),201);
        } catch (\Exception $e) {
            DB::rollBack();
            //si algo sale mal, se borra la imagen de la carpeta
            if($request->hasFile("image_user")){
                File::delete($name);
            }
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    // actulizar un usuario
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => 'min:3',
            'last_name' => 'min:3',
            'email' => 'email|unique:users,email,'.\request()->user()->id,//Exeptuar de la validación a el mismo usuario
        ];
        $this->validate($request, $rules);

        try {
            DB::beginTransaction();

            $user = $user::findOrFail(\request()->user()->id)->update($request->all());

            if($request->hasFile("image_user")){
                File::delete($user->image_user);
                $file = $request->file("image_user");
                $name = time().$file->getClientOriginalName();
                $path = $file->move(public_path().'/img/user/', $name);
                $user->image_user = Util::normalizePath($path);
                $user->save();
            }
            DB::commit();
            return response()->json([
                'user' => new UserResource($user)
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage(), 409);
            //si algo sale mal, se borra la imagen de la carpeta
            if($request->hasFile("image_user")){
                File::delete($name);
            }
        }
    }

    // traer los recomendados que tiene un usuario
    public function getRecommended($id){
        if(Recommendation::where('id_recomendado',$id)->first()){
            return response()->json([
                'user' => new Recommended(
                    Recommendation::where('id_recomendado',$id)->first()
                ),
                'recommended' => new RecommendedsCollection(
                    Recommendation::where('id_recomendado',$id)->where('status',1)->get()
                ),
            ]);
        }
        return $this->showMessage('El usuario no tiene ningún recomendado');
    }

    public function _change_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|password',
            'password' => 'required|min:6|string|confirmed',
            'password_confirmation' => 'required|string'
        ]);
        try {
            User::where('id',\request()->user()->id)->update([
                'password' => $request->password,
            ]);
            return $this->showMessage('Se ha cambiado la contraseña');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 409);
        }
    }

    //devolver el usuario autenticado
    public function me() {
        return response()->json([
            'user' => new UserResource(\request()->user())
        ]);
    }

    //devuelve todos los usuarios
    public function users()
    {
        return response()->json([
            'users' => new UserCollection(User::all())
        ]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 6000,
            'user' => new UserResource(\request()->user())
        ]);
    }

}
