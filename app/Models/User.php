<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles,SoftDeletes,\OwenIt\Auditing\Auditable;


    CONST TYPES = [
        1=>'Compañia',
        2=>'Normal'
    ];

    const STATUS = [
        1 => 'Activo',
        2 => 'Incativo'
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
        'status',
        'type',
        'company',
        'occupation',
        'demo_start',
        'cont',
        'fecha_cont',
        'habilitado'
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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    protected function getNameStatusAttribute()
    {
        return ($this->status == 1 ? 'Activo' : 'Inactivo');
    }

    protected function getNameTypeAttribute()
    {
        return ($this->type == 1 ? 'Compañia' : 'Normal');
    }

    public function getUsers()
    {
        // return $this->hasMany(User::class)->where('type', 2)->where('company', $this->company);
        return User::where('type',2)->where('company',$this->company)->get();
    }

    public function lastMonthReports()
    {
         return QueryReport::where('user_id',$this->id)->whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'))->count();
    }

    public function isDemo()
    {
        // return $this->hasMany(User::class)->where('type', 2)->where('company', $this->company);
        
        return $this->company == 'DEMO SD' && $this->type == 2 ? true : false;
    }

    public function reports()
    {
        return $this->hasMany(QueryReport::class,'user_id')->whereYear('created_at',date('Y'))->whereMonth('created_at',date('m'));
    }

    // public function company()
    // {
    //     return $this->belongsTo();
    // }
}
