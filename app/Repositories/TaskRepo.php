<?php
/**
 * Created by frkn.
 * User: Furkan İKİZ
 * Date: 11.11.2019
 * Time: 23:15
 */

namespace App\Repositories;


use App\Models\Task;

class TaskRepo
{

    public function getAll()
    {
        return Task::all();
    }

    function findOrFailTaskById($id)
    {
        return Task::findOrFail($id);
    }

}
