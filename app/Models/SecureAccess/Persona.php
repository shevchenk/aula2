<?php

namespace App\Models\SecureAccess;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DB;

class Persona extends Authenticatable
{
    use Notifiable;
    protected   $table = 'v_personas';


    public static function runEditPassword($r)
    {
        $persona_id = Auth::user()->id;
        $persona = Persona::find($persona_id);
        $bcryptpassword = bcrypt($r->password);
        if( Hash::check($r->password_actual, $persona->password) ){
            $persona->password = $bcryptpassword;
            $persona->persona_id_updated_at = $persona_id;
            $persona->save();
            $sql = 'UPDATE fomacioncontinua_fc.personas SET password = "'.$bcryptpassword.'" WHERE dni = "'.$persona->dni.'"';
            DB::update($sql);
            return 1;
        }
        else{
            return 2;
        }
    }

    public static function Menu()
    {
        //if(Auth::check())
        $persona = Auth::user()->id;
        $set=DB::statement('SET group_concat_max_len := @@max_allowed_packet');
        $result=DB::table('opciones as o')
                ->join('menus as m', function($join){
                        $join->on('m.id','o.menu_id')
                        ->where('m.estado',1);
                })
                ->join('privilegios_opciones as po', function($join){
                        $join->on('po.opcion_id','o.id')
                        ->where('po.estado',1);
                })
                ->join('privilegios as p', function($join){
                        $join->on('p.id','po.privilegio_id')
                        ->where('p.estado',1);
                })
                ->join('personas_privilegios_sucursales as pps', function($join){
                        $join->on('pps.privilegio_id','p.id')
                        ->where('pps.estado',1);
                })
                ->select('m.menu','p.privilegio','p.id AS privilegio_id',
                    DB::raw(
                    'GROUP_CONCAT(
                        DISTINCT( CONCAT_WS("|",o.opcion,o.ruta,o.class_icono) )
                        ORDER BY o.opcion SEPARATOR "||"
                        ) opciones, min(m.class_icono) icono'
                    )
                )
                ->where('pps.persona_id',$persona)
                ->where('o.estado',1)
                ->groupBy('m.menu','p.privilegio','p.id')
                ->orderBy('m.menu')
                ->get();

        return $result;
    }
}
