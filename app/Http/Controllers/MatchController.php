<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use App\Models\UserMatch;
use App\Models\UserSwipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MatchController extends Controller
{
    // Get User Match Options
    public function getPotentialMatchProfiles(Request $request)
    {   
        try {
            $user = Auth::user();
            $preferences = $user->userProfile;
            // Get the authenticated user's attributes for matching
            
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
            ->where('id', '!=', $user->id)
            ->whereHas('userProfile', function($query) use ($preferences) {
                $query->when($preferences->match_gender_preference_id, function ($q) use ($preferences) {
                    return $q->where('gender_id', $preferences->match_gender_preference_id);
                })
                ->when($preferences->ethnicity_id, function ($q) use ($preferences) {
                    return $q->where('ethnicity_id', $preferences->ethnicity_id);
                })
                ->when($preferences->education_qualifications_id, function ($q) use ($preferences) {
                    return $q->where('education_qualifications_id', $preferences->education_qualifications_id);
                })
                ->when($preferences->min_age && $preferences->max_age, function ($q) use ($preferences) {
                    $matchAgeRange = $this->calculateAgeRange('age', 4);
                    return $q->whereBetween('age', [$matchAgeRange['min_age'], $matchAgeRange['max_age']]);
                });
            })
            ->get() 
            ->map(function($profile)use ($user){
                // Calculate match percentage
                $matchScore = $this->calculateMatchPercentage($user, $profile);
                $profile->match_percentage = $matchScore;
                
                return $profile;
            })
            ->sortByDesc('match_percentage')
            ->values();
            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
    
    // Get all matches for the authenticated user
    public function getAllProfiles(Request $request)
    {
        try {
            $user = Auth::user();

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
            ->where('id', '!=', $user->id)
            ->get() 
            ->map(function($profile)use ($user){
                // Calculate match percentage
                $matchScore = $this->calculateMatchPercentage($user, $profile);
                $profile->match_percentage = $matchScore;
                
                return $profile;
            })
            ->sortByDesc('match_percentage')
            ->values();

            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    // filter profiles

    public function profileFilter(Request $request)
    {
        try {
            $user = Auth::user();
    
            $profileFilter = User::with([
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
            ->where('id', '!=', $user->id); // Exclude the current user
    
            // Apply filters on related fields using `whereHas`
            if ($request->has('age_min') && $request->has('age_max')) {
                $profileFilter->whereHas('userProfile', function ($q) use ($request) {
                    $q->whereBetween('age', [$request->age_min, $request->age_max]);
                });
            }
    
            if ($request->has('height')) {
                $profileFilter->whereHas('userProfile', function ($q) use ($request) {
                    $q->where('height', '>=', $request->height);
                });
            }
    
            if ($request->has('education_level_id')) {
                $profileFilter->whereHas('userProfile', function ($q) use ($request) {
                    $q->where('education_level', $request->education_level);
                });
            }
    
            if ($request->has('ethnicity_id')) {
                $profileFilter->whereHas('userProfile', function ($q) use ($request) {
                    $q->where('ethnicity_id', $request->ethnicity_id);
                });
            }
    
            if ($request->has('religion')) {
                $profileFilter->whereHas('userProfile', function ($q) use ($request) {
                    $q->where('religion', $request->religion);
                });
            }
    
            if ($request->has('relationship_goals')) {
                $profileFilter->whereHas('userGoals.goal', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->relationship_goals . '%');
                });
            }
    
            if ($request->has('hobbies')) {
                $profileFilter->whereHas('userHobbies.hobby', function ($q) use ($request) {
                    $q->whereIn('name', $request->hobbies); // Accepts an array of hobbies
                });
            }
    
            if ($request->has('characteristics')) {
                $profileFilter->whereHas('userCharacteristics.characteristic', function ($q) use ($request) {
                    $q->whereIn('name', $request->characteristics); // Accepts an array
                });
            }
    
            // Retrieve and calculate match percentage
            $profiles = $profileFilter->get()
                ->map(function ($profile) use ($user) {
                    // Calculate match percentage
                    $matchScore = $this->calculateMatchPercentage($user, $profile);
                    $profile->match_percentage = $matchScore;
    
                    return $profile;
                })
                ->sortByDesc('match_percentage')
                ->values();
    
            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
    
    

    // Swipe (like or dislike)
    public function swipeProfile(Request $request)
    {   
        try {
            $validator = Validator::make($request->all(), [
                'swiped_user_id' => 'required|exists:users,id',
                'action' => 'required|boolean',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
            }
            $user = Auth::user();
            $swipedUserId = $request->swiped_user_id;
            $action = $request->action;
    
            // Assuming you have a Match model and a 'matches' table with columns user_id and matched_user_id
            UserSwipe::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'swiped_user_id' => $swipedUserId, 
                ],
                [
                    'action' => $action, 
                ]
            );
            return response()->json(['status' => 'success', 'message' => 'Swipe action recorded'], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    // Get the match status (liked/disliked)
    public function getMatchStatus(Request $request)
    {   
        try {
            $user = Auth::user();
            $swipedUserId = $request->swiped_user_id;

            $userSwipe = UserSwipe::where('user_id', $user->id)
                ->where('swiped_user_id', $swipedUserId)
                ->first();

            $reverseSwipe = UserSwipe::where('user_id', $swipedUserId)
            ->where('swiped_user_id', $user->id)
            ->first();
                
            if ($userSwipe && $reverseSwipe) {
                if ($userSwipe->action == true && $reverseSwipe->action == true) {

                    $this->createMatch($user->id, $swipedUserId); // create a new match

                    return response()->json([
                        'status' => 'success',
                        'match_status' => 'mutual_match',
                        'data' => [
                            'info'=> [
                                'user_action' => $userSwipe->action ? 'like' : 'dislike',
                                'swiped_user_action' => $reverseSwipe->action ? 'like' : 'dislike',
                            ],
                        ]
                    ], 200);
                }
            } else if (!$userSwipe && $reverseSwipe) {
                if ($reverseSwipe->action == true) {
                    return response()->json([
                        'status' => 'success',
                        'match_status' => 'awaiting_response',
                        'data' => [
                            'info' => [
                                'user_action' => 'not_swiped',
                                'swiped_user_action' => $reverseSwipe->action ? 'like' : 'dislike',
                            ],
                        ],
                    ], 200);
                }
            }else if ($userSwipe && !$reverseSwipe) {
                return response()->json([
                    'status' => 'success',
                    'match_status' => 'awaiting_response',
                    'data' => [
                        'info' => [
                            'user_action' => $userSwipe->action ? 'like' : 'dislike',
                           'swiped_user_action' => 'not_swiped',
                        ],
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => 'success',
                    'match_status' => 'no_action',
                    'data' => [
                        'info' => [
                            'user_action' => 'not_swiped',
                           'swiped_user_action' => 'not_swiped',
                        ],
                    ],
                ], 200);
            }   
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 404);
        }

    }

    // Start a chat with a matched user
    public function startChat(Request $request)
    {   
        try {
            $user = Auth::user();
            $recieverUserId = $request->reciever_user_id;
            $validator = Validator::make($request->all(), [
                'reciever_user_id' => 'required|exists:users,id',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()], 500);
            }
            $isMatch = $this->isProfileMatch($user->id, $recieverUserId);
            if (!$isMatch) {
                return response()->json(['status' => 'error','message' => 'No match found'], 404);
            }
            $matchDetails = UserMatch::where('user_id', $user->id)->where('match_user_id',$recieverUserId)->first();
            // Create a new chat room between the users
            $chat = Chat::create([
                'match_id' => $matchDetails->id,
                'sender_id' => $user->id,
                'receiver_id' => $recieverUserId,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Chat started', 'chat_id' => $chat->id], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Send a message in an existing chat
    public function sendMessage(Request $request)
    {   
        try {
            $receiverId = $request->receiver_id;
            $chatId = $request->chat_id;
    
            $validator = Validator::make($request->all(), [
                'chat_id' => 'required|exists:chats,id',
                'receiver_id' => 'required|exists:users,id',
                'message' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()], 400);
            }
            $chat = Chat::find( $chatId);
            $message = $chat->messages()->create([
                'sender_id' => Auth::user()->id,
                'receiver_id' => $receiverId,
                'message' => $request->message,
            ]);
            return response()->json(['status' => 'success', 'message' => 'Message sent', 'data' => $message], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    // Get chat history between the current user and a matched user
    public function getChatHistory()
    {
        try {
            $user = Auth::user();
            // Fetch all chats involving the logged-in user
            $chats = Chat::with([
                'messages.sender:id,name',
                'messages.receiver:id,name',
                'latestMessage' 
            ])->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })->get();
    
            $chatHistories = $chats->map(function ($chat) {
                return [
                    'chat_id' => $chat->id,
                    'latest_message' => $chat->latestMessage->message ?? 'No messages yet',
                    'participants' => [
                        'sender' => $chat->sender->name ?? 'Unknown',
                        'receiver' => $chat->receiver->name ?? 'Unknown',
                    ],
                    'messages' => $chat->messages->map(function ($message) {
                        return [
                            'id' => $message->id,
                            'sender' => $message->sender->name ?? 'Unknown',
                            'receiver' => $message->receiver->name ?? 'Unknown',
                            'message' => $message->message,
                            'created_at' => $message->created_at->toDateTimeString(),
                        ];
                    }),
                ];
            });
            return response()->json(['status' => 'success','data' => $chatHistories,], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    protected function calculateAgeRange($age, $range = 4)
    {
        $minAge = $age - $range;
        $maxAge = $age + $range;

        $minAge = max(0, $minAge);

        return [
            'min_age' => $minAge,
            'max_age' => $maxAge,
        ];
    }


    private function calculateMatchPercentage($user, $profile)
    {
        $weights = [
            'hobbies' => 0.25,        // 25%
            'goals' => 0.30,          // 30%
            'characteristics' => 0.25, // 25%
            'questions' => 0.20        // 20%
        ];
    
        // User Data
        $userHobbies = $user->userHobbies->pluck('hobby_id')->toArray();
        $userGoals = $user->userGoals->pluck('goal_id')->toArray();
        $userCharacteristics = $user->userCharacteristics->pluck('user_characteristics_id')->toArray();
        $userAnswers = $user->userQA->pluck('selected_answer', 'question_id')->toArray();
    
        // Profile Data
        $profileHobbies = $profile->userHobbies->pluck('hobby_id')->toArray();
        $profileGoals = $profile->userGoals->pluck('goal_id')->toArray();
        $profileCharacteristics = $profile->userCharacteristics->pluck('user_characteristics_id')->toArray();
        $profileAnswers = $profile->userQA->pluck('selected_answer', 'question_id')->toArray();
    
        // Calculate Match Scores
        $hobbyScore = $this->calculateScore($userHobbies, $profileHobbies);
        $goalScore = $this->calculateScore($userGoals, $profileGoals);
        $characteristicScore = $this->calculateScore($userCharacteristics, $profileCharacteristics);
        $qaScore = $this->calculateQA($userAnswers, $profileAnswers);
    
        // Weighted Average
        $matchPercentage = (
            ($hobbyScore * $weights['hobbies']) +
            ($goalScore * $weights['goals']) +
            ($characteristicScore * $weights['characteristics']) +
            ($qaScore * $weights['questions'])
        ) * 100;
    
        return round($matchPercentage, 1);
    }

    private function calculateScore(array $userData, array $profileData)
    {
        $commonItems = count(array_intersect($userData, $profileData));
        $totalItems = count(array_unique(array_merge($userData, $profileData)));

        return $totalItems > 0 ? ($commonItems / $totalItems) : 0;
    }

    private function calculateQA(array $userAnswers, array $profileAnswers)
    {
        $matchingAnswers = 0;
        $totalQuestions = count($userAnswers);

        foreach ($userAnswers as $questionId => $answer) {
            if (isset($profileAnswers[$questionId]) && $profileAnswers[$questionId] === $answer) {
                $matchingAnswers++;
            }
        }

        return $totalQuestions > 0 ? ($matchingAnswers / $totalQuestions) : 0;
    }

    private function createMatch($userId ,$swipedUserId){

        UserMatch::updateOrCreate(
            [
                'user_id' => $userId,
                'match_user_id' => $swipedUserId, 
            ],
            [
                'status' => "matched", 
            ]
        );

        UserMatch::updateOrCreate(
            [
                'user_id' => $swipedUserId,
                'match_user_id' => $userId,
            ],
            [
                'status' => 'matched',
            ]
        );
    }

    private function isProfileMatch($userId, $recieverUserId)
    {
        // Check if both users have matched each other
        $userToSwipedUserMatch = UserMatch::where('user_id', $userId)
            ->where('match_user_id', $recieverUserId)
            ->where('status', 'matched')
            ->first();
    
        $swipedUserToUserMatch = UserMatch::where('user_id', $recieverUserId)
            ->where('match_user_id', $userId)
            ->where('status', 'matched')
            ->first();
    
        if ($userToSwipedUserMatch && $swipedUserToUserMatch) {
            return true; 
        }
    
        return false; 
    }
    
}
