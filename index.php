<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
        /* Make iframes responsive */
        iframe {
            width: 100%;
            height: 500px;
            border: none;
            margin-top: 20px;
        }
    </style>
    <title>buyhub.xyz AI Hub</title>
    <style>
.text-left {
  text-align: left; 
}
        /* Ad container styles */
        #adContainer {
            position: absolute;
            width: 520px;
            height: 30px;
            background-color: white;
            overflow: hidden;
            cursor: pointer;
        }

        /* Ad text styles */
        #adText {
            position: absolute;
            width: 100%;
            height: 100%;
            line-height: 30px;
            font-size: 16px;
            text-align: center;
            color: black;
            white-space: nowrap;
        }
 /* Full-width banner styles */
        .ad-container {
            width: 100%;
            height: 77px;
            background-color: white; /* Background color */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer; /* Pointer cursor */
        }

        .ad-text {
            font-size: 24px;
            font-weight: bold;
            color: black; /* Initial text color */
        }

        /* Text blink animation placeholder */
    </style>
</head>
<body>
<h1 style="text-align: center; color: #ADD8E6;">buyhub.xyz crypto prices auto-refresh every 10 minutes</h1>
<h1 style="text-align: center; color: #ADD8E6;">http://buyhub.xyz</h1>
    <!-- ����չʾ��ÿ10�����Զ�ˢ�� -->
    <h2 style="text-align: center; color: #f0f8ff; font-size: 20px; margin-top: 10px;">Major Crypto & CN Gold/Silver Miners (USD/CNY)</h2>
    <iframe
        id="cryptoPriceBoard"
        src="crypto_prices_iframe.php"
        title="Crypto & Gold Stocks Dashboard"
        loading="lazy"
        style="height: 1600px; border: none; width: 100%; max-width: 1100px; display: block; margin: 0 auto 30px; background-color: transparent;">
    </iframe>

    <!-- AI hardware stocks (monthly candlestick, TradingView free feed) -->
    <h2 style="text-align: center; color: #f0f8ff; font-size: 20px; margin-top: 20px;">AI Hardware Stocks (Monthly Candles)</h2>
    <iframe
        id="aiHardwareStocks"
        src="ai_stock_dashboard.html"
        title="AI Hardware Stocks (Monthly)"
        loading="lazy"
        style="height: 560px; border: none; width: 100%; max-width: 1100px; display: block; margin: 10px auto 30px; background-color: transparent;">
    </iframe>
    <h2 style="text-align: center; color: #f0f8ff; font-size: 20px; margin-top: 20px;">Weekly Football & Sports Lottery (Predictions)</h2>
    <iframe
        id="footballBoard"
        src="football/fixtures.php"
        title="Weekly Football & Lottery"
        loading="lazy"
        style="height: 520px; border: none; width: 100%; max-width: 1100px; display: block; margin: 10px auto 30px; background-color: transparent;">
    </iframe>
    <!-- Ad container -->

    <script>
        // Get ad container and text elements
        var adContainer = document.getElementById('adContainer');
        var adText = document.getElementById('adText');

        // Click ad text to navigate
        adText.addEventListener('click', function() {
            window.location.href = 'https://shop.kongfz.com/396112/';
        });

        // Initial position and speed
        var x = 0; // horizontal pos
        var y = 0; // vertical pos
        var speedX = 1; // px per frame (horizontal)
        var speedY = 1; // px per frame (vertical)

        // Per-frame animation
        function animate() {
            // Update position
            x += speedX;
            y += speedY;
            adContainer.style.left = x + 'px';
            adContainer.style.top = y + 'px';

            // Bounce when leaving viewport
            if (x >= window.innerWidth || x <= -adContainer.offsetWidth) {
                speedX = -speedX;
            }
            if (y >= window.innerHeight || y <= -adContainer.offsetHeight) {
                speedY = -speedY;
            }

            // Next frame?
            requestAnimationFrame(animate);
        }

        // Start animation
        animate();
    </script>


    <script>
        // Banner click opens link in new tab
        document.querySelector('.ad-container').addEventListener('click', function() {
            window.open('https://shop.kongfz.com/396112/', '_blank');
        });

        // Placeholder for hover effect
        document.querySelector('.ad-container').addEventListener('mouseover', function() {
        });
    </script>
