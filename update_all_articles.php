<?php
require_once 'config/fetch_articles.php';
require_once 'config/news_sources.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone
date_default_timezone_set('Asia/Kolkata');

// Function to log messages
function logMessage($message) {
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents('update_log.txt', $logMessage, FILE_APPEND);
}

// Get all news sources
$sources = getNewsSources();

// Create articles directory if it doesn't exist
if (!file_exists('articles')) {
    mkdir('articles', 0777, true);
}

// Fetch and save articles for each source
foreach ($sources as $sourceKey => $source) {
    logMessage("Processing source: {$source['name']}");
    
    // Fetch categories for this source
    $categories = fetchCategories($sourceKey);
    if (empty($categories)) {
        logMessage("No categories found for {$source['name']}");
        continue;
    }
    
    foreach ($categories as $category => $categoryUrl) {
        logMessage("Fetching articles for category: $category");
        
        try {
            $articles = fetchArticles($sourceKey, $categoryUrl);
            
            if (isset($articles['error'])) {
                logMessage("Error fetching articles: {$articles['error']}");
                continue;
            }
            
            if (empty($articles)) {
                logMessage("No articles found for category: $category");
                continue;
            }
            
            if (saveArticles($category, $articles)) {
                logMessage("Successfully saved " . count($articles) . " articles for category: $category");
            } else {
                logMessage("Failed to save articles for category: $category");
            }
        } catch (Exception $e) {
            logMessage("Exception while processing category $category: " . $e->getMessage());
        }
    }
}

logMessage("Article update process completed");
?> 