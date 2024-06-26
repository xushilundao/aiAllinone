<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            updatePrices();
            setInterval(updatePrices, 600000); // 每60秒（1分钟）刷新一次
        });

        function updatePrices() {
            $("#priceFrame").contents().find("#prices").load("get_prices.php");
        }
    </script>
    <title>AI网站一网打尽！</title>
    <style>
.text-left {
  text-align: left; 
}
        /* 设置广告容器的样式 */
        #adContainer {
            position: absolute;
            width: 520px;
            height: 30px;
            background-color: white;
            overflow: hidden;
            cursor: pointer;
        }

        /* 设置广告文本的样式 */
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
 /* 通栏广告样式 */
        .ad-container {
            width: 100%;
            height: 77px;
            background-color: white; /* 修改背景色为金黄色 */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer; /* 设置鼠标样式为手型 */
        }

        .ad-text {
            font-size: 24px;
            font-weight: bold;
            color: black; /* 修改初始颜色为红色 */
        }

        /* 文字闪烁动画 */
    </style>
</head>
<body>
<h1>加密货币价格每小时自动刷新</h1>
    <iframe id="priceFrame" src="prices.html" width="100%" height="70"></iframe>

<iframe src="https://shop.kongfz.com/396112/" width="100%" height="188px"></iframe> 
    <!-- 广告容器 -->

    <script>
        // 获取广告容器和广告文本的 DOM 元素
        var adContainer = document.getElementById('adContainer');
        var adText = document.getElementById('adText');

        // 设置广告文本点击事件，点击时跳转到指定的 URL
        adText.addEventListener('click', function() {
            window.location.href = 'https://shop.kongfz.com/396112/';
        });

        // 设置广告容器的初始位置和速度
        var x = 0; // 初始水平位置
        var y = 0; // 初始垂直位置
        var speedX = 1; // 水平移动速度，单位为像素/帧
        var speedY = 1; // 垂直移动速度，单位为像素/帧

        // 定义每一帧的动画函数
        function animate() {
            // 更新广告容器的位置
            x += speedX;
            y += speedY;
            adContainer.style.left = x + 'px';
            adContainer.style.top = y + 'px';

            // 当广告容器移出屏幕时，将其重新放置到屏幕外，并反向移动
            if (x >= window.innerWidth || x <= -adContainer.offsetWidth) {
                speedX = -speedX;
            }
            if (y >= window.innerHeight || y <= -adContainer.offsetHeight) {
                speedY = -speedY;
            }

            // 在下一帧执行动画函数
            requestAnimationFrame(animate);
        }

        // 开始执行动画
        animate();
    </script>


    <script>
        // 点击通栏广告跳转到指定 URL，并在新标签页打开链接
        document.querySelector('.ad-container').addEventListener('click', function() {
            window.open('https://shop.kongfz.com/396112/', '_blank');
        });

        // 鼠标移到通栏时改变鼠标样式为火箭样式
        document.querySelector('.ad-container').addEventListener('mouseover', function() {
        });
    </script>
<?php
date_default_timezone_set("Asia/Shanghai"); 
#$visitor_count = 0;
#$visitor_file = "visitor_count.txt"; // 存储访问者数量的文件名
/*

// 如果文件存在，则读取访问者数量和 IP 地址
if (file_exists($visitor_file)) {
  $visitor_data = file_get_contents($visitor_file);
  $visitor_data_array = explode(",", $visitor_data);
  $visitor_count = intval($visitor_data_array[0]);
  $ip_address = $visitor_data_array[1];
}

$ip_address = $_SERVER['REMOTE_ADDR']; // 客户端的 IP 地址
// 增加访问者数量
$visitor_count++;
$visitor_data = $visitor_count . "," . $ip_address;
file_put_contents($visitor_file, $visitor_data);
**/
$ip_address = $_SERVER['REMOTE_ADDR']; // 客户端的 IP 地址
// // 预判逻辑
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
// 显示欢迎信息
echo "<font size='4' face='楷体'>尊贵的人工智能科学家,程序员,prompt scientist,火箭总设计师,总架构师,总算法师,总工程师,CTO,研究员,学士,博士,院士们,你们好!</font> ";
echo "<br><font size='4' face='Times New Roman'>"; 
echo "Welcome onboard!!Respected AI scientists, programmers, prompt scientists, rocket chief designer, chief architect, chief wizard, chief engineer, CTO, researcher, PHD,mathematicians, </font>";
echo "Your IP :"     . $ip_address;  
echo "<font size='6' face='楷体' color = 'Red'> ,you are the " . $linecount . " AI researcher。</font>";

// 3分钟闪烁一次

?>

