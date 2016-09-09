<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;

use App\Http\Requests;
use App\Classes\LyricsGenerator;

class GeneratorController extends Controller
{
    /**
     * Shows the main homepage
     *
     * @param Array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return view('main');
    }

    /**
     * Processes the request and generates the lyrics
     *
     * @param Request $request
     * @return false
     */
    public function generate(Request $request)
    {
        $genre_id = $request->input('genre_id');
        $max_songs = $request->input('max_songs');
        $structure = $request->input('structure');

        //Validating the request
        $validator = Validator::make($request->all(), [
            'genre_id' => 'required|integer',
            'max_songs' => 'required|integer|min:1|max:200',
            'structure' => 'required|max:12',
        ]);

        //If it fails, show the error as to why. If not, continue with generator
        if ($validator->fails()) {

            return redirect('/')->withErrors($validator)->withInput();

        } else {

            $generator = new LyricsGenerator($genre_id, $max_songs, $structure);
            $song = $generator->Generate();

            $title = $song[0];

            $lyric = $song[1];
          //  $lyric =  nl2br($lyric);

            return view('main', [ 'title' => $title, 'lyric' => $lyric]);

        }

    }

}
