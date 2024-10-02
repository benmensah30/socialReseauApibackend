<?php

namespace App\Interfaces;

interface GroupInterface
{
    // public function groupCreate(array $data);

    public function creationAdmin(array $data);

    public function creationMember(array $data);

    public function createGroup(array $data);

    public function addMember(array $data, $groupId);

    public function show_group();
    public function show_files($goupId);

}
