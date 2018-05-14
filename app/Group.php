<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name', 'capacity', 'currency',
        'payment_amount',
        'start_date', 'end_date',
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
        if ($this->members()->count() < $this->capacity) {
            $this->members()->attach($user);

            return $user;
        }

        return false;
    }

    public function isFull()
    {
        return $this->capacity == $this->members->count();
    }

    public function removeMember(int $groupMemberId)
    {
        return \DB::table('group_members')->delete($groupMemberId);
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusCodeAttribute()
    {
        if ($this->isActive()) {
            return 'active';
        }

        if ($this->isClosed()) {
            return 'closed';
        }

        return 'planned';
    }

    public function getStatusAttribute()
    {
        return trans('group.'.$this->status_code);
    }

    public function isPlanned()
    {
        return is_null($this->start_date) && is_null($this->end_date);
    }

    public function isActive()
    {
        return $this->start_date && is_null($this->end_date);
    }

    public function isClosed()
    {
        return $this->start_date && $this->end_date;
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function getWinnerPayoffAttribute()
    {
        return $this->members->count() * $this->payment_amount;
    }
}
