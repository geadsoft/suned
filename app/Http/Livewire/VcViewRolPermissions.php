<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Roles;
use Livewire\Component;

class VcViewRolPermissions extends Component
{
    public  $arrpermisos=[], $selectId;

    protected $listeners = ['roles','permisos','asignar'];
    
    public function render()
    {
        return view('livewire.vc-view-rol-permissions');
    }

    public function roles($id)
    {
        $this->selectId = $id;
        $this->arrpermisos = [];

        if ($this->selectId==0){

            $tblroles = Roles::all();

            foreach ($tblroles as $roles){
                $arrdata['id'] = $roles['id'];
                $arrdata['nombre'] = $roles['name'];
                $arrdata['rolesId'] = 0;
                $arrdata['aplicar'] = false;
                array_push($this->arrpermisos,$arrdata);
            }

        }else{

            $tblpermisos = Roles::query()
            ->leftJoin('model_has_roles', function($join) {
                $join->on('model_has_roles.role_id', '=', 'roles.id')
                    ->where('model_has_roles.model_id', '=',$this->selectId);
            })
            ->select('roles.id','roles.name','model_has_roles.role_id')
            ->orderBy('roles.id')
            ->get();

            foreach ($tblpermisos as $permisos){
                $arrdata['id'] = $permisos['id'];
                $arrdata['nombre'] = $permisos['name'];
                if ($permisos['role_id']==null){
                    $arrdata['permisoId'] = 0;
                    $arrdata['aplicar'] = false;
                }else{
                    $arrdata['permisoId'] = $permisos['role_id'];
                    $arrdata['aplicar'] = true;
                }
                array_push($this->arrpermisos,$arrdata);
            }

        }

    }

    public function permisos($id)
    {
        $this->selectId = $id;
        $this->arrpermisos = [];

        if ($this->selectId==0){

            $tblpermisos = Permission::all();

            foreach ($tblpermisos as $permisos){
                $arrdata['id'] = $permisos['id'];
                $arrdata['nombre'] = $permisos['name'];
                $arrdata['permisoId'] = 0;
                $arrdata['aplicar'] = false;
                array_push($this->arrpermisos,$arrdata);
            }

        }else{

            $tblpermisos = Permission::query()
            ->leftJoin('role_has_permissions', function($join) {
                $join->on('role_has_permissions.permission_id', '=', 'permissions.id')
                    ->where('role_has_permissions.role_id', '=',$this->selectId);
            })
            ->select('permissions.id','permissions.name','role_has_permissions.permission_id')
            ->orderBy('permissions.id')
            ->get();

            foreach ($tblpermisos as $permisos){
                $arrdata['id'] = $permisos['id'];
                $arrdata['nombre'] = $permisos['name'];
                if ($permisos['permission_id']==null){
                    $arrdata['permisoId'] = 0;
                    $arrdata['aplicar'] = false;
                }else{
                    $arrdata['permisoId'] = $permisos['permission_id'];
                    $arrdata['aplicar'] = true;
                }
                array_push($this->arrpermisos,$arrdata);
            }

        }
        
    }

    public function asignar($tipo,$id)
    {   

        if ($tipo=='ROL'){

            $users = User::find($id);          

            foreach ($this->arrpermisos as $permisos){

                if ($permisos['permisoId']>0 && $permisos['aplicar']==false){
                    $users->removeRole($permisos['nombre']);
                }

                if ($permisos['permisoId']==0 && $permisos['aplicar']==true){
                    $users->assignRole($permisos['nombre']);
                }

            }


        } else {

            $rol = Role::find($id);

            foreach ($this->arrpermisos as $permisos){

                if ($permisos['permisoId']>0 && $permisos['aplicar']==false){
                    $rol->revokePermissionTo($permisos['nombre']);
                }

                if ($permisos['permisoId']==0 && $permisos['aplicar']==true){
                    $rol->givePermissionTo($permisos['nombre']);
                }

            }

        }
    }


}
