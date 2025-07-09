<?php
// ##########################################################################
// #########      CodeMarket Scraper v2.0 - Language Switcher       #########
// ##########################################################################

$translations = [
    'en' => [
        'direction' => 'ltr',
        'title' => 'Code Market - Website Downloader',
        'main_header' => 'Code Market - Website Downloader',
        'url_placeholder' => 'https://example.com',
        'button_text' => 'Download Site',
        'checkbox_text' => 'Download files from external domains (for fonts, CDNs)',
        'invalid_url' => 'The entered URL is not valid.',
        'log_header' => 'Live Log',
        'scraper_started' => 'Scraper Started for: :url',
        'saving_to' => 'Saving files to: :dir',
        'fetch_external_enabled' => 'Fetch External Domains: Enabled',
        'fetch_external_disabled' => 'Fetch External Domains: Disabled',
        'processing' => 'Processing (:count/:total): :url',
        'processing_css' => '-> Processing CSS file...',
        'saved' => '-> Saved: :file',
        'failed' => '-> Failed (Code: :code)',
        'finished' => 'Crawling finished!',
        'total_processed' => 'Total URLs processed: :count',
        'duration' => 'Duration: :seconds seconds',
        'folder_location' => 'Website saved in folder: :dir'
    ],
    'de' => [
        'direction' => 'ltr',
        'title' => 'Code Market - Website-Downloader',
        'main_header' => 'Code Market - Website-Downloader',
        'url_placeholder' => 'https://beispiel.de',
        'button_text' => 'Seite herunterladen',
        'checkbox_text' => 'Dateien von externen Domains herunterladen (für Schriftarten, CDNs)',
        'invalid_url' => 'Die eingegebene URL ist ungültig.',
        'log_header' => 'Echtzeit-Protokoll',
        'scraper_started' => 'Scraper gestartet für: :url',
        'saving_to' => 'Speichere Dateien in: :dir',
        'fetch_external_enabled' => 'Externe Domains abrufen: Aktiviert',
        'fetch_external_disabled' => 'Externe Domains abrufen: Deaktiviert',
        'processing' => 'Verarbeite (:count/:total): :url',
        'processing_css' => '-> Verarbeite CSS-Datei...',
        'saved' => '-> Gespeichert: :file',
        'failed' => '-> Fehlgeschlagen (Code: :code)',
        'finished' => 'Crawling abgeschlossen!',
        'total_processed' => 'Insgesamt verarbeitete URLs: :count',
        'duration' => 'Dauer: :seconds Sekunden',
        'folder_location' => 'Website gespeichert im Ordner: :dir'
    ],
    'fa' => [
        'direction' => 'rtl',
        'title' => 'کد مارکت - دانلودر وب‌سایت',
        'main_header' => 'کد مارکت - دانلودر وب‌سایت',
        'url_placeholder' => 'https://example.com',
        'button_text' => 'دانلود سایت',
        'checkbox_text' => 'دانلود فایل‌ها از دامنه‌های خارجی (مهم برای فونت‌ها و CDN ها)',
        'invalid_url' => 'آدرس URL وارد شده معتبر نیست.',
        'log_header' => 'گزارش زنده',
        'scraper_started' => 'اسکریپر برای آدرس زیر شروع به کار کرد: :url',
        'saving_to' => 'ذخیره فایل‌ها در پوشه: :dir',
        'fetch_external_enabled' => 'دانلود از دامنه‌های خارجی: فعال',
        'fetch_external_disabled' => 'دانلود از دامنه‌های خارجی: غیرفعال',
        'processing' => 'در حال پردازش (:count/:total): :url',
        'processing_css' => '-> در حال پردازش فایل CSS...',
        'saved' => '-> ذخیره شد: :file',
        'failed' => '-> شکست خورد (کد خطا: :code)',
        'finished' => 'دانلود کامل شد!',
        'total_processed' => 'تعداد کل آدرس‌های پردازش شده: :count',
        'duration' => 'مدت زمان: :seconds ثانیه',
        'folder_location' => 'وب‌سایت در پوشه زیر ذخیره شد: :dir'
    ]
];
$lang_names = ['en' => 'English', 'de' => 'Deutsch', 'fa' => 'فارسی'];
$default_lang = 'en';
$available_langs = ['en', 'de', 'fa'];
$lang_code = $default_lang;
if (isset($_GET['lang']) && in_array($_GET['lang'], $available_langs)) {
    $lang_code = $_GET['lang'];
} elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $browser_langs = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    foreach ($browser_langs as $browser_lang) {
        $browser_lang_code = substr(trim($browser_lang), 0, 2);
        if (in_array($browser_lang_code, $available_langs)) {
            $lang_code = $browser_lang_code;
            break;
        }
    }
}
$lang = $translations[$lang_code];
$direction = $lang['direction'];

