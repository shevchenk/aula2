<?php
namespace App\Http\Controllers\Api;

//use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Api\Curso;
//use App\Models\Mantenimiento\Persona;

// Auth
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\SecureAccess\Persona;

class ApiCurso extends Controller
{
    //use WithoutMiddleware;
    use AuthenticatesUsers;
    //use Session;

    public function __construct()
    {
        //$this->middleware('auth');  //Esto debe activarse cuando estemos con sessión
    }

    public function index(){
        //
    }

    public function store()
    {
      /*
        $obj = json_decode( file_get_contents('php://input') );
        $objArr = (array)$obj;

        if (empty($objArr))
        {
            $this->response(422,"error","Ingrese sus datos de envio");
        }
        else if(isset($obj->key[0]->id) && isset($obj->key[0]->token))
        {
            $tab_cli = DB::table('clientes_accesos')->select('id', 'nombre', 'key', 'url', 'ip')
                                                    ->where('id','=', $obj->key[0]->id)
                                                    ->where('key','=', $obj->key[0]->token)
                                                    ->where('url','=', $obj->key[0]->url)
                                                    ->where('ip','=', $obj->key[0]->ip)
                                                    ->first();

            if($obj->key[0]->id == @$tab_cli->id && $obj->key[0]->token == @$tab_cli->key && $obj->key[0]->url == @$tab_cli->url && $obj->key[0]->ip == @$tab_cli->ip)
            {
                $val = $this->insertCurso($objArr);
                if($val == true)
                    $this->response(200,"success","Proceso ejecutado satisfactoriamente");
                else
                    $this->response(422,"error","Revisa tus parametros de envio");
            }
            else
            {
                $this->response(422 ,"error","Su Key no es valido");
            }
        }
        else
        {
            $this->response(422,"error","Revisa tus parametros de envio");
        }
        */
    }

