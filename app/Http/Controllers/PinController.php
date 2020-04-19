<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pin;
use App\Http\Resources\Pin as PinResource;
use Auth;
class PinController extends Controller
{

//    public function __construct()
//    {
//        $this->middleware('auth', ['except'=> ['index', 'show']]);
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pin = Pin::paginate(11);

        return PinResource::collection($pin);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $explode = explode(',', $request->img);
        $decoded = base64_decode($explode[1]);
        if(str_contains($explode[0], 'jpeg'))
            $extention = 'jpeg';
        else
            $extention ="png";

        $filename = str_random().'.'.$extention;

        $path = public_path('/images').'/'.$filename;

        file_put_contents($path,$decoded);
        $pin = Pin::create($request->except('img')+ ['img' => 'http://127.0.0.1:8000/images/'.$filename]);
        return $pin;

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('questions.show')->with('question', $question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);
        if($question->user->id != Auth::id()){
            return abort(403);

        }
        return view('questions.edit')->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        if($question->user->id != Auth::id()){
            return abort(403);

        }
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' =>'required'
        ]);
        $question->title = $request->title;
        $question->description = $request->description;
        $question->update();
        return view('questions.show')->with('question', $question);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();
        return view('questions.index');
    }
}