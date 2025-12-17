# PHP Curl Lib

> Original Repos:   
> - PHP Curl Lib: https://github.com/a19836/phpcurllib/   
> - Bloxtor: https://github.com/a19836/bloxtor/

## Overview

**PHP Curl Lib** is a library that simplifies making HTTP requests using the cURL extension.  
It provides a clean, object-oriented API to perform GET, POST, PUT, DELETE, and other HTTP requests, handle headers, query parameters, and manage responses efficiently.   

The library allows you to:   
- Send HTTP requests to any URL with full control over method, headers, and payload
- Handle GET, POST, PUT, DELETE, PATCH, and custom HTTP methods
- Manage request headers, cookies, and query parameters easily
- Send JSON, form-data, or raw body content
- Receive and parse responses, including headers and status codes
- Handle timeouts, redirects, and SSL verification
- Support synchronous and asynchronous requests (if implemented)
- Simplify error handling and logging of requests/responses

This library is ideal for integrating with APIs, web services, and performing server-to-server communication in a reliable and reusable way.   

To see a working example, open [index.php](index.php) on your server.

---

## Usage

### Get url contents

```php
include __DIR__ . "/MyCurl.php";

$html = MyCurl::getUrlContents(array("url" => "https://bloxtor.com"), "content");
```

### Download File

```php
include __DIR__ . "/MyCurl.php";

$downloaded_file_pointer = null; //optional
$downloaded_file_info = MyCurl::downloadFile($file_url, $downloaded_file_pointer);
```

### Get single url header

```php
include __DIR__ . "/MyCurl.php";

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

//print url header
echo $header;
```

### Get single url data - settings, header and html

```php
include __DIR__ . "/MyCurl.php";

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
```

### Get data from group of urls with same configurations

```php
include __DIR__ . "/MyCurl.php";

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
```

### Get multiple urls with different configurations

```php
include __DIR__ . "/MyCurl.php";

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
```

### Get urls asynchronously

```php
include __DIR__ . "/MyCurl.php";

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
```

