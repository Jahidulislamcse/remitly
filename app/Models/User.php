<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasPushSubscriptions, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hp',
        'phone',
        'location',
        'role',
        'otp',
        'email_verified_at',
        'otp_varify',
        'image',
        'status',
        'type',
        'pin'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function code(){

        $total_cat = User::all()->count();

        $cat_code = 'E-'.rand(111,999).$total_cat + 1 ;

        return $cat_code ;

    }

    public function status()
    {
        if ($this->status == 1) {
            return '<span class="badge rounded-pill text-bg-success">Active</span>';
        } else {
            return '<span class="badge badge-danger mb-2 me-4">Deactive</span>';
        }
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'location', 'id');
    }
    
    public function visits()
    {
        return $this->hasMany(\App\Models\UserVisit::class);
    }

     public function cashInCashOut()
    {
        return $this->hasMany(CashInCashOut::class);
    }

    public function notifications()
{
    return $this->belongsToMany(Notification::class, 'user_notifications')
                ->withPivot('seen', 'seen_at')
                ->withTimestamps();
}


}