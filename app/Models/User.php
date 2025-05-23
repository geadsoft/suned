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
use App\Models\TmCambiaModalidad;


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

    public $record=[
        'modalidadId' => 0,
        'gradoId' => 0,
        'cursoId' => 0,
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

    public function createData($id)
    {   

        $tblperiodos = TmPeriodosLectivos::where("aperturado",1)->first();
        $periodoId   = $tblperiodos['id'];    

        $matricula = TmMatricula::query()
        ->join('tm_generalidades as d','d.id','=','tm_matriculas.modalidad_id')
        ->join('tm_servicios as s','s.id','=','tm_matriculas.grado_id')
        ->selectRaw('tm_matriculas.id, d.descripcion as nommodalidad, s.descripcion as nomservicio,tm_matriculas.modalidad_id,tm_matriculas.grado_id,tm_matriculas.curso_id')
        ->where('periodo_id',$periodoId)
        ->where('estudiante_id',$id)
        ->first();

        TmCambiaModalidad::Create([
            'persona_id' => $id,
            'matricula_id' => $matricula->id,
            'modalidad_id' => $matricula->modalidad_id,
            'grado_id' => $matricula->grado_id,
            'curso_id' => $matricula->curso_id,
            'modalidad' => $matricula->nommodalidad,
            'curso' => $matricula->nomservicio,
            'paralelo' => auth()->user()->name,
        ]);
        
    }


}
