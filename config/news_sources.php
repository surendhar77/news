<?php
function getNewsSources() {
    return [
        'toi' => [
            'name' => 'Times of India',
            'url' => 'https://timesofindia.indiatimes.com',
            'rss_feeds' => [
                'latest' => 'https://timesofindia.indiatimes.com/rssfeedstopstories.cms',
                'india' => 'https://timesofindia.indiatimes.com/rssfeeds/-2128936835.cms',
                'world' => 'https://timesofindia.indiatimes.com/rssfeeds/296589292.cms',
                'business' => 'https://timesofindia.indiatimes.com/rssfeeds/1898055.cms',
                'sports' => 'https://timesofindia.indiatimes.com/rssfeeds/4719148.cms',
                'entertainment' => 'https://timesofindia.indiatimes.com/rssfeeds/1081479906.cms',
                'tech' => 'https://timesofindia.indiatimes.com/rssfeeds/66949542.cms'
            ]
        ],
        'thehindu' => [
            'name' => 'The Hindu',
            'url' => 'https://www.thehindu.com',
            'rss_feeds' => [
                'latest' => 'https://www.thehindu.com/feeder/default.rss',
                'india' => 'https://www.thehindu.com/news/national/feeder/default.rss',
                'world' => 'https://www.thehindu.com/news/international/feeder/default.rss',
                'business' => 'https://www.thehindu.com/business/feeder/default.rss',
                'sports' => 'https://www.thehindu.com/sport/feeder/default.rss',
                'entertainment' => 'https://www.thehindu.com/entertainment/feeder/default.rss',
                'tech' => 'https://www.thehindu.com/sci-tech/technology/feeder/default.rss'
            ]
        ],
        'hindustantimes' => [
            'name' => 'Hindustan Times',
            'url' => 'https://www.hindustantimes.com',
            'rss_feeds' => [
                'latest' => 'https://www.hindustantimes.com/feeds/rss/latest/rssfeed.xml',
                'india' => 'https://www.hindustantimes.com/feeds/rss/india/rssfeed.xml',
                'world' => 'https://www.hindustantimes.com/feeds/rss/world/rssfeed.xml',
                'business' => 'https://www.hindustantimes.com/feeds/rss/business/rssfeed.xml',
                'sports' => 'https://www.hindustantimes.com/feeds/rss/sports/rssfeed.xml',
                'entertainment' => 'https://www.hindustantimes.com/feeds/rss/entertainment/rssfeed.xml',
                'tech' => 'https://www.hindustantimes.com/feeds/rss/tech/rssfeed.xml'
            ]
        ]
    ];
}

function fetchCategories($source) {
    $sources = getNewsSources();
    if (!isset($sources[$source])) {
        return [];
    }
    
    return $sources[$source]['rss_feeds'];
}
?> 