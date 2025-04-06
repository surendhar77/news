<?php
require_once 'ArticleAnalyzer.php';
require_once 'news_sources.php';

function fetchArticles($source, $rssUrl) {
    $sources = getNewsSources();
    if (!isset($sources[$source])) {
        return ['error' => 'Invalid news source'];
    }
    
    $config = $sources[$source];
    
    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $rssUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // Execute cURL session
    $xml = curl_exec($ch);
    
    // Check for errors
    if(curl_errno($ch)) {
        return ['error' => 'Failed to fetch RSS feed: ' . curl_error($ch)];
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Parse RSS feed
    $feed = simplexml_load_string($xml);
    if ($feed === false) {
        return ['error' => 'Failed to parse RSS feed'];
    }
    
    $articles = [];
    foreach ($feed->channel->item as $item) {
        $title = (string)$item->title;
        $description = (string)$item->description;
        $link = (string)$item->link;
        $pubDate = (string)$item->pubDate;
        
        // Try to get image from enclosure or media:content
        $image = '';
        if (isset($item->enclosure)) {
            $image = (string)$item->enclosure['url'];
        } elseif (isset($item->children('media', true)->content)) {
            $image = (string)$item->children('media', true)->content['url'];
        }
        
        $article = [
            'title' => $title,
            'content' => $description,
            'image' => $image,
            'link' => $link,
            'source' => $config['name'],
            'date' => date('Y-m-d H:i:s', strtotime($pubDate))
        ];
        
        // Analyze article
        $analyzer = new ArticleAnalyzer($article);
        $analysis = $analyzer->analyze();
        
        $articles[] = array_merge($article, $analysis);
    }
    
    return $articles;
}

// Function to save articles to file
function saveArticles($category, $articles) {
    if (empty($articles)) {
        return false;
    }
    
    $file = "articles/{$category}.php";
    $content = "<?php include '../header.php'; ?>\n\n";
    $content .= "<section class='article-detail'>\n";
    
    foreach($articles as $article) {
        $content .= "    <article class='news-card'>\n";
        $content .= "        <h1>" . htmlspecialchars($article['title']) . "</h1>\n";
        $content .= "        <div class='article-meta'>\n";
        $content .= "            <span class='source'>" . htmlspecialchars($article['source']) . "</span>\n";
        $content .= "            <span class='date'>" . date('F j, Y', strtotime($article['date'])) . "</span>\n";
        $content .= "            <span class='topic'>" . htmlspecialchars($article['topic']) . "</span>\n";
        $content .= "            <span class='sentiment' data-score='" . $article['sentiment'] . "'>\n";
        $content .= "                Sentiment: " . ($article['sentiment'] > 0 ? 'Positive' : ($article['sentiment'] < 0 ? 'Negative' : 'Neutral')) . "\n";
        $content .= "            </span>\n";
        $content .= "        </div>\n";
        
        if($article['image']) {
            $content .= "        <img src='" . htmlspecialchars($article['image']) . "' alt='" . htmlspecialchars($article['title']) . "' class='article-image'>\n";
        }
        
        $content .= "        <div class='article-content'>\n";
        $content .= "            <p class='summary'>" . htmlspecialchars($article['summary']) . "</p>\n";
        
        if(!empty($article['entities'])) {
            $content .= "            <div class='entities'>\n";
            $content .= "                <h3>Key Entities:</h3>\n";
            $content .= "                <ul>\n";
            foreach($article['entities'] as $entity) {
                $content .= "                    <li>" . htmlspecialchars($entity) . "</li>\n";
            }
            $content .= "                </ul>\n";
            $content .= "            </div>\n";
        }
        
        if($article['link']) {
            $content .= "            <a href='" . htmlspecialchars($article['link']) . "' class='read-more' target='_blank'>Read more at " . htmlspecialchars($article['source']) . "</a>\n";
        }
        
        $content .= "        </div>\n";
        $content .= "    </article>\n";
    }
    
    $content .= "</section>\n\n";
    $content .= "<?php include '../footer.php'; ?>";
    
    return file_put_contents($file, $content) !== false;
}
?> 