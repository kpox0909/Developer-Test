<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_no',
        'mobile_no',
        'address',
        'city',
        'state',
        'zip',
        'profile_pic'
    ];

    public function saveProfilePic(UploadedFile $file)
    {
        $filename = str_random() . '.' . $file->getClientOriginalExtension();
        Storage::putFileAs('public/profiles/' . $this->id, $file, $filename);
        $this->profile_pic = 'profiles/' . $this->id . '/' . $filename;
        $this->save();
    }
    public function user()
    
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
