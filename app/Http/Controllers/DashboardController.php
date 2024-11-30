<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index');
    }

    public function getAllUsers(){
        try {
            $adminRoleId = $this->getAdminRoleId();
            $profiles = User::with([
                'userProfile.gender',
                'userProfile.matchGenderPreference',
                'userProfile.ethnicity',
                'userProfile.educationQualification',
                'userPhotos',
                'userHobbies.hobby',
                'userGoals.goal',
                'userCharacteristics.characteristic',
                'userQA.question'
            ])
            ->where('users.role_id', '!=',  $adminRoleId)
            ->get() ;
            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function getUserView($id){
        try {
            $profiles = User::with([
                'userProfile.gender',
                'userProfile.matchGenderPreference',
                'userProfile.ethnicity',
                'userProfile.educationQualification',
                'userPhotos',
                'userHobbies.hobby',
                'userGoals.goal',
                'userCharacteristics.characteristic',
                'userQA.question'
            ])
            ->where('users.id', '=', $id)
            ->where('users.is_active', '!=', false)
            ->get() ;
            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function deactivateUser(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
            $user->is_active = false; 
            $user->save();
            return response()->json(['status' => 'success', 'message' => 'User deactivated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    public function deleteUser(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'User not found'], 404);
            }
            $user->delete();
            return response()->json(['status' => 'success', 'message' => 'User deleted successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }


    protected function getAdminRoleId(){
        $getAdminRoleId = Role::where('name', "Admin")->first();
        return $getAdminRoleId? $getAdminRoleId->id : null;
    }
}