<?php
date_default_timezone_set("Asia/Shanghai"); 
#$visitor_count = 0;
//$visitor_file = "visitor_count.txt"; // storage for visitor count
/*
// If file exists, read visitor count and IP
if (file_exists($visitor_file)) {
  $visitor_data = file_get_contents($visitor_file);
  $visitor_data_array = explode(",", $visitor_data);
  $visitor_count = intval($visitor_data_array[0]);
  $ip_address = $visitor_data_array[1];
}

$ip_address = $_SERVER['REMOTE_ADDR']; // Client IP address
// Increment visitor counter
$visitor_count++;
$visitor_data = $visitor_count . "," . $ip_address;
file_put_contents($visitor_file, $visitor_data);
**/
$ip_address = $_SERVER['REMOTE_ADDR']; // Client IP address
// // Pre-judge logic
if ($ip_address == '104.225.146.232' || $ip_address == '74.120.171.134') {
    $ip_address = '8.8.8.8';
}
$file = 'visited.txt';
$linecount = 0;
$handle = fopen($file, "r");
while(!feof($handle)){
  $line = fgets($handle);
  $linecount++;
}
fclose($handle);
#echo $linecount;
// Show welcome message
echo "<font size='4' face='����'>www.buyhub.xyz�˹����ܾۺ���վ��ӭ��!!!�����˹����ܿ�ѧ�ҡ�����Ա��prompt scientist����������ʦ���ܼܹ�ʦ�����㷨ʦ���ܹ���ʦ��CTO���о�Ա��ѧʿ����ʿ��Ժʿ�ǣ����Ǻ�! www.buyhub.xyz</font> ";
echo "<br><font size='4' face='Times New Roman'>"; 
echo "Welcome onboard!!Respected AI scientists, programmers, prompt scientists, rocket chief designer, chief architect, chief wizard, chief engineer, CTO, researcher, PHD,mathematicians, </font>";
echo "Your IP :"     . $ip_address;  
echo "<font size='6' face='����' color='Red'> ,you are the " . $linecount . " AI researcher��</font>";

// Flash every 3 minutes

