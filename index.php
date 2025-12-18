<?php
/*
 * Copyright (c) 2025 Bloxtor (http://bloxtor.com) and Joao Pinto (http://jplpinto.com)
 * 
 * Multi-licensed: BSD 3-Clause | Apache 2.0 | GNU LGPL v3 | HLNC License (http://bloxtor.com/LICENSE_HLNC.md)
 * Choose one license that best fits your needs.
 *
 * Original PHP Curl Lib Repo: https://github.com/a19836/php-curl-lib/
 * Original Bloxtor Repo: https://github.com/a19836/bloxtor
 *
 * YOU ARE NOT AUTHORIZED TO MODIFY OR REMOVE ANY PART OF THIS NOTICE!
 */
?>
<style>
h1 {margin-bottom:0; text-align:center;}
h5 {font-size:1em; margin:40px 0 10px; font-weight:bold;}
p {margin:0 0 20px; text-align:center;}

.note {text-align:center;}
.note span {text-align:center; margin:0 20px 20px; padding:10px; color:#aaa; border:1px solid #ccc; background:#eee; display:inline-block; border-radius:3px;}
.note li {margin-bottom:5px;}

.code {display:block; margin:10px 0; padding:0; background:#eee; border:1px solid #ccc; border-radius:3px; position:relative;}
.code:before {content:"php"; position:absolute; top:5px; left:5px; display:block; font-size:80%; opacity:.5;}
.code textarea {width:100%; height:300px; padding:30px 10px 10px; display:inline-block; background:transparent; border:0; resize:vertical; font-family:monospace;}
.code.short textarea {height:120px;}
</style>
<h1>PHP Curl Lib</h1>
<p>Fetch urls</p>
<div class="note">
		<span>
		This library simplifies making HTTP requests using the cURL extension.<br/>
		It provides a clean, object-oriented API to perform GET, POST, PUT, DELETE, and other HTTP requests, handle headers, query parameters, and manage responses efficiently.<br/>
		<br/>
		The library allows you to:<br/>
		<ul style="display:inline-block; text-align:left;">
			<li>Send HTTP requests to any URL with full control over method, headers, and payload</li>
			<li>Handle GET, POST, PUT, DELETE, PATCH, and custom HTTP methods</li>
			<li>Manage request headers, cookies, and query parameters easily</li>
			<li>Send JSON, form-data, or raw body content</li>
			<li>Receive and parse responses, including headers and status codes</li>
			<li>Handle timeouts, redirects, and SSL verification</li>
			<li>Support synchronous and asynchronous requests (if implemented)</li>
			<li>Simplify error handling and logging of requests/responses</li>
		</ul>
		<br/>
		This library is ideal for integrating with APIs, web services, and performing server-to-server communication in a reliable and reusable way.
		</span>
</div>

<h2>Usage</h2>

<div>
	<h5>Get urls content</h5>
	<div class="code short">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

$html = MyCurl::getUrlContents(array("url" => "https://bloxtor.com"), "content");
		</textarea>
	</div>
</div>

<div>
	<h5>Download File</h5>
	<div class="code short">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

$downloaded_file_pointer = null; //optional
$downloaded_file_info = MyCurl::downloadFile($file_url, $downloaded_file_pointer);
		</textarea>
	</div>
</div>

<div>
	<h5>Get single url header</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

//set url single data. The only mandatory configuration is the key: "url"!
$single_data = array(
	"url" => $url, 
	"post" => array(
		"ab" => $ab,
		"st" => array("activity")
	),
	"cookie" => $_COOKIE,
	"settings" => array(
		"follow_location" => 1,
		"connection_timeout" => 10,
		"header" => 1,
		"no_body" => true,
		"http_auth" => !empty($_SERVER["AUTH_TYPE"]) ? $_SERVER["AUTH_TYPE"] : null,
		"user_pwd" => !empty($_SERVER["PHP_AUTH_USER"]) ? $_SERVER["PHP_AUTH_USER"] . ":" . (isset($_SERVER["PHP_AUTH_PW"]) ? $_SERVER["PHP_AUTH_PW"] : "") : null,
	)
);

//set the returned type
$result_type = "header"; //available values: "settings", "header", "content", "content_json", "content_xml", "content_xml_simple", "content_serialized"

//fetch url
$header = MyCurl::getUrlContents($single_data, $result_type);

//print url html
echo $header;
		</textarea>
	</div>
</div>

<div>
	<h5>Get single url data - settings, header and html</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

//set url single data. The only mandatory configuration is the key: "url"!
$single_data = array(
	"url" => $url, //string with url to fetch
	"post" => $post, //query string or associative array with key-value pair list.
	"get" => $get, //query string or associative array with key-value pair list.
	"cookie" => $cookie, //cookies string or associative array with key-value pair list.
	"files" => array(
		"file name to display" => array(
			"tmp_name" => "file path", 
			"name" => "original file name", 
			"type" => "file content type"
		)
	),
	"settings" => array(
		"put" => true, //Set to true to HTTP PUT a file.
		"header" => true, //Set to true to include the headers in the output
		"connection_timeout" => 60, //in seconds
		"no_body" => false, //Set to true to exclude the body from the output
		"http_header" => array('Content-type: text/plain', 'Content-length: 100'), //An array of HTTP header fields to set, in the format 
		"referer" => "", //A string with the contents of the Referer
		"follow_location" => true,
		"http_auth" => "basic", //Available values: "", "basic", "digest", CURLAUTH_BASIC, CURLAUTH_DIGEST, CURLAUTH_GSSNEGOTIATE, CURLAUTH_NTLM, CURLAUTH_ANY, CURLAUTH_ANYSAFE
		"user_pwd" => "test:test", //A username and password formatted as [username]:[password] to use for the connection.
		"read_cookies_from_file" => "", //A string with the name of the file containing the cookie data. The cookie file can be in Netscape format, or just plain HTTP-style headers dumped into a file.
		"save_cookies_to_file" => "", //A string with the name of a file to save all internal cookies to when the handle's destructor is called.
		
		//Add also other settings to your CURL based in available curl options defined at: https://www.php.net/manual/en/curl.constants.php#constant.curlopt-abstract-unix-socket. The key setting must start with 'CURLOPT_'
		//"CURLOPT_XXX" => "...",
	)
);

//fetch url
$MyCurl = new MyCurl();
$MyCurl->initSingle($single_data);
$MyCurl->get_contents($async = false); //fetch urls sequentially
$data = $MyCurl->getData();
$data = isset($data[0]) ? $data[0] : null;

//print url data
echo "<pre>" . print_r($data) . "</pre>";
		</textarea>
	</div>
</div>

<div>
	<h5>Get data from group of urls with same configurations</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

//set urls group data. The only mandatory configuration is the key: "urls"!
$group_data = array(
	"urls" => array("https://bloxtor.com", "https://bloxtor.com/framework", "https://bloxtor.com/pricing"), 
	"cookie" => $_COOKIE,
	"settings" => array(
		"follow_location" => 1,
		"connection_timeout" => 10,
	)
);

//fetch urls
$MyCurl = new MyCurl();
$MyCurl->initSingleGroup($group_data); //init all urls with the same configurations
$MyCurl->get_contents($async = false); //fetch urls sequentially
$data = $MyCurl->getData();

//print all urls data
echo "<pre>" . print_r($data) . "</pre>";
		</textarea>
	</div>
</div>

<div>
	<h5>Get multiple urls with different configurations</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

//set multiple urls data. The only mandatory configuration is the key: "url" for each array item!
$multiple_data = array(
	array(
		"url" => "http://url_1.com",
		"post" => array("a" => "b"),
	),
	array(
		"url" => "http://url_2.com",
		"cookie" => $cookie,
	),
	array(
		"url" => "http://url_3.com",
		"settings" => array(
			"connection_timeout" => 10,
			//...
		),
		//...
	),
	//...
);

//fetch urls
$MyCurl = new MyCurl();
$MyCurl->initMultiple($multiple_data);
$MyCurl->get_contents($async = false); //fetch urls sequentially
$data = $MyCurl->getData();

//print all urls data
echo "<pre>" . print_r($data) . "</pre>";
		</textarea>
	</div>
</div>

<div>
	<h5>Get urls asynchronously</h5>
	<div class="code">
		<textarea readonly>
include __DIR__ . "/lib/MyCurl.php";

//set urls group data.
$group_data = array(
	"urls" => array("https://bloxtor.com", "https://bloxtor.com/framework", "https://bloxtor.com/pricing"), 
);

//fetch urls
$MyCurl = new MyCurl();
$MyCurl->initSingleGroup($group_data); //init all urls with the same configurations
$MyCurl->get_contents($async = true); //fetch urls all at once - asynchronously
$data = $MyCurl->getData();

//print all urls data
echo "<pre>" . print_r($data) . "</pre>";
		</textarea>
	</div>
</div>

