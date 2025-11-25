<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllUser()
    {

        $users = $this->model->where('role', '!=', 'superadmin')->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user = $this->model->findOrFail($id);

        $user->is_active = $validated['is_active'];
        $user->save();

        return response()->json([
            'success' => true, // Tambahkan ini untuk konsistensi
            'message' => 'User status updated successfully'
        ]);
    }
}
