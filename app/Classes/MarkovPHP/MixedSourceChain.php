<?php
/**
 * Creates a simple sentence chain mixing two text sources
 */

namespace App\Classes\MarkovPHP;

class MixedSourceChain extends WordChain
{
    /** @var WordChain  */
    protected $source1Words;

    /** @var string */
    protected $source2;

    /** @var int */
    protected $sizeEach;

    public function __construct($source1, $source2, $totalWords = 20)
    {
        $this->sizeEach = round($totalWords/2);
        $source1 = $this->prepareContent($source1);
        $source2 = $this->prepareContent($source2);

        $this->source1Words = new WordChain($source1, $this->sizeEach);
        $this->source2 = $source2;
    }

    /**
     * @return string
     */
    public function generate()
    {
        $first = $this->source1Words->getRandomLink();
        $second = $this->splitText($this->source2, 1);

        $split = $this->splitText($first, 1);
        $connector = $split[count($split)-1];

        $search = preg_grep('/\b' . preg_quote($connector, '/') . '\b/', $second);

        // if nothing was found, use the whole sample and get a rand complement
        if (!count($search)) {
            $search = $second;
        }

        $pos = array_rand($search);
        $complement = array_slice($second, $pos + 1, $this->sizeEach);

        $first[0] = strtoupper($first[0]);
        $complement[count($complement)-1] = $this->removeAllPunctuation($complement[count($complement)-1]);

        return $first . ' ' . implode(' ', $complement);
    }

    public function prepareContent($content)
    {
        $content = strtolower($content);
        $content = str_replace(['.', '-', ';', ':', '"', '“'], "", $content);

        return $content;
    }

    public function removeAllPunctuation($content)
    {
        return str_replace([',', '.', '-', ';', ':', '"', "!", "?", "\""], "", $content);
    }
}
