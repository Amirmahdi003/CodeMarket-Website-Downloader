
<h1>Code Market - Website Downloader</h1>

###

<h3>🚀 Code Market - Website Downloader</h3>
<p>
  A powerful PHP script for downloading and mirroring a complete website for offline Browse. This tool recursively follows all links to create a complete local copy of a website's structure, files, styles, and scripts, rewriting internal links to ensure seamless offline navigation. It features a web-based UI, live logging, and advanced capabilities for handling external resources.
</p>

##

<h3>🎯 Features</h3>
<ul>
  <li> Advanced Crawling Engine:
    <ul>
      <li>Full website download (HTML, CSS, JS, images, etc.).</li>
      <li>Recursive crawling to cover all pages.</li>
      <li>Intelligent CSS parsing to find fonts (@font-face), background images (url(...)), and other imported files (@import).</li>
      <li>Responsive image support (srcset).</li>
      <li>Perfect reconstruction of the original site's folder structure.</li>
      <li>Smart link rewriting for offline functionality.</li>
      <li>Ability to download from CDNs and external domains.</li>
      <li>Browser simulation to bypass simple anti-bot systems.</li>
    </ul>
  </li>

  <li>User Interface (UI):
    <ul>
      <li>A full web-based graphical user interface.</li>
      <li>Real-time, line-by-line logging of all operations.</li>
      <li>Simple input form and easy control over options.</li>
    </ul>
  </li>

  <li>Internationalization:
    <ul>
      <li>Full support for English, German, and Persian.</li>
      <li>Automatic language detection based on browser settings.</li>
      <li>Manual language switcher for user control.</li>
      <li>Support for both RTL and LTR layouts.</li>
    </ul>
  </li>
</ul>

##

<h3>💻 Tech Stack</h3>
<ul>
  <li>PHP: The core programming language.</li>
  <li>cURL: For sending HTTP requests and fetching web content.</li>
  <li>DOMDocument & DOMXPath: For parsing the HTML document structure.</li>
  <li>HTML5 & CSS3: For the web-based user interface.</li>
</ul>

##

<h3>⚙️ Setup and Usage</h3>
<p>
1.  Prerequisites: You need a local web server environment like XAMPP, WAMP, or Laragon.<br>
2.  Download: Download or clone this repository.<br>
3.  Copy File: Place the script file (e.g., index.php) into your web server's root directory (e.g., htdocs for XAMPP).<br>
4.  Run: Open your browser and navigate to http://localhost/index.php.<br>
5.  Usage: Enter the target website's full URL, configure the options, and click the "Download Site" button.
</p>

##

<h3>⚠️ Limitations</h3>
<p>
This script cannot execute JavaScript. As a result, it cannot download websites that use advanced anti-bot protections (like Cloudflare) which require solving a JavaScript challenge. For such sites, Headless Browser tools like Selenium or Puppeteer must be used.
</p>

##

<h3>🤝 Contributing</h3>
<p>Your participation in this project is welcome. You can send a message to my Telegram to improve the code</p>
<div>
  <a href="https://t.me/amirmahdi_evan" target="_blank">
    <img src="https://raw.githubusercontent.com/maurodesouza/profile-readme-generator/master/src/assets/icons/social/telegram/default.svg" width="52" height="40" alt="telegram logo"  />
  </a>
</div>

##

<h3>📄 License</h3>
<p>This project is licensed under the MIT License.</p>

##

<h3>Language</h3>
<div align="center">
  
[![en](https://img.shields.io/badge/Lang-English-blue.svg)](README.md)
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
[![fa](https://img.shields.io/badge/Lang-Persian-green.svg)](README_FA.md)
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
[![de](https://img.shields.io/badge/Lang-Deutsch-yellow.svg)](README_DE.md)

</div>
