#JSON to HTML &lt;head> for PHP (json2htmlhead)

HTML &lt;head> element generator from JSON for PHP

Application generates <head> elements from defined JSON.

JSON supports two directories. One for development and one for release. 
If you are using in your project only one directory, write same data for both objects - dev and release.
This structure is optional. You can omit any property. It will automatically filled with empty string.
<br>

javascript and css property can be augmented for new libraries. Number of libraries or fonts is not limited.

##How to run JSON to HTML head for PHP

&lt;head<&gt; <br>
include_once 'app/php/inc/page-header.php'; (json2htmlhead) <br>
&lt;/head<&gt; <br>

## How to set own URL for JSON data
User can set own URL for JSON data:
<br>
$hg = new HeaderGenerator();<br>
$hg->start("app/json/app.json");<br>