<?php
$portalurls = array(
"https://claude.ai/chats",
"https://chat.openai.com/chat",
"https://copilot.microsoft.com/",
"https://gemini.google.com/app",
"https://ai-sfc.yunyoujun.cn/",
"https://www.suno.ai/",
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
"http://mechanics.autos:8080",
"http://127.0.0.1:7860/",
"https://github.com/oobabooga/text-generation-webui",
"https://www.youtube.com/watch?v=7pdEK9ckDQ8&ab_channel=AemonAlgiz",
"https://shop.pockyt.io/pc/goodsDetail/vc1aYhc/App%20Store%20&%20iTunes%20USA/all",
"https://chat.openai.com/g/g-eB0gYHsdK-ramarujangpt",
"https://book.kongfz.com/396112",
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
"https://mp.weixin.qq.com/s?__biz=MzkyNzU0MzQwOQ==&mid=2247483799&idx=1&sn=aacf1b61837f2129136cdbcd0005971c&chksm=c318c4ba7ffd2841d7101787a882130021410c98fe2c90f70d6a3859021cf3e50e896477e2d3&scene=132&exptype=timeline_recommend_article_extendread_samebiz&show_related_article=1&subscene=0&scene=132#wechat_redirect",
"https://poe.com/"

);

$envurls = array(
"https://drive.google.com/drive/quota",
"https://osanseviero.github.io/hackerllama/blog/posts/random_transformer/",
"https://github.com/openai/gpt-2",
"https://www.onlineocr.net/",
"https://sci-hub.se/",
"https://libgen.is/",
"https://thepiratebay.org/index.html",
"excel2016site:rutracker.org",
"http://124.42.12.105:54327/",
"https://platform.openai.com/docs",
"https://www.wolframalpha.com/",
"https://modelscope.cn/studios/baichuan-inc/baichuan-7B-demo/",
"https://jeff.circleo.me/",
"https://huggingface.co/spaces/stabilityai/stable-diffusion",
"https://thehackernews.com/",
"https://drive.google.com/file/d/1VW7sxqMF_1egTDwUFEXJ8kicmsyaZyZB/view",
"https://www.buyhub.xyz/pdf/MathforDeepLearningWhatYouNeedtoUnderstandNeuralNetworks.pdf",
"https://vitomag.com/science/cgljwv",
"https://www.buyhub.xyz/pdf/DemidovichProblemsinmathematicalanalysis.pdf",
"https://github.com/ginuerzh/gost",
"https://github.com/JushBJJ/Mr.-Ranedeer-AI-Tutor",
"https://github.com/camenduru/text-generation-webui-colab",
"https://colab.research.google.com/github/camenduru/text-generation-webui-colab/blob/main/vicuna-13b-GPTQ-4bit-128g.ipynb",
'https://arxiv.org/pdf/1706.03762.pdf',
"https://arxiv.org/pdf/2305.15408.pdf",
"/https://arxiv.org/pdf/2305.14314.pdf",
"https://github.com/exacity/deeplearningbook-chinese",
"https://github.com/huggingface/transformers/blob/main/README_zh-hans.md",
"https://github.com/THUDM/ChatGLM-6B",
"https://github.com/artidoro/qlora",
"https://www.youtube.com/watch?v=Us5ZFp16PaU&ab_channel=SamWitteveen",
"https://github.com/ggerganov/llama.cpp",
"https://github.com/ymcui/Chinese-LLaMA-Alpaca-2/wiki/text-generation-webui_zh",
"https://twitter.com/Tim_Dettmers/status/1661379354507476994",
"https://cloud.tencent.com/developer/article/2280193?areaSource=106005.17",
"https://learn.deeplearning.ai/chatgpt-prompt-eng/lesson/2/guidelines",
"https://app.copilothub.ai/",
"https://discord.com/channels/662267976984297473/997267848118403092",
"https://www.mathjax.org/#demo",
"https://workbench.cloud.tencent.com/rdp?region=na-siliconvalley&instanceId=lhins-3g1ad311&source=lighthouse",
"https://snip.mathpix.com/",
"https://github.com/rangaeeeee/books-mir-mathematics/tree/master",
"https://www.chatpdf.com/",
"http://lib.shutong121.com/",
"https://github.com/f/awesome-chatgpt-prompts/",
"https://rargb.to/",
"https://www.onlinedoctranslator.com/en/translationform",
"https://matlab.mathworks.com/",
"https://www.youtube.com/watch?v=s4jtkzHhLzY&t=256s",
"https://ap.www.namecheap.com/",
"https://sci-hub.se/",
"https://zh.zlibrary-global.se/",
"https://zlibrary.to/",
"https://leetcode.com/",
"https://colab.research.google.com/?utm_source=scs-index"
);
$mathurls = array(
"https://www.mathjax.org/#demo",
"https://www.overleaf.com/project/6506f392bbceaea0da3862c9",
"https://matlab.mathworks.com",
"https://snip.mathpix.com",
"https://linearbookscanner.org",
"https://app.copilothub.ai/chat",
"https://app.copilothub.ai/chatbot?id=9353",
"https://github.com/PaddlePaddle/PaddleOCR",
"https://www.youtube.com/watch?v=QuE9PcPoK-U&ab_channel=%E5%A4%A7%E9%B1%BC",
"https://colab.research.google.com/gist/jimliu/d2f16ce0c6be9df55972e54ae6b6f5e/pdf_to_markdown_by_nougat.ipynb"
);