class CodeMarketEngine {
private $baseHost, $fetchExternalDomains, $urls_to_visit, $visited_urls, $queued_urls_map, $localDirectory, $lang;
public function __construct($lang_array)
{
    $this->lang = $lang_array;
}
private function fetchContent($url)
{
    $ch = curl_init();
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36';
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_ENCODING, '');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $content = curl_exec($ch);
    $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return ['content' => $content, 'contentType' => $contentType, 'httpCode' => $httpCode];
}
private function buildAbsoluteUrl($base, $relative)
{
    $relative = trim($relative);
    if (empty($relative) || str_starts_with($relative, '#') || str_starts_with($relative, 'mailto:') || str_starts_with($relative, 'tel:') || str_starts_with($relative, 'javascript:') || str_starts_with($relative, 'data:')) {
        return null;
    }
    if (str_starts_with($relative, '//')) {
        return parse_url($base, PHP_URL_SCHEME) . ':' . $relative;
    }
    if (parse_url($relative, PHP_URL_SCHEME) !== null) {
        return $relative;
    }
    $baseParts = parse_url($base);
    $path = $baseParts['path'] ?? '/';
    if (substr($path, -1) != '/') {
        $path = dirname($path) . '/';
    }
    $fullPath = str_starts_with($relative, '/') ? $relative : $path . $relative;
    $re = ['#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#'];
    for ($n = 1; $n > 0; $fullPath = preg_replace($re, '/', $fullPath, -1, $n)) ;
    return ($baseParts['scheme'] ?? 'http') . '://' . ($baseParts['host'] ?? '') . $fullPath;
}
private function getRelativePath($from, $to)
{
    $fromParts = explode('/', ($from === '.' || $from === '') ? '' : rtrim(dirname($from), '/'));
    $toParts = explode('/', rtrim($to, '/'));
    if (empty($fromParts) || $fromParts[0] === '') array_shift($fromParts);
    $from_copy = $fromParts;
    foreach ($fromParts as $depth => $dir) {
        if (isset($toParts[$depth]) && $dir === $toParts[$depth]) {
            array_shift($from_copy);
            array_shift($toParts);
        } else {
            break;
        }
    }
    return str_repeat('../', count($from_copy)) . implode('/', $toParts);
}
private function logMessage($message_key, $replacements = [])
{
    $message = $this->lang[$message_key] ?? $message_key;
    foreach ($replacements as $key => $value) {
        $message = str_replace($key, $value, $message);
    }
    echo "<code>" . htmlspecialchars(date('[H:i:s] ') . $message) . "</code><br>";
    if (ob_get_level() > 0) ob_flush();
    flush();
    usleep(10000);
}
private function parseAndRewriteCss($cssContent, $cssUrl)
{
    $cssUrlPath = ltrim(parse_url($cssUrl, PHP_URL_PATH), '/');
    if (parse_url($cssUrl, PHP_URL_HOST) != $this->baseHost) {
        $cssUrlPath = '--external--/' . parse_url($cssUrl, PHP_URL_HOST) . '/' . $cssUrlPath;
    }
    $pattern_import = '/@import\s+(?:url\()?[\'"]?(.*?)[\'"]?\)?;/i';
    $cssContent = preg_replace_callback($pattern_import, function ($matches) use ($cssUrl, $cssUrlPath) {
        $originalUrl = $matches[1];
        $absoluteUrl = $this->buildAbsoluteUrl($cssUrl, $originalUrl);
        $urlHost = parse_url($absoluteUrl, PHP_URL_HOST);
        if ($absoluteUrl && ($urlHost == $this->baseHost || $this->fetchExternalDomains)) {
            if (!in_array($absoluteUrl, $this->visited_urls) && !isset($this->queued_urls_map[$absoluteUrl])) {
                $this->urls_to_visit->enqueue($absoluteUrl);
                $this->queued_urls_map[$absoluteUrl] = true;
            }
            $linkedPath = ($urlHost != $this->baseHost) ? '--external--/' . $urlHost . '/' . ltrim(parse_url($absoluteUrl, PHP_URL_PATH), '/') : ltrim(parse_url($absoluteUrl, PHP_URL_PATH), '/');
            $newRelativePath = $this->getRelativePath($cssUrlPath, $linkedPath);
            return '@import url("' . $newRelativePath . '");';
        }
        return $matches[0];
    }, $cssContent);
    $pattern_url = '/url\s*\(\s*([\'"]?)(.*?)\1\s*\)/i';
    $cssContent = preg_replace_callback($pattern_url, function ($matches) use ($cssUrl, $cssUrlPath) {
        $originalUrl = $matches[2];
        $absoluteUrl = $this->buildAbsoluteUrl($cssUrl, $originalUrl);
        $urlHost = parse_url($absoluteUrl, PHP_URL_HOST);
        if ($absoluteUrl && ($urlHost == $this->baseHost || $this->fetchExternalDomains)) {
            if (!in_array($absoluteUrl, $this->visited_urls) && !isset($this->queued_urls_map[$absoluteUrl])) {
                $this->urls_to_visit->enqueue($absoluteUrl);
                $this->queued_urls_map[$absoluteUrl] = true;
            }
            $linkedPath = ($urlHost != $this->baseHost) ? '--external--/' . $urlHost . '/' . ltrim(parse_url($absoluteUrl, PHP_URL_PATH), '/') : ltrim(parse_url($absoluteUrl, PHP_URL_PATH), '/');
            $newRelativePath = $this->getRelativePath($cssUrlPath, $linkedPath);
            return 'url("' . $newRelativePath . '")';
        }
        return $matches[0];
    }, $cssContent);
    return $cssContent;
}
private function saveAndProcessFile($url, $content, $contentType)
{
    $urlParts = parse_url($url);
    $urlHost = $urlParts['host'];
    $urlPath = ltrim($urlParts['path'], '/');
    if (empty($urlPath) || substr($urlPath, -1) === '/') {
        $urlPath .= 'index.html';
    }
    $localPathPrefix = $this->localDirectory;
    if ($urlHost != $this->baseHost) {
        $localPathPrefix .= '/--external--/' . $urlHost;
    }
    $localPath = $localPathPrefix . '/' . $urlPath;
    if (!file_exists(dirname($localPath))) {
        mkdir(dirname($localPath), 0755, true);
    }
    $currentFileRelativePath = str_replace($this->localDirectory . '/', '', $localPath);
    $isCss = (strpos($contentType, 'text/css') !== false) || (substr($urlPath, -4) === '.css');
    if ($isCss && !empty($content)) {
        $this->logMessage('processing_css');
        $content = $this->parseAndRewriteCss($content, $url);
    } elseif (strpos($contentType, 'text/html') !== false && !empty($content)) {
        $dom = new DOMDocument();
        @$dom->loadHTML($content);
        $xpath = new DOMXPath($dom);
        $tags = ['a' => ['href'], 'link' => ['href'], 'script' => ['src'], 'img' => ['src', 'srcset'], 'source' => ['src', 'srcset']];
        foreach ($tags as $tag => $attrs) {
            foreach ($attrs as $attr) {
                foreach ($xpath->query("//{$tag}[@{$attr}]") as $node) {
                    $originalAttrValue = $node->getAttribute($attr);
                    $newAttrValue = $originalAttrValue;
                    if ($attr === 'srcset') {
                        $sources = explode(',', $originalAttrValue);
                        $newSources = [];
                        foreach ($sources as $source) {
                            $parts = preg_split('/\s+/', trim($source));
                            $urlPart = $parts[0];
                            if (empty($urlPart)) continue;
                            $descPart = isset($parts[1]) ? ' ' . $parts[1] : '';
                            $absoluteLink = $this->buildAbsoluteUrl($url, $urlPart);
                            $linkHost = parse_url($absoluteLink, PHP_URL_HOST);
                            if ($absoluteLink && ($linkHost == $this->baseHost || $this->fetchExternalDomains)) {
                                if (!in_array($absoluteLink, $this->visited_urls) && !isset($this->queued_urls_map[$absoluteLink])) {
                                    $this->urls_to_visit->enqueue($absoluteLink);
                                    $this->queued_urls_map[$absoluteLink] = true;
                                }
                                $linkedPath = ($linkHost != $this->baseHost) ? '--external--/' . $linkHost . '/' . ltrim(parse_url($absoluteLink, PHP_URL_PATH), '/') : ltrim(parse_url($absoluteLink, PHP_URL_PATH), '/');
                                $newSources[] = $this->getRelativePath($currentFileRelativePath, $linkedPath) . $descPart;
                            } else {
                                $newSources[] = $source;
                            }
                        }
                        $newAttrValue = implode(', ', $newSources);
                    } else {
                        $absoluteLink = $this->buildAbsoluteUrl($url, $originalAttrValue);
                        $linkHost = parse_url($absoluteLink, PHP_URL_HOST);
                        if ($absoluteLink && ($linkHost == $this->baseHost || $this->fetchExternalDomains)) {
                            if (!in_array($absoluteLink, $this->visited_urls) && !isset($this->queued_urls_map[$absoluteLink])) {
                                $this->urls_to_visit->enqueue($absoluteLink);
                                $this->queued_urls_map[$absoluteLink] = true;
                            }
                            $linkedPath = ($linkHost != $this->baseHost) ? '--external--/' . $linkHost . '/' . ltrim(parse_url($absoluteLink, PHP_URL_PATH), '/') : ltrim(parse_url($absoluteLink, PHP_URL_PATH), '/');
                            $newAttrValue = $this->getRelativePath($currentFileRelativePath, $linkedPath);
                        }
                    }
                    $node->setAttribute($attr, $newAttrValue);
                }
            }
        }
        foreach ($xpath->query("//*[@style]") as $node) {
            $style = $node->getAttribute('style');
            $newStyle = $this->parseAndRewriteCss($style, $url);
            $node->setAttribute('style', $newStyle);
        }
        $content = $dom->saveHTML();
    }
    file_put_contents($localPath, $content);
    $this->logMessage('saved', [':file' => str_replace($this->localDirectory . '/', '', $localPath)]);
}
public function startScraping($baseUrl, $fetchExternal) {
$this->fetchExternalDomains = $fetchExternal;
$this->localDirectory = 'website_mirror_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '', parse_url($baseUrl, PHP_URL_HOST)); ?>
<div class="log-box">
    <div class="log-header"><?php echo $this->lang['log_header']; ?></div>
    <div class="log-content"> <?php ini_set('memory_limit', '2048M');
        libxml_use_internal_errors(true);
        $this->urls_to_visit = new SplQueue();
        $this->urls_to_visit->enqueue($baseUrl);
        $this->visited_urls = [];
        $this->queued_urls_map = [$baseUrl => true];
        $this->baseHost = parse_url($baseUrl, PHP_URL_HOST);
        $startTime = microtime(true);
        if (!file_exists($this->localDirectory)) {
            mkdir($this->localDirectory, 0755, true);
        }
        $this->logMessage('scraper_started', [':url' => $baseUrl]);
        $this->logMessage('saving_to', [':dir' => "'" . $this->localDirectory . "'"]);
        $this->logMessage($fetchExternal ? 'fetch_external_enabled' : 'fetch_external_disabled');
        $this->logMessage('-----------------------------------------');
        while (!$this->urls_to_visit->isEmpty()) {
            $currentUrl = $this->urls_to_visit->dequeue();
            if (in_array($currentUrl, $this->visited_urls)) continue;
            $this->visited_urls[] = $currentUrl;
            $this->logMessage('processing', [':count' => count($this->visited_urls), ':total' => (count($this->visited_urls) + count($this->urls_to_visit)), ':url' => $currentUrl]);
            $data = $this->fetchContent($currentUrl);
            if ($data['httpCode'] == 200) {
                $this->saveAndProcessFile($currentUrl, $data['content'], $data['contentType']);
            } else {
                $this->logMessage('failed', [':code' => $data['httpCode']]);
            }
        }
        $endTime = microtime(true);
        $duration = round($endTime - $startTime, 2);
        $this->logMessage("-----------------------------------------");
        $this->logMessage('finished');
        $this->logMessage('total_processed', [':count' => count($this->visited_urls)]);
        $this->logMessage('duration', [':seconds' => $duration]);
        $this->logMessage('folder_location', [':dir' => "'" . $this->localDirectory . "'"]);
        echo '</div></div>';
        }
        }

        set_time_limit(0);
        $app = new CodeMarketEngine($lang);
        ?>
        <!DOCTYPE html>
        <html lang="<?php echo $lang_code; ?>" dir="<?php echo $direction; ?>">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $lang['title']; ?></title>
            <style>
                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                    background-color: #f8f9fa;
                    color: #212529;
                    line-height: 1.6;
                    margin: 0;
                    padding: 20px;
                }

                html[dir="rtl"] body {
                    font-family: "Vazirmatn", sans-serif;
                }

                .container {
                    max-width: 800px;
                    margin: 40px auto;
                    padding: 20px 30px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 4px_8px rgba(0, 0, 0, 0.1);
                }

                .header-flex {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }

                h1 {
                    text-align: center;
                    color: #0d6efd;
                    margin: 0;
                    flex-grow: 1;
                }

                .lang-switcher {
                    font-size: 14px;
                }

                .lang-switcher a {
                    text-decoration: none;
                    color: #6c757d;
                    margin: 0 5px;
                }

                .lang-switcher a.active {
                    color: #0d6efd;
                    font-weight: bold;
                }

                form {
                    display: flex;
                    flex-direction: column;
                    gap: 15px;
                    margin-bottom: 20px;
                }

                .input-group {
                    display: flex;
                    gap: 10px;
                }

                input[type="url"] {
                    flex-grow: 1;
                    padding: 10px;
                    border: 1px solid #ced4da;
                    border-radius: 4px;
                    font-size: 16px;
                    direction: ltr;
                    text-align: left;
                }

                button {
                    padding: 10px 20px;
                    background-color: #0d6efd;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    font-size: 16px;
                    cursor: pointer;
                    transition: background-color 0.2s;
                }

                button:hover {
                    background-color: #0b5ed7;
                }

                .checkbox-group {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 14px;
                    color: #495057;
                }

                .log-box {
                    border: 1px solid #dee2e6;
                    border-radius: 8px;
                    margin-top: 20px;
                    background-color: #212529;
                    color: #f8f9fa;
                }

                .log-header {
                    padding: 10px 15px;
                    background-color: #343a40;
                    border-bottom: 1px solid #495057;
                    font-weight: bold;
                    border-top-left-radius: 7px;
                    border-top-right-radius: 7px;
                }

                .log-content {
                    padding: 15px;
                    height: 400px;
                    overflow-y: auto;
                    font-family: "SF Mono", "Fira Code", "Fira Mono", "Roboto Mono", monospace;
                    font-size: 14px;
                    text-align: left;
                    direction: ltr;
                }

                .log-content code {
                    color: #20c997;
                }
            </style>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap" rel="stylesheet">
        </head>
        <body>
        <div class="container">
            <div class="header-flex">
                <h1><?php echo $lang['main_header']; ?></h1>
                <div class="lang-switcher">
                    <?php
                    foreach ($lang_names as $code => $name) {
                        $class = ($code === $lang_code) ? 'active' : '';
                        echo "<a href=\"?lang={$code}\" class=\"{$class}\">{$name}</a>";
                    }
                    ?>
                </div>
            </div>

            <form method="POST" action="?lang=<?php echo $lang_code; ?>">
                <div class="input-group">
                    <input type="url" name="baseUrl" placeholder="<?php echo $lang['url_placeholder']; ?>" required
                           value="<?php echo isset($_POST['baseUrl']) ? htmlspecialchars($_POST['baseUrl']) : ''; ?>">
                    <button type="submit"><?php echo $lang['button_text']; ?></button>
                </div>
                <div class="checkbox-group">
                    <input type="checkbox" name="fetchExternal" id="fetchExternal"
                           value="1" <?php echo !isset($_POST['baseUrl']) || isset($_POST['fetchExternal']) ? 'checked' : ''; ?>>
                    <label for="fetchExternal"><?php echo $lang['checkbox_text']; ?></label>
                </div>
            </form>

            <?php
            if ($app !== null && $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['baseUrl'])) {
                $baseUrl = filter_var($_POST['baseUrl'], FILTER_SANITIZE_URL);
                $fetchExternal = isset($_POST['fetchExternal']);

                if (filter_var($baseUrl, FILTER_VALIDATE_URL)) {
                    $app->startScraping($baseUrl, $fetchExternal);
                } else {
                    echo '<p style="color: red; text-align: center;">' . $lang['invalid_url'] . '</p>';
                }
            }
            ?>
        </div>
        </body>
        </html>