<?php
require_once 'config/news_sources.php';
require_once 'config/fetch_articles.php';

// Language handling
$available_languages = [
    'en' => [
        'code' => 'ENGLISH',
        'name' => 'English',
        'native' => 'ENGLISH'
    ],
    'hi' => [
        'code' => 'हिंदी',
        'name' => 'Hindi',
        'native' => 'हिंदी'
    ],
    'mr' => [
        'code' => 'मराठी',
        'name' => 'Marathi',
        'native' => 'मराठी'
    ],
    'bn' => [
        'code' => 'বাংলা',
        'name' => 'Bengali',
        'native' => 'বাংলা'
    ],
    'gu' => [
        'code' => 'ગુજરાતી',
        'name' => 'Gujarati',
        'native' => 'ગુજરાતી'
    ],
    'ml' => [
        'code' => 'മലയാളം',
        'name' => 'Malayalam',
        'native' => 'മലയാളം'
    ],
    'ta' => [
        'code' => 'தமிழ்',
        'name' => 'Tamil',
        'native' => 'தமிழ்'
    ]
];

// Get current language from URL parameter or default to English
$current_lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';
$current_lang = array_key_exists($current_lang, $available_languages) ? $current_lang : 'en';

// Load language-specific content
$translations = [
    'en' => [
        'latest' => 'Latest',
        'india' => 'India',
        'world' => 'World',
        'business' => 'Business',
        'sports' => 'Sports',
        'entertainment' => 'Entertainment',
        'tech' => 'Tech',
        'search_placeholder' => 'Search news...',
        'subscribe' => 'Subscribe',
        'sign_in' => 'Sign in',
        'trending' => 'TRENDING',
        'edition' => 'EDITION',
        'last_updated' => 'Last updated',
        'all_rights_reserved' => 'All rights reserved',
        'read_more' => 'Read more at',
        'key_entities' => 'Key Entities',
        'sentiment' => 'Sentiment',
        'positive' => 'Positive',
        'negative' => 'Negative',
        'neutral' => 'Neutral',
        'news' => 'News',
        'newsletters' => 'Newsletters'
    ],
    'hi' => [
        'latest' => 'ताज़ा खबर',
        'india' => 'भारत',
        'world' => 'विश्व',
        'business' => 'व्यापार',
        'sports' => 'खेल',
        'entertainment' => 'मनोरंजन',
        'tech' => 'टेक',
        'search_placeholder' => 'समाचार खोजें...',
        'subscribe' => 'सदस्यता लें',
        'sign_in' => 'साइन इन',
        'trending' => 'ट्रेंडिंग',
        'edition' => 'संस्करण',
        'last_updated' => 'आखरी अपडेट',
        'all_rights_reserved' => 'सर्वाधिकार सुरक्षित',
        'read_more' => 'और पढ़ें',
        'key_entities' => 'प्रमुख विषय',
        'sentiment' => 'भावना',
        'positive' => 'सकारात्मक',
        'negative' => 'नकारात्मक',
        'neutral' => 'तटस्थ',
        'news' => 'समाचार',
        'newsletters' => 'न्यूज़लेटर'
    ],
    'mr' => [
        'latest' => 'ताज्या बातम्या',
        'india' => 'भारत',
        'world' => 'जग',
        'business' => 'व्यवसाय',
        'sports' => 'क्रीडा',
        'entertainment' => 'मनोरंजन',
        'tech' => 'तंत्रज्ञान',
        'search_placeholder' => 'बातम्या शोधा...',
        'subscribe' => 'सबस्क्राइब करा',
        'sign_in' => 'साइन इन',
        'trending' => 'ट्रेंडिंग',
        'edition' => 'आवृत्ती',
        'last_updated' => 'शेवटचे अपडेट',
        'all_rights_reserved' => 'सर्व हक्क राखीव',
        'read_more' => 'वाचा',
        'key_entities' => 'महत्त्वाचे मुद्दे',
        'sentiment' => 'भावना',
        'positive' => 'सकारात्मक',
        'negative' => 'नकारात्मक',
        'neutral' => 'तटस्थ',
        'news' => 'बातम्या',
        'newsletters' => 'न्यूज़लेटर'
    ],
    'bn' => [
        'latest' => 'সর্বশেষ',
        'india' => 'ভারত',
        'world' => 'বিশ্ব',
        'business' => 'ব্যবসা',
        'sports' => 'ক্রীড়া',
        'entertainment' => 'বিনোদন',
        'tech' => 'প্রযুক্তি',
        'search_placeholder' => 'খবর খুঁজুন...',
        'subscribe' => 'সাবস্ক্রাইব',
        'sign_in' => 'সাইন ইন',
        'trending' => 'ট্রেন্ডিং',
        'edition' => 'সংস্করণ',
        'last_updated' => 'সর্বশেষ আপডেট',
        'all_rights_reserved' => 'সর্বস্বত্ব সংরক্ষিত',
        'read_more' => 'আরও পড়ুন',
        'key_entities' => 'মূল বিষয়',
        'sentiment' => 'অনুভূতি',
        'positive' => 'ইতিবাচক',
        'negative' => 'নেতিবাচক',
        'neutral' => 'নিরপেক্ষ',
        'news' => 'খবর',
        'newsletters' => 'নোটিফিকেশন'
    ],
    'gu' => [
        'latest' => 'તાજા સમાચાર',
        'india' => 'ભારત',
        'world' => 'વિશ્વ',
        'business' => 'વ્યાપાર',
        'sports' => 'રમતગમત',
        'entertainment' => 'મનોરંજન',
        'tech' => 'ટેક',
        'search_placeholder' => 'સમાચાર શોધો...',
        'subscribe' => 'સબસ્ક્રાઇબ',
        'sign_in' => 'સાઇન ઇન',
        'trending' => 'ટ્રેન્ડિંગ',
        'edition' => 'આવૃત્તি',
        'last_updated' => 'છેલ્લું અપડેટ',
        'all_rights_reserved' => 'બધા અધિકારો સુરક્ષિત',
        'read_more' => 'વધુ વાંચો',
        'key_entities' => 'મુખ્ય મુદ્દાઓ',
        'sentiment' => 'લાગણી',
        'positive' => 'સકારાત્મક',
        'negative' => 'નકારાત્મક',
        'neutral' => 'તટસ્થ',
        'news' => 'સમાચાર',
        'newsletters' => 'નોટિફિકેશન'
    ],
    'ml' => [
        'latest' => 'പുതിയ വാർത്ത',
        'india' => 'ഇന്ത്യ',
        'world' => 'ലോകം',
        'business' => 'ബിസിനസ്',
        'sports' => 'കായികം',
        'entertainment' => 'വിനോദം',
        'tech' => 'ടെക്',
        'search_placeholder' => 'വാർത്ത തിരയുക...',
        'subscribe' => 'സബ്സ്ക്രൈബ്',
        'sign_in' => 'സൈൻ ഇൻ',
        'trending' => 'ട്രെൻഡിംഗ്',
        'edition' => 'പതിപ്പ്',
        'last_updated' => 'അവസാന അപ്ഡേറ്റ്',
        'all_rights_reserved' => 'എല്ലാ അവകാശങ്ങളും നിക്ഷിപ്തം',
        'read_more' => 'കൂടുതൽ വായിക്കുക',
        'key_entities' => 'പ്രധാന വിഷയങ്ങൾ',
        'sentiment' => 'വികാരം',
        'positive' => 'അനുകൂലം',
        'negative' => 'പ്രതികൂലം',
        'neutral' => 'നിഷ്പക്ഷം',
        'news' => 'വാർത്ത',
        'newsletters' => 'നോടിഫികേഷന'
    ],
    'ta' => [
        'latest' => 'சமீபத்திய செய்திகள்',
        'india' => 'இந்தியா',
        'world' => 'உலகம்',
        'business' => 'வணிகம்',
        'sports' => 'விளையாட்டு',
        'entertainment' => 'பொழுதுபோக்கு',
        'tech' => 'டெக்',
        'search_placeholder' => 'செய்திகளைத் தேடுங்கள்...',
        'subscribe' => 'சந்தா',
        'sign_in' => 'உள்நுழைக',
        'trending' => 'டிரெண்டிங்',
        'edition' => 'பதிப்பு',
        'last_updated' => 'கடைசியாக புதுப்பிக்கப்பட்டது',
        'all_rights_reserved' => 'அனைத்து உரிமைகளும் பாதுகாக்கப்பட்டவை',
        'read_more' => 'மேலும் படிக்க',
        'key_entities' => 'முக்கிய தலைப்புகள்',
        'sentiment' => 'உணர்வு',
        'positive' => 'நேர்மறை',
        'negative' => 'எதிர்மறை',
        'neutral' => 'நடுநிலை',
        'news' => 'செய்திகள்',
        'newsletters' => 'நோடிஃபிகேஷன்'
    ]
];