    public function response($code=200, $status="", $message="")
    {
        http_response_code($code);
        if( !empty($status) && !empty($message) )
        {
            $response = array(
                        "status" => $status ,
                        "message" => $message,
                        "server" => $_SERVER['REMOTE_ADDR']
                    );
            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }

    /*
    public function insertCurso($objArr)
    {
        DB::beginTransaction();
        try
        {
            foreach ($objArr['cursos'] as $k=>$value)
            {
                $cursos = Curso::where('curso', '=', trim($value->curso))
                                    ->where('curso_externo_id', '=', trim($value->curso_externo_id))
                                    ->first();

                if (count($cursos) == 0)
                {
                    // Graba datos
                    $obj = new Curso;
                    $obj->curso = trim( $value->curso );
                    $obj->curso_externo_id = trim( $value->curso_externo_id );
                    $obj->estado = 1;
                    $obj->persona_id_created_at=1;
                    $obj->save();
                    // --
                }
            }
            $msg = true;
            DB::commit();
        }
        catch (\Exception $e)
        {
            $msg = false;
            DB::rollback();
        }
        return $msg;
    }
    */
    public function Validaracceso(Request $r)
    {
        $ruta = 'api.curso.curso';
        $valores['valida_ruta_url'] = $ruta;
        $url = url()->previous(); //url anterior Cliente
        $url = substr($url, 0,strrpos($url,"/",-1)) ;
        Auth::logout();
        Session::flush();
        session(['idcliente' => $r->id]);
        if( $r->has('empresa_id') ){
          session(['empresa_id' => $r->empresa_id]);
        }
        //Session::put('grupo', $grupo);

        if (empty($r))
        {
            $valores['mensaje'] = 'Ingrese sus datos de envio';
        }
        else if( $r->has('id') && $r->has('dni') &&  $r->has('cargo'))
        {
            $tab_cli = DB::table('clientes_accesos')
                      ->where('id','=', $r->id)
                      //->where('url','=', $url)
                      //     ->where('ip','=', $this->getIPCliente())
                      ->where('estado','=', 1)
                      ->first();
            if(!isset($tab_cli->id))
                $valores['mensaje'] = 'Cliente no Registrado!';
            else
            {
              // URL (CURL)
              $cli_links = DB::table('clientes_accesos_links')
                            ->where('cliente_acceso_id','=', $r->id)
                            ->where('tipo','=', 1)
                            ->first();
              //dd($cli_links);
              $key = $this->curl($cli_links->url);

              dd($r);
              
              if(isset($key->data->key) AND $key->data->key == $tab_cli->key) // Se iguala el KEY del Cliente con el Key del Servidor
              {
                  DB::beginTransaction();
                  $persona = DB::table('v_personas')
                              ->where('dni','=',$r->dni)
                              ->first();

                  $cli_links = DB::table('clientes_accesos_links')
                                    ->where('cliente_acceso_id','=',$r->id)
                                    ->where('tipo','=', 2)
                                    ->first();
                  $buscar = array("pkey", "pdni");
                  $reemplazar = array($tab_cli->keycli, $r->dni);
                  $url = str_replace($buscar, $reemplazar, $cli_links->url);
                  $lista = $this->curl($url);
                  
                  $pe=array();
                  
                  if($persona) // Existe Persona
                  {
                      $pe= Persona::find($persona->id);
                      $pe->paterno = $lista->data->paterno;
                      $pe->materno = $lista->data->materno;
                      $pe->nombre = $lista->data->nombre;
                      $pe->sexo = $lista->data->sexo;
                      if( trim($lista->data->fecha_nacimiento)!='' ){
                          $pe->fecha_nacimiento = $lista->data->fecha_nacimiento;
                      }
                      $pe->telefono = $lista->data->telefono;
                      $pe->celular = $lista->data->celular;
                      $pe->persona_id_updated_at = 1;
                      $pe->save();


                      $priv_cliente = DB::table('privilegios_clientes')
                                      ->where('id','=',$r->cargo)
                                      ->first();

                      $privilegios_suc = DB::table('personas_privilegios_sucursales')
                                        ->where('persona_id','=',$persona->id)
                                        ->where('privilegio_id','=',$priv_cliente->id_priv_interno)
                                        ->first();

                      DB::table('personas_privilegios_sucursales')
                      ->where('persona_id', $persona->id)->update(['estado' => 0]);

                      if(isset($privilegios_suc->id))
                      {
                        DB::table('personas_privilegios_sucursales')
                            ->where('persona_id', $persona->id)
                            ->where('privilegio_id', $r->cargo)
                            ->update(['estado' => 1]);
                      }
                      else
                      {
                        DB::table('personas_privilegios_sucursales')->insert([
                                  ['persona_id' => $persona->id,
                                    'privilegio_id' =>  $r->cargo,
                                    'estado' => 1,
                                    'created_at' => date("Y-m-d H:i:s"),
                                    'persona_id_created_at' => 1]
                              ]);
                      }
                  }
                  else // Nueva Persona
                  {
                      $pe = new Persona;
                      $pe->dni = $r->dni;
                      $pe->paterno = $lista->data->paterno;
                      $pe->materno = $lista->data->materno;
                      $pe->nombre = $lista->data->nombre;
                      $pe->sexo = $lista->data->sexo;
                      if( trim($lista->data->fecha_nacimiento)!='' ){
                          $pe->fecha_nacimiento = $lista->data->fecha_nacimiento;
                      }
                      $pe->telefono = $lista->data->telefono;
                      $pe->celular = $lista->data->celular;
                      $pe->password = bcrypt($r->dni);
                      $pe->persona_id_created_at = 1;
                      $pe->save();

                      // Proceso de Carga de Opciones y Privilegios
                      $priv_cliente = DB::table('privilegios_clientes')
                                      ->where('id','=',$r->cargo)
                                      ->first();

                      $privilegios_suc = DB::table('personas_privilegios_sucursales')
                                        ->where('persona_id','=',$pe->id)
                                        ->where('privilegio_id','=',$priv_cliente->id_priv_interno)
                                        ->first();

                      DB::table('personas_privilegios_sucursales')
                          ->where('persona_id', $pe->id)->update(['estado' => 0]);

                      if(isset($privilegios_suc->id))
                      {
                        DB::table('personas_privilegios_sucursales')
                            ->where('persona_id', $pe->id)
                            ->where('privilegio_id', $r->cargo)
                            ->update(['estado' => 1]);
                      }
                      else
                      {
                        DB::table('personas_privilegios_sucursales')->insert([
                                  ['persona_id' => $pe->id,
                                    'privilegio_id' =>  $r->cargo,
                                    'estado' => 1,
                                    'created_at' => date("Y-m-d H:i:s"),
                                    'persona_id_created_at' => 1]
                              ]);
                      }
                  }
                  DB::commit();
                  
                  Auth::loginUsingId($pe->id);
                  $this->logeo($r->dni);
                  return redirect('secureaccess.inicio');
              }
              else{
                $valores['mensaje'] = 'Su Key no es valido';
              }
            }
        }
        else
        {
            $valores['mensaje'] = 'Revisa tus parametros de envio';
        }
        return view($ruta)->with($valores);
    }


    public function logeo($dni)
    {
        $menu = Persona::Menu();
        $opciones=array();
        $cargo='';
        $privilegio_id='';
        foreach ($menu as $key => $value) {
            array_push($opciones, $value->opciones);
            $cargo=$value->privilegio;
            $privilegio_id=$value->privilegio_id;
        }
        $opciones=implode("||", $opciones);
        $session= array(
            'menu'=>$menu,
            'opciones'=>$opciones,
            'dni'=>$dni,
            'cargo'=>$cargo,
            'privilegio_id'=>$privilegio_id,
        );
        session($session);
        return true;
    }

    public function curl($url, $data=array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        if( count($data)>0 ){
          curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        $result = curl_exec($ch);
        //dd($result);
        curl_close($ch);
        return json_decode($result);
    }

    private function getIPCliente()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
            return $_SERVER["HTTP_X_FORWARDED"];
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
            return $_SERVER["HTTP_FORWARDED_FOR"];
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
            return $_SERVER["HTTP_FORWARDED"];
        else
            return $_SERVER["REMOTE_ADDR"];
    }

}
