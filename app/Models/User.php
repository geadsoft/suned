<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Models\TmPeriodosLectivos;
use App\Models\TmMatricula;
use App\Models\TmPersonas;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    public $tipo = [
        'A' => 'Administrativo',
        'D' => 'Docente',
        'P' => 'Apoyo Profesional',
        'M' => 'Mantenimiento',
        'E' => 'Estudiante',
        'R' => 'Representante',
        'F' => 'Familiar',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil',
        'personaId',
        'acceso',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function datos($id)
    {   
      
        $persona = TmPersonas::find($id);
              
        $tipo = $this->tipo[$persona->tipopersona];
        $modalidad = '';
        $curso = '';

        if ($persona->tipopersona=='E'){

            $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
            $periodoId = $tblperiodos['id'];    

            $matricula = TmMatricula::query()
            ->join('tm_generalidades as d','d.id','=','tm_matriculas.modalidad_id')
            ->join('tm_servicios as s','s.id','=','tm_matriculas.grado_id')
            ->selectRaw('d.descripcion as nommodalidad, s.descripcion as nomservicio')
            ->where('periodo_id',$periodoId)
            ->where('estudiante_id',$id)
            ->first();

            return [
                'tipo' => $persona->tipopersona,
                'rol' => auth()->user()->roles->pluck('name')->implode(', '),
                'modalidad' => $matricula->nommodalidad,
                'curso' => $matricula->nomservicio,
            ];

        }else{

            return [
                'tipo' => $persona->tipopersona,
                'rol' => auth()->user()->roles->pluck('name')->implode(', '),
                'modalidad' => '',
                'curso' => '',
            ];
            
        }

        
    }
}
