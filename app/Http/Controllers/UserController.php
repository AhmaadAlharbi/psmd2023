<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function update($id)
    {
        $user = User::findOrFail($id);
        $role = null;
        if ($user->role->title === 'Admin') {
            $role = 4;
        } else {
            $role = 2;
        }
        $user->update([
            'role_id' => $role
        ]);
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('dashboard.engineersList');
    }
}
