<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\System_company;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'id_company', 'id_permission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions()
    {
        return $this->hasMany('App\System_permission_link', 'id_permission_group', 'id_permission');
    }

    public function adminlte_image()
    {
        $dados = Auth::user();
        $company = System_company::where('id', Auth::user()->id_company)->first();
        
        if (!empty($company['url_logo'])) {
            $url = asset('assets/img/'.$company['url_logo']);
        } else {
            $url = asset('assets/media/default.jpg');
        }

        return $url;
    }

    public function adminlte_desc()
    {
        $dados = Auth::user();
        $acesso = System_permission_group::where('id', $dados['id_permission'])
        ->where('id_company', $dados['id_company'])
        ->first();

        return $acesso['name'].' - Desde: '.date('d/m/Y', strtotime($dados['created_at']));
    }
}
