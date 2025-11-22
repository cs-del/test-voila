<?php

use Illuminate\Support\Str;

if (!function_exists('estimated_reading_time')) {
    /**
     * Calculate estimated reading time for a given text content.
     *
     * @param string $content
     * @param int $wordsPerMinute
     * @return int
     */
    function estimated_reading_time($content, $wordsPerMinute = 200)
    {
        // Remove HTML tags for accurate word count
        $text = strip_tags($content);
        
        // Count words
        $wordCount = str_word_count($text);
        
        // Calculate reading time in minutes
        $readingTime = ceil($wordCount / $wordsPerMinute);
        
        // Ensure minimum of 1 minute
        return max(1, $readingTime);
    }
}