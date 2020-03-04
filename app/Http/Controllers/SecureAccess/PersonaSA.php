<?php
namespace App\Http\Controllers\SecureAccess;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\SecureAccess\Persona;
use DB;

class PersonaSA extends Controller
{
    use AuthenticatesUsers;

    protected $loginView = 'secureaccess.login';

    public function ValidaPersona(Request $r)
    {
        $local='http://localhost/pae/public';
        if( $_SERVER['SERVER_NAME']=='miaula.formacioncontinua.pe' ){
            $local='https://formacioncontinua.pe';
        }
        elseif( $_SERVER['SERVER_NAME']=='capamiaula.formacioncontinua.pe' ){
            $local='http://capa.formacioncontinua.pe';
        }
        $tab_cli = DB::table('clientes_accesos')
                  ->where('id','=',2)
                  ->where('url','=',$local)
                  ->where('estado','=', 1)
                  ->first();
        
        $persona = DB::table('v_personas')
                  ->where('dni','=',$r->dni)
                  ->first();

        $cli_links = DB::table('clientes_accesos_links')
                        ->where('cliente_acceso_id','=',2)
                        ->where('tipo','=', 2)
                        ->first();
        $buscar = array("pkey", "pdni");
        $reemplazar = array($tab_cli->keycli, $r->dni);
        $url = str_replace($buscar, $reemplazar, $cli_links->url);
        $lista = $this->curl($url);

        $pe=array();
        if( isset($lista->data->paterno) ){
            DB::beginTransaction();
            if( isset($persona->id)) // Existe Persona
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

                $privilegios_suc = DB::table('personas_privilegios_sucursales')
                                ->where('persona_id','=',$persona->id)
                                ->where('privilegio_id','=',3)
                                ->first();

                DB::table('personas_privilegios_sucursales')
                ->where('persona_id', $persona->id)->update(['estado' => 0]);

                if(isset($privilegios_suc->id))
                {
                DB::table('personas_privilegios_sucursales')
                    ->where('persona_id', $persona->id)
                    ->where('privilegio_id', 3)
                    ->update(['estado' => 1]);
                }
                else
                {
                DB::table('personas_privilegios_sucursales')->insert([
                          ['persona_id' => $persona->id,
                            'privilegio_id' => 3,
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

                $privilegios_suc = DB::table('personas_privilegios_sucursales')
                                ->where('persona_id','=',$pe->id)
                                ->where('privilegio_id','=',3)
                                ->first();

                DB::table('personas_privilegios_sucursales')
                  ->where('persona_id', $pe->id)->update(['estado' => 0]);

                if(isset($privilegios_suc->id))
                {
                DB::table('personas_privilegios_sucursales')
                    ->where('persona_id', $pe->id)
                    ->where('privilegio_id', 3)
                    ->update(['estado' => 1]);
                }
                else
                {
                DB::table('personas_privilegios_sucursales')->insert([
                          ['persona_id' => $pe->id,
                            'privilegio_id' => 3,
                            'estado' => 1,
                            'created_at' => date("Y-m-d H:i:s"),
                            'persona_id_created_at' => 1]
                      ]);
                }
            }
            DB::commit();
        }

        return $this->login($r);
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

    public function authenticated(Request $r)
    {
        $result['rst']=1;
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
            'dni'=>$r->dni,
            'cargo'=>$cargo,
            'privilegio_id'=>$privilegio_id,
        );
        session($session);
        return response()->json($result);
    }

    public function username()
    {
        return "dni";
    }

    public function EditPassword(Request $r)
    {
        if ( $r->ajax() ) {
            if( $r->password == $r->password_confirm ){
                $rs=Persona::runEditPassword($r);
                $return['rst'] = 1;
                $return['msj'] = 'Registro actualizado';
                if( $rs==2 ){
                    $return['rst'] = 2;
                    $return['msj'] = 'Contraseña Actual no válida';
                }
            }
            else{
                $return['rst'] = 2;
                $return['msj'] = 'Contraseña y Contraseña de confirmación no '.
                'son iguales';
            }
            return response()->json($return);
        }
    }


}
