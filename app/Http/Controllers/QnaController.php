<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserQA;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QnaController extends Controller
{   
    public function index()
    {
        $questions = Question::all();
        return response()->json(['status' => 'success', 'data' => $questions], 200);
    }

    public function createQuestion(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
        ]);

        $question = Question::create([
            'title' => $request->title,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Question created successfully', 'data' => $question], 201);
    }

    public function getQuestion($id)
    {
        $question = Question::find($id);
        
        if (!$question) {
            return response()->json(['status' => 'error', 'message' => 'Question not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $question], 200);
    }


    public function updateQuestion(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
        ]);

        $question = Question::find($id);

        if (!$question) {
            return response()->json(['status' => 'error', 'message' => 'Question not found'], 404);
        }

        $question->update([
            'title' => $request->title,
            'option_1' => $request->option_1,
            'option_2' => $request->option_2,
            'option_3' => $request->option_3,
            'option_4' => $request->option_4,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Question updated successfully', 'data' => $question], 200);
    }

    public function deleteQuestion($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['status' => 'error', 'message' => 'Question not found'], 404);
        }
        $question->delete();
        return response()->json(['status' => 'success', 'message' => 'Question deleted successfully'], 200);
    }
    public function getQuestions()
    {
        $getAllQuestions = Question::all();

        if ($getAllQuestions) {
            return response()->json(['status' => 'success','data' => $getAllQuestions], 200);
        } else {
            return response()->json(['status' => "error", 'data' => NULL,], 500);
        }
    }

    public function userAnswers(Request $request){
        try {
            $request->validate([
                'answers' => 'required|array',
                'question_id.*' => 'exists:questions,id',
            ]);

            $user = auth()->user();
            foreach ($request->answers as $answer) {
                // Update or create the user's answer for the a question
                UserQA::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $answer['question_id'],
                    ],
                    [
                        'selected_answer' => $answer['selected_answer'], 
                    ]
                );
            }
            return response()->json(['status' => 'success', 'message' => 'Answers saved successfully']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error','message' => $th->getMessage()], 500);
        }
    }

    public function getAnsweredQuestions(Request $request){
        try {
            $profile_id = $request->profile_id;
            $profiles = User::with(['userQA.question'])
            ->where('id', '=', $profile_id )
            ->get(); 

            return response()->json(['status' => 'success', 'data' => $profiles], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }
}
