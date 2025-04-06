<?php
class ArticleAnalyzer {
    private $article;
    
    public function __construct($article) {
        $this->article = $article;
    }
    
    public function analyze() {
        return [
            'topic' => $this->detectTopic(),
            'summary' => $this->generateSummary(),
            'sentiment' => $this->analyzeSentiment(),
            'entities' => $this->extractEntities()
        ];
    }
    
    private function detectTopic() {
        $topics = [
            'politics' => ['government', 'minister', 'election', 'party', 'political'],
            'sports' => ['match', 'game', 'player', 'team', 'sport'],
            'tech' => ['technology', 'digital', 'app', 'software', 'internet'],
            'business' => ['market', 'economy', 'business', 'company', 'stock'],
            'entertainment' => ['movie', 'film', 'actor', 'celebrity', 'entertainment']
        ];
        
        $content = strtolower($this->article['title'] . ' ' . $this->article['content']);
        $maxMatches = 0;
        $detectedTopic = 'general';
        
        foreach ($topics as $topic => $keywords) {
            $matches = 0;
            foreach ($keywords as $keyword) {
                if (strpos($content, $keyword) !== false) {
                    $matches++;
                }
            }
            if ($matches > $maxMatches) {
                $maxMatches = $matches;
                $detectedTopic = $topic;
            }
        }
        
        return $detectedTopic;
    }
    
    private function generateSummary() {
        $content = $this->article['content'];
        $sentences = preg_split('/[.!?]+/', $content);
        $summary = '';
        $wordCount = 0;
        
        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            if (empty($sentence)) continue;
            
            $sentenceWordCount = str_word_count($sentence);
            if ($wordCount + $sentenceWordCount > 150) break;
            
            $summary .= $sentence . '. ';
            $wordCount += $sentenceWordCount;
        }
        
        return trim($summary);
    }
    
    private function analyzeSentiment() {
        $positiveWords = ['good', 'great', 'excellent', 'positive', 'success', 'win', 'happy'];
        $negativeWords = ['bad', 'poor', 'negative', 'failure', 'lose', 'sad', 'problem'];
        
        $content = strtolower($this->article['content']);
        $positiveCount = 0;
        $negativeCount = 0;
        
        foreach ($positiveWords as $word) {
            $positiveCount += substr_count($content, $word);
        }
        
        foreach ($negativeWords as $word) {
            $negativeCount += substr_count($content, $word);
        }
        
        $total = $positiveCount + $negativeCount;
        if ($total == 0) return 0;
        
        return ($positiveCount - $negativeCount) / $total;
    }
    
    private function extractEntities() {
        $content = $this->article['content'];
        $entities = [];
        
        // Extract states (basic implementation)
        $states = [
            'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh',
            'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand',
            'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur',
            'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab',
            'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura',
            'Uttar Pradesh', 'Uttarakhand', 'West Bengal'
        ];
        
        foreach ($states as $state) {
            if (strpos($content, $state) !== false) {
                $entities[] = $state;
            }
        }
        
        // Extract people (basic implementation)
        preg_match_all('/[A-Z][a-z]+ [A-Z][a-z]+/', $content, $matches);
        foreach ($matches[0] as $name) {
            if (!in_array($name, $entities)) {
                $entities[] = $name;
            }
        }
        
        return $entities;
    }
}
?> 