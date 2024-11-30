<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\Models\Hobby;
use App\Models\Gender;
use App\Models\Ethnicity;
use App\Models\UserPhoto;
use Illuminate\Http\Request;
use App\Models\Characteristic;
use App\Models\EducationQualification;

class ProfileController extends Controller
{
    // Get list of all genders
    public function getGenders()
    {
        $genders = Gender::all();
        return response()->json(['status' => 'success', 'data' => $genders], 200);
    }

    // Set user gender preference
    public function setGenderPreference(Request $request)
    {   
        try {
            $request->validate([
                'gender_id' => 'required|exists:genders,id',
                'match_gender_preference_id'=>'required|exists:genders,id',
            ]);
            $user = auth()->user();
            $userProfile = $user->userProfile;
            $userProfile->gender_id = $request->gender_id;
            $userProfile->match_gender_preference_id = $request->match_gender_preference_id;
            $userProfile->save();
            return response()->json(['status' => 'success', 'message' => 'Gender preference updated'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], status: 500);
        }
    }

    // Get list of all goals
    public function getGoals()
    {   
        $goals = Goal::all();
        return response()->json(['status' => 'success', 'data' => $goals], 200);
    }

    // Set user goals preference
    public function setGoals(Request $request)
    {   
        try {
            $request->validate([
                'goals' => 'required|array',
                'goals.*' => 'exists:goals,id',
            ]);
            $user = auth()->user();
            $user->goals()->sync(['1','2','3']);
            return response()->json(['status' => 'success', 'message' => 'Goals updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], status: 500);
        }
    }

    // Get list of all hobbies
    public function getHobbies()
    {   
        $hobbies = Hobby::all();
        return response()->json(['status' => 'success', 'data' => $hobbies], 200);
    }

    // Set user hobbies preference
    public function setHobbies(Request $request)
    {   
        try {
            $request->validate([
                'hobbies' => 'required|array',
                'hobbies.*' => 'exists:hobbies,id',
            ]);
            $user = auth()->user();
            $user->hobbies()->sync($request->hobbies);
            return response()->json(['status' => 'success', 'message' => 'Hobbies updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], status: 500);
        }
    }

    // Get list of all characteristics
    public function getCharacteristics()
    {
        $characteristics = Characteristic::all();
        return response()->json(['status' => 'success', 'data' => $characteristics], 200);
    }

    // Set user characteristics preference
    public function setCharacteristics(Request $request)
    {   
        try {
            $request->validate([
                'characteristics' => 'required|array',
                'characteristics.*' => 'exists:characteristics,id',
            ]);
            $user = auth()->user();
            $user->characteristics()->sync($request->characteristics);
            return response()->json(['status' => 'success', 'message' => 'Characteristics updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], status: 500);
        }
    }

    // Get list of all education options

    public function getEducationOptions()
    {
        $educationOptions = EducationQualification::all();
        return response()->json(['status' => 'success', 'data' => $educationOptions], 200);
    }


    // Set user education preference

    public function setEducation(Request $request){
        
        try {
            $request->validate([
                'education_qualifications_id' => 'required',
                'education_qualifications_id.*' => 'exists:education_qualifications,id',
            ]);
            $user = auth()->user();
            $userProfile = $user->userProfile;
            $userProfile->education_qualifications_id = $request->education_qualifications_id;
            $userProfile->save();
            return response()->json(['status' => 'success', 'message' => 'Characteristics updated successfully'], 200);
        } catch (\Throwable $th) {
           return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }

    }

    // Get user's profile information

    public function getEthnicities()
    {
        $ethnicityOptions = Ethnicity::all();
        return response()->json(['status' => 'success', 'data' => $ethnicityOptions], 200);
    }

    // public function setEthnicity(Request $request){

    //     $request->validate([
    //         'ethnicity_id' => 'required',
    //         'ethnicity_id.*' => 'exists:ethnicities,id',
    //     ]);

    //     $user = auth()->user();
    //     $userProfile = $user->userProfile;
    //     $userProfile->ethnicity_id = $request->ethnicity_id;
    //     $userProfile->save();
    // }

    public function getAvatarOptions()
    {
        $genders = UserPhoto::all();
        return response()->json(['status' => 'success', 'data' => $genders], 200);
    }

    public function uploadProfileImage(Request $request){
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time(). '.'. $request->image->getClientOriginalExtension();
                $filePath = $image->storeAs('uploads/user_photos', $imageName, 'public');

                UserPhoto::create([
                    'user_id' => auth()->id(),
                    'photo_path' => $filePath
                ]);
                return response()->json(['status' => 'success','message' => 'Image uploaded successfully'], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => 'An error occurred while uploading image'], 500);
        }
    }

    public function primaryProfilePicture(Request $request){
        try {
            $selectedPhotoId = $request->photo_id;
            $setPrimaryProfilePicture = UserPhoto::find( $selectedPhotoId);
            $setPrimaryProfilePicture->is_primary = true;
            $setPrimaryProfilePicture->save();
            return response()->json(['status' => 'success','message' => 'Primary profile picture set]'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => 'An error occurred while setting primary profile picture'], 500);
        }
    }

    // Set profile information like ethnicity,age,height,occupation,about and religion
    public function setProfileBio(Request $request){
        try {
            $request->validate([
                'ethnicity_id' => 'nullable|exists:ethnicities,id',
                'age' => 'nullable|integer|min:1|max:150',
                'height' => 'nullable|numeric',
                'about' => 'nullable|string',
                'occupation' => 'nullable|string',
                'religion' => 'nullable|string',
            ]);
            $user = auth()->user();
            $userProfile = $user->userProfile;
            $userProfile->ethnicity_id = $request->ethnicity_id;
            $userProfile->age = $request->age;
            $userProfile->height = $request->height;
            $userProfile->about = $request->about;
            $userProfile->occupation = $request->occupation;
            $userProfile->religion = $request->religion;
            $userProfile->save();
            return response()->json(['status' => 'success','message' => 'Profile bio updated successfully'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => 'An error occurred while updating profile bio'], 500);
        }
    }
}
