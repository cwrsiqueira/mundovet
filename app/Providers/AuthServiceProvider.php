<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\System_permission_item;
use App\System_company;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('menu-sistema', function($user){
            return $this->getPermissionsSystem($user);
        });

        Gate::define('menu-clientes', function($user){
            return $this->getPermissions($user, 'menu-clientes');
        });

        Gate::define('menu-pacientes', function($user){
            return $this->getPermissions($user, 'menu-pacientes');
        });

        Gate::define('menu-consultas', function($user){
            return $this->getPermissions($user, 'menu-consultas');
        });

        Gate::define('menu-agenda', function($user){
            return $this->getPermissions($user, 'menu-agenda');
        });

        Gate::define('menu-exames', function($user){
            return $this->getPermissions($user, 'menu-exames');
        });

        Gate::define('menu-empresa', function($user){
            return $this->getPermissions($user, 'menu-empresa');
        });

        Gate::define('menu-permissoes', function($user){
            return $this->getPermissions($user, 'menu-permissoes');
        });

        Gate::define('menu-usuarios', function($user){
            return $this->getPermissions($user, 'menu-usuarios');
        });

        Gate::define('menu-inicial', function($user){
            if ($user->id_permission == null) {
                return true;
            } else {
                return $this->getPermissions($user, 'menu-empresa');
            }
            
        });
    }

    private function getPermissionsSystem($user){
        if($user->email === 'cwrsiqueira@msn.com' && $user->name === 'Carlos Wagner') {
            return true;
        }
        return false;
    }

    private function getPermissions($user, $menu) {
        
        if ($this->verifyPayment($user)) {
            $permissions = [];
            $id_permissions = $user->permissions;
            
            foreach ($id_permissions as $item ) {
                $permissions[] = $item['id_permission_item'];
            }
            $id_this_permission = System_permission_item::where('slug', $menu)->first('id');
            if (in_array($id_this_permission['id'], $permissions)) {
                return true;
            }
        }
        return false;
    }

    private function verifyPayment($user) {
        $company = System_company::where('id', $user->id_company)->first();
        $due_date = date('Y-m-d', strtotime($company['pay_date'].'+'.($company['days_paid'] + 5).' days'));
        if (date('Y-m-d') <= $due_date) {
            return true;
        } else {
            return false;
        }
    }
}
