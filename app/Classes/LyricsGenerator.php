<?php
/**
 * Created by PhpStorm.
 * User: tobischw
 * Date: 9/8/2016
 * Time: 8:18 PM
 */

namespace App\Classes;

use App\Classes\MarkovPHP;
use App\Lyric;

define("MARKOV_ORDER", 5);
define("VERSE_LENGTH", 5);
define("BRIDGE_LENGTH", 2);
define("TITLE_LENGTH", 1);
define("REFRAIN_LENGTH", 5);

class LyricsGenerator {

    public $genre_id = null;
    public $max_songs = null;
    public $structure = null;

    private $markov_engine = null;

    /**
     * Main function for generating the lyrics
     *
     * @param $genre_id
     * @param $max_songs
     * @param $structure
     *
     * @return mixed|string
     */
    function __construct($genre_id, $max_songs, $structure) {

        $this->genre_id = $genre_id;
        $this->max_songs = $max_songs;
        $this->structure = strtoupper($structure);

        $this->markov_engine = new MarkovPHP\WordChain($this->GetLyricsSeeds(), 4);

    }

    /**
     * Actually generates the lyrics
     *
     * @return mixed
     */
    function Generate() {

        $final_lyric = null;
        $structure = $this->structure;

        $title =  $this->GenerateSegment(TITLE_LENGTH);
        $chorus = $this->GenerateSegment(REFRAIN_LENGTH) . PHP_EOL;

        for( $i = 0; $i < strlen($structure); $i++ ) {
            $char = $structure[$i];
            if($char == 'V'){
                $final_lyric .= $this->GenerateSegment(VERSE_LENGTH) . PHP_EOL;
            }elseif($char == 'B'){
                $final_lyric .=$this->GenerateSegment(BRIDGE_LENGTH) . PHP_EOL;
            }elseif($char == 'C'){
                $final_lyric .= $chorus . PHP_EOL;
            }
        }

        return [$title, $final_lyric];

    }

    /**
     * Gets the songs based on parameters that will be used as our seed for the markov chain
     *
     * @return null|string
     */
    function GetLyricsSeeds() {

        $lyrics = Lyric::where('genre_id', $this->genre_id)->limit($this->max_songs)->get();
        $seed_content = null;

        foreach ($lyrics as $lyric)
        {
            $seed_content .= PHP_EOL . $lyric->lyrics;
        }

        return $seed_content;
    }

    /**
     * Generates custom segments
     *
     * @param $length
     * @return mixed
     */
    function GenerateSegment($length){

        $segment = $this->markov_engine->generate($length);

        return $segment;

    }

}