?>
<style>.pp-YU3DBAUHTC7WQ{text-align:center;border:none;border-radius:0.25rem;min-width:11.625rem;padding:0 2rem;height:2.625rem;font-weight:bold;background-color:#FFD140;color:#000000;font-family:"Helvetica Neue",Arial,sans-serif;font-size:1rem;line-height:1.25rem;cursor:pointer;}</style>
<form action="https://www.paypal.com/ncp/payment/YU3DBAUHTC7WQ" method="post" target="_top" style="display:inline-grid;justify-items:center;align-content:start;gap:0.5rem;">
  <input class="pp-YU3DBAUHTC7WQ" type="submit" value="���Ŀ�����������ά��������վ���ڵ����У�" />
  <img src=https://www.paypalobjects.com/images/Debit_Credit_APM.svg alt="cards" />
  <section> Technical support by <img src="https://www.paypalobjects.com/paypal-ui/logos/svg/paypal-wordmark-color.svg" alt="paypal" style="height:0.875rem;vertical-align:middle;"/></section>
</form>

<?php
$portalurls = array(
"https://chatgpt.com",
"https://aistudio.google.com",
"https://grok.com/",
"https://jwt.io/",
"https://www.moyin.com/",
"https://mulmodal.top/",
"https://chat.deepseek.com/",
"https://copilot.microsoft.com/",
"https://gemini.google.com/app",
"https://claude.ai/chats",
"https://www.suno.ai/",
"https://app.keeptrack.space/",
"https://cncases.buyhub.xyz/",
"https://www.buyhub.xyz/queryBooks.php",
"https://sora.com/",
"https://notebooklm.google.com",
"https://colab.research.google.com/drive/1QDp8hPOZCEWGKqG48UrWyPG211z5Xfj6#scrollTo=lC6sS6DnmGmi",
"https://glif.app/@Judi_W/glifs/clxwp56c300022ttqygt0v4o5",
"https://glif.app/@Sheldon-master",
"https://illuminate.withgoogle.com",
"https://www.3dwhere.com/search?k=f117",
"http://122.51.110.176:20586/670bbab2b9",
"https://write.qq.com/portal/dashboard/books",
"https://huitong-tech.feishu.cn/wiki/LS5iwf0A6ixYnykTb9bcfv1xnOh?fromScene=spaceOverview",
"https://www.coze.com/home",
"https://lumalabs.ai/dream-machine",
"https://groq.com/",
"https://www.youtube.com/playables/Ugkxg96n-JiNmJPfquVuY_zjQIMTHmqs7qxu",
"https://www.youtube.com/playables/Ugkxk2s909MfhKr5zKwZUPbZdgwXin8tKptu",
"https://www.youtube.com/playables/UgkxyKs3Ve_RG1PMcTKDbdNtSTCmpKj2kDKj",
"https://www.buyhub.xyz/ai/",
"https://www.buyhub.xyz/LYIT",
"https://www.buyhub.xyz/juhe",
"https://www.buyhub.xyz/gh",
"https://www.buyhub.xyz/fake-screenshot/",
"https://www.buyhub.xyz/gh/ghTrend.php",
"http://mechanics.autos:8080",
"http://mechanics.autos:8080/screenshot-2024072705.png",
"https://twitter.com/search-advanced",
"https://www.aminer.cn/",
"https://www.connectedpapers.com",
"https://www.vosviewer.com/",
"https://www.bing.com/search?q=Bing+AI&showconv=1&FORM=hpcodx",
"https://chat.openai.com/g/g-eB0gYHsdK-ramarujangpt",
"https://app.fireworks.ai/models",
"https://bing.com/create",
"http://122.51.110.176/",
"https://space.bilibili.com/141487901/channel/collectiondetail?sid=1657226",
"https://www.notion.so/",
"http://127.0.0.1:7860/",
"https://github.com/oobabooga/text-generation-webui",
"https://www.youtube.com/watch?v=7pdEK9ckDQ8&ab_channel=AemonAlgiz",
"https://shop.pockyt.io/pc/goodsDetail/vc1aYhc/App%20Store%20&%20iTunes%20USA/all",
"https://spacey.shop.kongfz.com/",
"https://chat.openai.com/g/g-eB0gYHsdK-ramarujangpt",
"https://paypal.me/spaceInfinite?country.x=C2&locale.x=zh_XC",
"https://chrome.google.com/webstore/devconsole/673e7038-9b86-45a3-bd10-bd52bbedec70",
"https://www.buyhub.xyz/stocks/",
"https://github.com/BuilderIO/gpt-crawler",
"https://colab.research.google.com/drive/1e6F-D8AXmp4dUtBmOSIsoaNCFvfwJtVw",
"https://mp.weixin.qq.com/s/92ZGwQA0MSzkEf5k_DEd1g",
"https://mp.weixin.qq.com/s/RuV_4lCQentq4kBr3fv08A",
"https://github.com/microsoft/LoRA",
"https://github.com/shadowsocks/ShadowsocksX-NG",
"https://github.com/lewangdev/ShadowsocksX-NG-GostPlugin?tab=readme-ov-file",
"https://mp.weixin.qq.com/s/NM9Oq3ASR9hqTqhJqpqjgA",
"https://baoyu.io/translations/llm/many-options-for-running-mistral-models-in-your-terminal-using-llm",
"https://twitter.com/xiaohuggg/status/1737683961428717693",
"https://huggingface.co/chat",
"https://huggingface.co/spaces/openskyml/mixtral-46.7b-chat",
"https://replicate.com/kcaverly/dolphin-2.5-mixtral-8x7b-gguf",
"https://catjourney.life/",
"https://colab.research.google.com/github/camenduru/MagicAnimate-colab/blob/main/MagicAnimate_colab.ipynb",
"https://nn.labml.ai/transformers/index.html",
"https://huggingface.co/spaces/TencentARC/PhotoMaker-Style",
"https://github.com/pdf2htmlEX/pdf2htmlEX/releases",
"https://mp.weixin.qq.com/s/2pt29rGV5Mb1GEvapZ8ZwA",
"https://mp.weixin.qq.com/s/q81UMOzgdEWv3QDqRE7x1A",
"https://mp.weixin.qq.com/s/RbLfJpsIeJlmDf4cXyBlUA",
"https://poe.com/"

);

$envurls = array(
"https://annas-archive.org/",
"https://z-library.sk/",
"http://lib.shutong121.com/",
"https://www.the-blueprints.com/",
"https://sci-hub.se/",
"https://github.com/openai/gpt-2",
"https://sci-hub.se/",
"https://github.com/f/awesome-chatgpt-prompts/",
"https://docs.anthropic.com/zh-CN/prompt-library/library",
"https://thepiratebay.org/index.html",
"excel2016site:rutracker.org",
"https://www.wolframalpha.com/",
"https://thehackernews.com/",
"https://www.buyhub.xyz/pdf/Classics-of-Soviet-Mathematics_-L.-S.pdf",
"https://www.buyhub.xyz/pdf/MathforDeepLearningWhatYouNeedtoUnderstandNeuralNetworks.pdf",
"https://www.buyhub.xyz/pdf/PDEjiangping.pdf",
"https://www.buyhub.xyz/pdf/MultipleIntegralsFieldTheoryandSeries.pdf",
"https://www.buyhub.xyz/pdf/PDEjiangping.md",
"https://colab.research.google.com/?utm_source=scs-index"
);
$mathurls = array(
"https://github.com/Ucas-HaoranWei/GOT-OCR2.0/",
"https://github.com/coqui-ai/TTS",
"https://github.com/2noise/ChatTTS",
"https://github.com/openai/whisper",
"https://github.com/3b1b/manim",
"https://www.mathjax.org/#demo",
"https://github.com/breezedeus/Pix2Text",
"https://github.com/hiyouga/LLaMA-Factory",
"https://colab.research.google.com/drive/1DzYRcvOoeYogi2W50awnldFgPLC_-sT-#scrollTo=mbnPkLAOhQ2v",
"https://www.overleaf.com/project/6506f392bbceaea0da3862c9",
"https://matlab.mathworks.com",
"https://snip.mathpix.com",
"https://linearbookscanner.org",
"https://app.copilothub.ai/chat",
"https://app.copilothub.ai/chatbot?id=9353",
"https://github.com/PaddlePaddle/PaddleOCR",
"https://pix2text.readthedocs.io/zh-cn/stable/command/",
"https://www.youtube.com/watch?v=QuE9PcPoK-U&ab_channel=%E5%A4%A7%E9%B1%BC",
"https://colab.research.google.com/gist/jimliu/d2f16ce0c6be9df55972e54ae6b6f5e/pdf_to_markdown_by_nougat.ipynb"
);

$ragweb3urls = array(
"https://coinmarketcap.com",
"https://coinmarketcap.com/api/",
"https://liveuamap.com",
"https://www.understandingwar.org",
"https://deepstatemap.live",
"https://acleddata.com/ukraine-conflict-monitor",
"https://www.bellingcat.com",
"http://quote.eastmoney.com/sz000756.html",
"https://colab.research.google.com/?utm_source=scs-index",
"https://pro.coinmarketcap.com/account",
"https://www.dygod.net/html/gndy/dyzz/20070509/2035.html",
"https://coinmarketcap.com/currencies/dogecoin/",
"https://coinmarketcap.com/currencies/shiba-inu/",
"https://www.coingecko.com/en/coins/gala",
"https://coinmarketcap.com/api/",
"https://unmineable.com/coins/DOGE/address/D8gwrJo8awcUnLPtpgVBL9Lwj4iqJMQpPc",
"https://unmineable.com/coins/ETh/address/0x754EE4ac33809464ea7Ed2Da9A9B032CA035364b",
"https://unmineable.com/coins/GALA/address/0x07BB7552e79A0cADCf4Bb56f6e48A50aa36Fb167",
"https://cn.investing.com/equities/mitsubishi-heavy-industries,-ltd.",
"https://www.binance.com/zh-CN/markets",
"https://www.coinbase.com/"
);

echo "<div id='portal' class='portal-section' style='display: flex; flex-wrap: wrap; background-color: lightgreen''>";

echo "AI portal web sites";
foreach ($portalurls as $url) {
  $website_name = preg_replace('#^https?://#', '', rtrim($url, '/'));
  echo "
  <a href='" . $url . "' target='_blank'>
    <button style='flex: 0 0 calc(20% - 10px); margin: 5px;'>" . $website_name . "</button>
  </a>";
}

echo "</div>";

echo "<div style='display: flex; flex-wrap: wrap; background-color: lightgreen''>";

$html = '<b>AI Book,Paper,Prompt lib,github,sw,ENV,vids</b>';

// Use predefined left-align style? 
echo "<div class='text-left'>$html</div>";
foreach ($envurls as $url) {
  $website_name = preg_replace('#^https?://#', '', rtrim($url, '/'));
  echo "
  <a href='" . $url . "' target='_blank'>
    <button style='flex: 0 0 calc(20% - 10px); margin: 5px;'>" . $website_name . "</button>
  </a>";
}

echo "</div>";

echo "<div style='display: flex; flex-wrap: wrap; background-color: lightgreen''>";

$html = '<b>AI math,STT,TTS,LoRA,RAG,OCR</b>';

// Use predefined left-align style? 
echo "<div class='text-left'>$html</div>";
foreach ($mathurls as $url) {
  $website_name = preg_replace('#^https?://#', '', rtrim($url, '/'));
  echo "
  <a href='" . $url . "' target='_blank'>
    <button style='flex: 0 0 calc(20% - 10px); margin: 5px;'>" . $website_name . "</button>
  </a>";
}

echo "</div>";




echo "<div style='display: flex; flex-wrap: wrap; background-color: lightgreen''>";

$html = '<b> AI crypto research hub</b>';

// Use predefined left-align style? 
echo "<div class='text-left'>$html</div>";
foreach ($ragweb3urls as $url) {
  $website_name = preg_replace('#^https?://#', '', rtrim($url, '/'));
  echo "
  <a href='" . $url . "' target='_blank'>
    <button style='flex: 0 0 calc(20% - 10px); margin: 5px;'>" . $website_name . "</button>
  </a>";
}

echo "</div>";
?>
<div id="time_LA"></div> 
<div id="time_BJ"></div>
<div id="time_MOW"></div>
<script>
setInterval(function(){
  // Current Los Angeles time
  var tz_LA = "America/Los_Angeles";
  var dt_LA = new Date();
  var dt_LA = new Date(dt_LA.toLocaleString("en-US", {timeZone: tz_LA}));
  document.getElementById("time_LA").innerHTML = "Current LA time: " + dt_LA.toISOString().slice(0, 19).replace('T', ' ');
  // Current Shanghai time
  var tz_BJ = "Asia/Shanghai";
  var dt_BJ = new Date();
  var dt_BJ = new Date(dt_BJ.toLocaleString("en-US", {timeZone: tz_BJ}));
  document.getElementById("time_BJ").innerHTML = "Current Shanghai time�?" + dt_BJ.toISOString().slice(0, 19).replace('T', ' ');
  // Current Moscow time?
  var tz_MOW = "Europe/Moscow";
  var dt_MOW = new Date();
  var dt_MOW = new Date(dt_MOW.toLocaleString("en-US", {timeZone: tz_MOW}));
  document.getElementById("time_MOW").innerHTML = "Current Moscow time: " + dt_MOW.toISOString().slice(0, 19).replace('T', ' ');
}, 1000); 
</script>
<?php
// Set file path
$filePath = './books/nucleardatautf8.csv'; // Replace with your file path?

// Set Content-Type header to UTF-8
header("Content-Type: text/html; charset=utf-8");

// Read CSV file
$data = [];
if (($handle = fopen($filePath, "r")) !== FALSE) {
    while (($line = fgetcsv($handle)) !== FALSE) {
        $data[] = mb_convert_encoding($line[0], "UTF-8", "auto"); // Auto convert to UTF-8
    }
    fclose($handle);
}

// Begin output HTML table
echo '<table style="width:100%; text-align:left; border-collapse:collapse;">';
echo '<tr>';

// Define column counter
$colCount = 0;
foreach ($data as $item) {
    echo "<td style='border:1px solid #ddd; padding:8px;'>$item</td>";
    $colCount++;

    // Break line every 3 columns?
    if ($colCount % 3 == 0) {
        echo '</tr><tr>';
    }
}

// Pad empty cells to multiple of 3
while ($colCount % 3 != 0) {
    echo "<td style='border:1px solid #ddd; padding:8px;'></td>";
    $colCount++;
}

echo '</tr>';
echo '</table>';
?>

<?php
echo "Please follow Twitter @CeoSpaceY";
$visited_file = 'visited.txt';

// Read visited.txt content
$visited = file_get_contents($visited_file);
$visited_lines = explode("\n", $visited);
$visited_lines = array_reverse($visited_lines);
$count = 0; 
echo "<div style='background: skyblue'>";
echo "�װ��� AI �о����ǣ������Ѿ���ͬһƵ����������ʵ� 100 λ�������£�\n";
echo "<br>You are welcome to visit and follow my twitter @CeoSpaceY ,if you have any ideas of AI ,plz share it with my twitter,or you c4n contact m3 in email: linlinsd@gmail.com,title must contain AI";

foreach ($visited_lines as $line) {
if ($count ==100)

{
        break;


}
    if ($line) {
        list($ip, $time) = explode(",", $line);
        echo "<br>$ip visited at $time";
    } 
$count++;
}

// Record current visitor IP and timestamp into visited.txt
$ip = $_SERVER['REMOTE_ADDR'];
if ($ip == '104.225.146.232' || $ip == '74.120.171.134') {
    $ip = '8.8.8.8';
}
$time = date('Y-m-d H:i:s');
$new_line = "$ip,$time\n";

file_put_contents($visited_file, $new_line, FILE_APPEND);
echo "</div>"; 
?>




</body>
</html>



























