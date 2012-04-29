<?php
///////////////////////////////////////////////////////////////////////////////
//
// 张树林 - 慧佳工作室
//
// Module Name:     index.php
// Abstract:        从其他网站捕获数据-PHP写的小型爬虫程序
// Version:         1.0
// Date                                2005-06-11
// Author:          woods·zhang
// Email:           hoojar@163.com 
// MSN:             hoojar@hotmail.com
// Copyright 2001-2006, Hoojar studio All Rights Reserved
//
// 版权 2001-2006，慧佳工作室所有版权保护

//The software for free software, allowing use, copy, 
//modify and distribute the software and files. Any 
//use of this software must place a copy of all the 
//above copyright notice. By the software Huijia studio 
//maintenance, if you have any queries please contact us.
//Thank you. 
//
//此软件为自由软件，允许使用、拷贝、修改、分发本软件及其文档。
//任何使用此软件的地方都得出现以上版权通告所有副本。此软件由
//慧佳工作室维护，如果您有什么疑问请与我们联系。谢谢使用。
//
///////////////////////////////////////////////////////////////////////////////
function get_matter($url)
{
        $content = "";
        $fp = @fopen($url, "r";
        if ($fp)
        {
                while ($tip = @fread($fp, 1024))
                {
                        $content .= $tip;
                }
                @fclose($fp);
        }
        return $content;
}

/*-----------------------------------------------------------------------------------------------------------*/
if(!$url)$url = $argv[1];
if (!$url)
{
        echo("You without send url address!\nPlease setting url following index.php http://....\n";
        exit(1);
}
if (!$fn)$fn = $argv[2];
$folder = substr($fn, 0, strpos($fn, "-");
if (! file_exists("./{$folder}")mkdir("./{$folder}";
$fn = str_replace("-" ,"", $fn);

$content = get_matter($url);
preg_match_all("/t><a href=\"(.+?)\"/", $content, $URL);
$host = substr($url, 0, strrpos($url, "/"+1);
$search = array ("'^'","'\"'"; 
$replace = array ("{$host}", "";
$url = preg_replace($search, $replace, $URL[1]);
$plist = array();

$search = array(
"'javascript.+?)\"'si",
"'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
"'<br( \/)>'is", 
"'<[\/\!]*?[^<>]*?>'si",           // 去掉 HTML 标记
"'&(quot|#34);'i",                 // 替换 HTML 实体
"'&(amp|#3;'i",
"'&(lt|#60);'i",
"'&(gt|#62);'i",
"'&(nbsp|#160);'i",
"'&(iexcl|#161);'i",
"'&(cent|#162);'i",
"'&(pound|#163);'i",
"'&(copy|#169);'i",
"'&#(\d+);'e",
"'&(ldquo|mdash|bull|rdquo|hellip|rsquo|lsquo);'e";// 作为 PHP 代码运行

$replace = array(
"",
"",
"\r\n",
"",
"\"",
"&",
"<",
">",
" ",
chr(161),
chr(162),
chr(163),
chr(169),
"chr(\\1)",
"";

for ($i = 0; $i < count($url); ++$i)
{
        echo($url[$i] . "\r\n");
        $content = get_matter($url[$i]);
        preg_match("/<title>(.+?)<\/title>/si", $content, $tip);
        $plist[$i]["TITLE"] = $tip[1];//贴子主题
        preg_match("/<td>(.+?)<\/td>/si", $content, $tip);
        $plist[$i]["CONTENT"] = preg_replace($search, $replace, $tip[1]);//贴子内容
}

ob_start();
header('Content-Type: text/xml');
$atpl = array();
include("./woods-templates.php");
$tpl = new WoodsTpl("./", ".xml");
$tpl->set_file();
$tpl->block("DATA", $plist);
$tpl->parse($atpl, true);
$tpl = NULL;
file_put_contents("./{$folder}/{$fn}.xml", ob_get_contents());
ob_end_clean();
?>