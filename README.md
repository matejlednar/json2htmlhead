#JSON to HTML &lt;head> for PHP (json2htmlhead)

HTML &lt;head> element generator from JSON for PHP

Application generates <head> elements from defined JSON.

JSON supports two directories. One for development and one for release. 
If you are using in your project only one directory, write same data for both objects - dev and release.
This structure is optional. You can omit any property. It will automatically filled with empty string.

JSON supports The Open Graph protocol (http://ogp.me/). User must update &lt;html&gt; element to <br>
&lt;html lang="en" prefix="og: http://ogp.me/ns#" &gt;.

##Application overview
- user can define unlimited fonts
- user can define unlimited libraries
- user can define unlimited RSS
- user can define unlimited CSS files
- user can define unlimited meta elements
- user can define own unlimited content meta information via "content" : {"name" : "contentValue" }


##How to run JSON to HTML head for PHP

&lt;head&gt; <br>
<? <br>
include_once 'app/php/inc/page-header.php'; <br>
?> <br>
&lt;/head&gt; <br>

## How to set own URL for JSON data
User can set own URL for JSON data:
<br>
$hg = new HeaderGenerator();<br>
$hg->start("app/json/app.json");<br>