// Default to English if translation not available
$lang = isset($translations[$current_lang]) ? $translations[$current_lang] : $translations['en'];
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Daily Hunt</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="language-select">
                    <?php
                    foreach ($available_languages as $code => $language) {
                        if ($code === $current_lang) {
                            echo "<span>{$language['native']}</span>";
                        } else {
                            echo " | <a href='?lang={$code}' data-lang='{$code}'>{$language['native']}</a>";
                        }
                    }
                    ?>
                </div>
                <div class="top-right">
                    <a href="mailto:newsletters@thedailyhunt.com?subject=Newsletter%20Subscription&body=I%20would%20like%20to%20subscribe%20to%20The%20Daily%20Hunt%20newsletters." class="newsletter-btn">
                        <i class="fas fa-envelope"></i> <?php echo isset($lang['newsletters']) ? $lang['newsletters'] : 'Newsletters'; ?>
                    </a>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/TheDailyHunt" target="_blank" title="Follow us on Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/TheDailyHunt" target="_blank" title="Follow us on Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/TheDailyHunt" target="_blank" title="Follow us on Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.youtube.com/TheDailyHunt" target="_blank" title="Subscribe to our YouTube channel"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-header container">
            <div class="header-date">
                <span><?php echo date('l, M d, Y'); ?></span>
                <span class="edition"><?php echo $lang['edition']; ?>: <select><option>India</option></select></span>
            </div>
            
            <div class="logo-container">
                <h1>The Daily Hunt</h1>
                <span class="tagline">JOURNALISM OF COURAGE</span>
            </div>

            <div class="header-right">
                <div class="search-container">
                    <form action="#" method="GET" class="search-form">
                        <input type="text" name="search" placeholder="<?php echo $lang['search_placeholder']; ?>" class="search-input">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="auth-buttons">
                    <button class="subscribe-btn"><?php echo $lang['subscribe']; ?></button>
                    <button class="sign-in-btn"><?php echo $lang['sign_in']; ?></button>
                </div>
            </div>
        </div>

        <nav class="main-nav">
            <div class="container">
                <ul class="primary-nav">
                    <li><a href="#latest"><?php echo $lang['latest']; ?></a></li>
                    <li><a href="#india"><?php echo $lang['india']; ?></a></li>
                    <li><a href="#world"><?php echo $lang['world']; ?></a></li>
                    <li><a href="#business"><?php echo $lang['business']; ?></a></li>
                    <li><a href="#sports"><?php echo $lang['sports']; ?></a></li>
                    <li><a href="#entertainment"><?php echo $lang['entertainment']; ?></a></li>
                    <li><a href="#tech"><?php echo $lang['tech']; ?></a></li>
                </ul>
                <ul class="trending-nav">
                    <li class="trending-label"><?php echo $lang['trending']; ?>:</li>
                    <li><a href="#">IPL Live Score</a></li>
                    <li><a href="#">Premium</a></li>
                    <li><a href="#">Health & Wellness</a></li>
                    <li><a href="#">Research</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php
        $sources = getNewsSources();
        $categories = ['latest', 'india', 'world', 'business', 'sports', 'entertainment', 'tech'];
        
        foreach ($categories as $category) {
            echo "<section id='{$category}' class='category-section' data-category='{$category}'>";
            echo "<h2 class='category-heading lang-{$current_lang}'>{$lang[$category]} {$lang['news']}</h2>";
            echo "<div class='news-grid'>";
            
            foreach ($sources as $sourceKey => $source) {
                // Get language-specific RSS feed URL
                $rssUrl = isset($source['rss_feeds'][$current_lang][$category]) 
                    ? $source['rss_feeds'][$current_lang][$category] 
                    : $source['rss_feeds'][$category];
                
                $articles = fetchArticles($sourceKey, $rssUrl);
                
                if (!isset($articles['error']) && !empty($articles)) {
                    $displayArticles = array_slice($articles, 0, 3);
                    
                    foreach ($displayArticles as $article) {
                        // Get translated content or use original if translation not available
                        $title = isset($article['translations'][$current_lang]['title']) 
                            ? $article['translations'][$current_lang]['title'] 
                            : $article['title'];
                            
                        $summary = isset($article['translations'][$current_lang]['summary']) 
                            ? $article['translations'][$current_lang]['summary'] 
                            : $article['summary'];
                            
                        $source_name = isset($article['translations'][$current_lang]['source']) 
                            ? $article['translations'][$current_lang]['source'] 
                            : $article['source'];
                            
                        $topic = isset($article['translations'][$current_lang]['topic']) 
                            ? $article['translations'][$current_lang]['topic'] 
                            : $article['topic'];

                        echo "<article class='news-card' lang='{$current_lang}' data-category='{$category}'>";
                        echo "<div class='article-meta'>";
                        echo "<span class='source lang-{$current_lang}'>{$source_name}</span>";
                        
                        // Format date according to language
                        $date = new DateTime($article['date']);
                        $formatted_date = formatDateByLanguage($date, $current_lang);
                        echo "<span class='date lang-{$current_lang}'>{$formatted_date}</span>";
                        
                        echo "<span class='topic lang-{$current_lang}'>{$topic}</span>";
                        
                        $sentiment_text = $article['sentiment'] > 0 
                            ? $lang['positive'] 
                            : ($article['sentiment'] < 0 ? $lang['negative'] : $lang['neutral']);
                            
                        echo "<span class='sentiment lang-{$current_lang}' data-score='{$article['sentiment']}'>";
                        echo "{$lang['sentiment']}: {$sentiment_text}";
                        echo "</span>";
                        echo "</div>";
                        
                        if ($article['image']) {
                            echo "<img src='{$article['image']}' alt='" . htmlspecialchars($title, ENT_QUOTES) . "' class='article-image'>";
                        }
                        
                        echo "<h3 class='article-title lang-{$current_lang}'>{$title}</h3>";
                        echo "<p class='summary lang-{$current_lang}'>{$summary}</p>";
                        
                        if (!empty($article['entities'])) {
                            echo "<div class='entities'>";
                            echo "<h4 class='lang-{$current_lang}'>{$lang['key_entities']}:</h4>";
                            echo "<ul class='lang-{$current_lang}'>";
                            foreach ($article['entities'] as $entity) {
                                $translated_entity = isset($article['translations'][$current_lang]['entities'][$entity])
                                    ? $article['translations'][$current_lang]['entities'][$entity]
                                    : $entity;
                                echo "<li>{$translated_entity}</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        }
                        
                        echo "<a href='{$article['link']}' class='read-more lang-{$current_lang}' target='_blank'>";
                        echo "{$lang['read_more']} {$source_name} <i class='fas fa-external-link-alt'></i>";
                        echo "</a>";
                        echo "</article>";
                    }
                }
            }
            
            echo "</div>";
            echo "</section>";
        }

        // Helper function for language-specific date formatting
        function formatDateByLanguage($date, $lang_code) {
            $months = [
                'ta' => [
                    'January' => 'ஜனவரி',
                    'February' => 'பிப்ரவரி',
                    'March' => 'மார்ச்',
                    'April' => 'ஏப்ரல்',
                    'May' => 'மே',
                    'June' => 'ஜூன்',
                    'July' => 'ஜூலை',
                    'August' => 'ஆகஸ்ட்',
                    'September' => 'செப்டம்பர்',
                    'October' => 'அக்டோபர்',
                    'November' => 'நவம்பர்',
                    'December' => 'டிசம்பர்'
                ],
                'hi' => [
                    'January' => 'जनवरी',
                    'February' => 'फरवरी',
                    'March' => 'मार्च',
                    'April' => 'अप्रैल',
                    'May' => 'मई',
                    'June' => 'जून',
                    'July' => 'जुलाई',
                    'August' => 'अगस्त',
                    'September' => 'सितंबर',
                    'October' => 'अक्टूबर',
                    'November' => 'नवंबर',
                    'December' => 'दिसंबर'
                ],
                // Add more languages as needed
            ];

            $formatted = $date->format('j F Y');
            
            if (isset($months[$lang_code])) {
                foreach ($months[$lang_code] as $en => $translated) {
                    $formatted = str_replace($en, $translated, $formatted);
                }
            }
            
            return $formatted;
        }
        ?>
    </main>

    <footer>
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> The Daily Hunt. <?php echo $lang['all_rights_reserved']; ?></p>
            <p><?php echo $lang['last_updated']; ?>: <?php echo date('F j, Y H:i:s'); ?></p>
        </div>
    </footer>

    <script>
        // Language handling
        document.querySelectorAll('.language-select a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const lang = this.getAttribute('data-lang');
                const currentUrl = new URL(window.location.href);
                const searchParams = currentUrl.searchParams;
                
                // Add visual feedback before page reload
                document.querySelectorAll('.language-select a, .language-select span').forEach(el => {
                    if (el.getAttribute('data-lang') === lang) {
                        // Create and insert a span element
                        const span = document.createElement('span');
                        span.textContent = el.textContent;
                        span.setAttribute('data-lang', lang);
                        el.parentNode.replaceChild(span, el);
                    } else if (el.tagName === 'SPAN') {
                        // Convert span back to link if it's not the selected language
                        const a = document.createElement('a');
                        a.href = `?lang=${el.getAttribute('data-lang')}`;
                        a.setAttribute('data-lang', el.getAttribute('data-lang'));
                        a.textContent = el.textContent;
                        el.parentNode.replaceChild(a, el);
                    }
                });
                
                // Preserve current search and other parameters
                searchParams.set('lang', lang);
                
                // Add a small delay for the animation to play
                setTimeout(() => {
                    // Preserve the current section in view
                    const currentSection = document.querySelector('section:target');
                    if (currentSection) {
                        window.location.href = currentUrl.toString() + '#' + currentSection.id;
                    } else {
                        window.location.href = currentUrl.toString();
                    }
                }, 300); // Match this with the CSS animation duration
            });
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                targetSection.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Add active class to current section in viewport
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('nav a');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= sectionTop - 60) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').substring(1) === current) {
                    link.classList.add('active');
                }
            });
        });

        // Search functionality
        const searchForm = document.querySelector('.search-form');
        const searchInput = searchForm.querySelector('input[name="search"]');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            const articles = document.querySelectorAll('.news-card');
            const sections = document.querySelectorAll('.category-section');
            
            if (searchTerm === '') {
                // Show all articles and sections if search is empty
                articles.forEach(article => article.style.display = 'block');
                sections.forEach(section => section.style.display = 'block');
                return;
            }
            
            // First, hide all articles
            articles.forEach(article => article.style.display = 'none');
            
            // Then, search through articles
            articles.forEach(article => {
                const title = article.querySelector('h3').textContent.toLowerCase();
                const summary = article.querySelector('.summary').textContent.toLowerCase();
                const topic = article.querySelector('.topic').textContent.toLowerCase();
                const category = article.closest('.category-section').id.toLowerCase();
                
                const isVisible = 
                    title.includes(searchTerm) || 
                    summary.includes(searchTerm) || 
                    topic.includes(searchTerm) || 
                    category.includes(searchTerm);
                
                article.style.display = isVisible ? 'block' : 'none';
            });
            
            // Show/hide sections based on visible articles
            sections.forEach(section => {
                const visibleArticles = section.querySelectorAll('.news-card[style="display: block"]');
                section.style.display = visibleArticles.length > 0 ? 'block' : 'none';
            });
        });

        // Prevent form submission
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
        });
    </script>
</body>
</html> 