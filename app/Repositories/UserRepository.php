<?php
namespace App\Repositories;
use App\Models\User;

/**
 * Created by PhpStorm.
 * User: hejunwei
 * Date: 01/08/2017
 * Time: 11:39
 */
class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAllUserPaginate($page = 15)
    {
       return $this->user->paginate($page);
    }
}