$web3urls = array(
"https://defiprime.com/exchanges",
"https://www.coingecko.com/en/developers/dashboard",
"https://coinmarketcap.com/api/",
"http://quote.eastmoney.com/sz000756.html",
"https://translate.google.com/?sl=en&tl=zh-CN&op=docs",
"http://quote.eastmoney.com/sz002603.html",
"https://leetcode.com/",
"https://colab.research.google.com/?utm_source=scs-index",
"https://pro.coinmarketcap.com/account",
"https://www.bilibili.com/video/BV1Ae4y1D7BU/?vd_source=4def9883c7a9cfc2c5071bbb43f7686d",
"https://www.dygod.net/html/gndy/dyzz/20070509/2035.html",
"https://breached.to/Thread-Selling-2022-SHGA-Shanghai-Gov-National-Police-database?page=21&highlight=shanghai",
"https://coinmarketcap.com/currencies/dogecoin/",
"https://coinmarketcap.com/currencies/shiba-inu/",
"https://www.coingecko.com/en/coins/gala",
"https://coinmarketcap.com/api/",
"https://coinmarketcap.com/api/documentation/v1/",
"https://unmineable.com/coins/DOGE/address/D8gwrJo8awcUnLPtpgVBL9Lwj4iqJMQpPc",
"https://unmineable.com/coins/ETh/address/0x754EE4ac33809464ea7Ed2Da9A9B032CA035364b",
"https://unmineable.com/coins/GALA/address/0x07BB7552e79A0cADCf4Bb56f6e48A50aa36Fb167",
"https://finance.sina.com.cn/money/forex/hq/BTCETHUSD.shtml",
"https://cn.investing.com/equities/mitsubishi-heavy-industries,-ltd.",
"https://i.finance.sina.com.cn/zixuan,all?sudaref=finance.sina.com.cn&display=0&retcode=0",
"https://mail.qq.com/",
"https://mail.google.com/mail/u/0/#inbox",
"https://www.youtube.com/",
"https://www.bilibili.com/",
"https://www.linkedin.com/feed/",
"https://twitter.com/home",
"https://www.binance.com/zh-CN/markets",
"https://www.google.com/search?q=Coinbase&oq=co&aqs=chrome.0.69i59j69i57j69i60l4j69i65j69i60.692j0j15&sourceid=chrome&ie=UTF-8",
"https://www.coinbase.com/",
"https://www.zhihu.com//",
"https://www.ixigua.com/home/554626371819964?list_entrance=homepage",
"http://www.buyhub.xyz/forum",
"https://buyhub.xyz/wordpress"
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

$html = '<b>AI math,OCR</b>';

// 使用预定义的左对齐样式  
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

$html = '<b>AI ENV,Book,Paper,github,sw,vids</b>';

// 使用预定义的左对齐样式  
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

$html = '<b>web3 crypto coin etc web sites</b>';

// 使用预定义的左对齐样式  
echo "<div class='text-left'>$html</div>";
foreach ($web3urls as $url) {
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
  // 当前美国加州时间
  var tz_LA = "America/Los_Angeles";
  var dt_LA = new Date();
  var dt_LA = new Date(dt_LA.toLocaleString("en-US", {timeZone: tz_LA}));
  document.getElementById("time_LA").innerHTML = "当前加州时间是 " + dt_LA.toISOString().slice(0, 19).replace('T', ' ');
  // 当前上海时间
  var tz_BJ = "Asia/Shanghai";
  var dt_BJ = new Date();
  var dt_BJ = new Date(dt_BJ.toLocaleString("en-US", {timeZone: tz_BJ}));
  document.getElementById("time_BJ").innerHTML = "当前上海时间是 " + dt_BJ.toISOString().slice(0, 19).replace('T', ' ');
  // 当前莫斯科时间
  var tz_MOW = "Europe/Moscow";
  var dt_MOW = new Date();
  var dt_MOW = new Date(dt_MOW.toLocaleString("en-US", {timeZone: tz_MOW}));
  document.getElementById("time_MOW").innerHTML = "当前莫斯科时间是 " + dt_MOW.toISOString().slice(0, 19).replace('T', ' ');
}, 1000); 
</script>
<?php
echo "请关注推特账号@CeoSpaceY";
$visited_file = 'visited.txt';

// 读取visited.txt文件内容
$visited = file_get_contents($visited_file);
$visited_lines = explode("\n", $visited);
$visited_lines = array_reverse($visited_lines);
$count = 0; 
echo "<div style='background: skyblue'>";
echo "尊贵的AI研究者们,现在我们已经是同志了!最新访问的100位朋友访问了本网站!\n";
echo "<br>You are welcome to visit and follow my twitter @CeoSpaceY ,if you have any ideas of AI ,plz share it with my twitter,or you c4n contact m3 in email: linlinsd@gmail.com,title must contain AI";

foreach ($visited_lines as $line) {
if ($count ==100)

{
        break;


}
    if ($line) {
        list($ip, $time) = explode(",", $line);
        echo "<br>$ip 在 $time 访问过";
    } 
$count++;
}

// 获取当前访问者IP和时间,并写入visited.txt文件
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
