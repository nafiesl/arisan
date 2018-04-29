<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'capacity', 'currency',
        'description', 'creator_id',
    ];

    public function nameLink()
    {
        return link_to_route('groups.show', $this->name, [$this], [
            'title' => trans(
                'app.show_detail_title',
                ['name' => $this->name, 'type' => trans('group.group')]
            ),
        ]);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')->withPivot(['id']);
    }

    public function addMember(User $user)
    {
        $this->members()->attach($user);

        return $user;
    }

    public function removeMember(int $groupMemberId)
    {
        return \DB::table('group_members')->delete($groupMemberId);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}
