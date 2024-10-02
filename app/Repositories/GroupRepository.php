<?php

namespace App\Repositories;

use App\Http\Requests\GroupRequest\GroupCreateRequest;
use App\Interfaces\GroupInterface;
use App\Models\Admin;
use App\Models\File;
use App\Models\Group;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use function PHPUnit\Framework\returnSelf;

class GroupRepository implements GroupInterface
{

    public function creationAdmin(array $data)
    {
        return Admin::create($data);
    }

    public function creationMember(array $data)
    {
        return Member::create($data);
    }

    public function show_group()
    {
        $groups = [];
        $user = User::find(auth()->user()->getAuthIdentifier());
        $groupsId = Member::where('user_id', $user->id)->get()->pluck('group_id');

        
        foreach ($groupsId as $id) {
            array_push($groups, Group::find($id));
        }

        return $groups;
    }



    public function createGroup(array $data)
    {
        $group = Group::create($data);

        // Member::create([
        //     'group_id' => $group->id,
        //     'user_id' => auth()->user()->id,
        //     'is_admin' => true
        // ]);

        return $group;
    }


    public function addMember(array $data, $groupId)
    {
        $existingMember = Member::where('group_id', $groupId)
            ->where('user_id', $data['user_id'])
            ->first();



        if ($existingMember) {
            return response()->json(['message' => 'L\'utilisateur est deja membre de ce groupe']);
        }

        $member = Member::create([
            'group_id' => $groupId,
            'user_id' => $data['user_id'],
            'is_admin' => false
        ]);

        return $member;
    }

    public function show_files($goupId){
        $files = [];
        $file = File::where('group_id', $goupId)->get();
        // foreach ($file as $file){
        //     array_push($files, $file);
        // }
        return $file;
    }
}
