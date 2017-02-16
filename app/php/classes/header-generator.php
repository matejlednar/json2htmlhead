<?
/**
 * JSON to HTML <head> for PHP (json2htmlhead)
 * 
 * with The Open Graph protocol (http://ogp.me/) support
 */
class HeaderGenerator {

    private $url = "";

    /**
     * main function
     */
    public function start($uri = "data/app.json") {
        $this->url = $uri;
        $data = $this->getJson();
        $html = $this->parseData($data);
        $this->showHTML($html);
    }

    /**
     * Shows HTML fragment
     * 
     * @param type $fragment
     */
    public function showHTML($fragment) {
        echo $fragment;
    }

    /**
     * Loading JSON, if JSON exist, use it
     * 
     * @return Array
     */
    public function getJson() {
        $content = file_get_contents($this->url);
        return json_decode($content, true);
    }

    /**
     * Creates link element for font
     * 
     * @param type $data - json data
     * @return string
     */
    private function getFontsFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $key => $url) {
            $fragment .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$url\">";
        }
        return $fragment;
    }

    /**
     * Creates link element for RSS
     * 
     * @param type $data - json data
     * @return string
     */
    private function getRSSFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $url => $title) {
            $fragment .= "<link href=\"$url\" rel=\"alternate\" type=\"application/rss+xml\" title=\"$title\">";
        }
        return $fragment;
    }

    /**
     * Creates meta element with name and content attrbibute
     * 
     * @param type $data - json data
     * @return string
     */
    private function getContentFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $name => $content) {
            $fragment .= "<meta name=\"$name\" content=\"$content\">";
        }
        return $fragment;
    }

    /**
     * Creates The Open Graph protocol - meta element with property and content attributes
     * Update your <html> element to <html prefix="og: http://ogp.me/ns#">
     * 
     * @param type $data - json data
     * @return string
     */
    private function getPropertyFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $name => $content) {
            $fragment .= "<meta property=\"$name\" content=\"$content\">";
        }
        return $fragment;
    }

    /**
     * Creates link element for style
     *  
     * @param type $data
     * @return string
     */
    private function getCSSFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $key => $url) {
            $fragment .= "<link rel=\"stylesheet\" href=\"$url\">";
        }
        return $fragment;
    }

    /**
     * Creates link element for script
     * 
     * @param type $data
     * @return string
     */
    private function getScriptFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $key => $url) {
            $fragment .= "<script src=\"$url\"></script>";
        }
        return $fragment;
    }

    private function getValue($data, $key) {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        } else {
            return "";
        }
    }

    /**
     * Parsing data and creating <head> content from json
     * 
     * @param type $data
     */
    private function parseData($data) {

        $appType = "";

        $title = $this->getValue($data, "title");
        $html = $title != "" ? "<title>" . $title . "</title>" : $title;

        $charset = $this->getValue($data, "charset");
        $html .= $charset != "" ? "<meta charset=\"" . $charset . "\">" : $charset;

        $viewport = $this->getValue($data, "viewport");
        $html .= $viewport != "" ? "<meta name=\"viewport\" content=\"" . $viewport . "\">" : $viewport;

        $author = $this->getValue($data, "author");
        $html .= $author != "" ? "<meta name=\"author\" content=\"" . $author . "\">" : $author;

        $description = $this->getValue($data, "description");
        $html .= $description != "" ? "<meta name=\"description\" content=\"" . $description . "\">" : $description;

        $keywords = $this->getValue($data, "keywords");
        $html .= $keywords != "" ? "<meta name=\"keywords\" content=\"" . $keywords . "\">" : $keywords;

        $robots = $this->getValue($data, "robots");
        $html .= $robots != "" ? "<meta name=\"robots\" content=\"" . $robots . "\">" : "";

        $googlebot = $this->getValue($data, "googlebot");
        $html .= $googlebot != "" ? "<meta name=\"googlebot\" content=\"" . $googlebot . "\">" : $googlebot;

        // other content metadata
        $content = $this->getValue($data, "content");
        $html .= $this->getContentFragment($content);

        $property = $this->getValue($data, "property");
        $html .= $this->getPropertyFragment($property);

        $rss = $this->getValue($data, "rss");
        $html .= $this->getRSSFragment($rss);

        $icon = $this->getValue($data, "icon");
        $html .= $icon != "" ? "<link rel=\"icon\" href=\"" . $icon . "\"> " : $icon;

        $fonts = $this->getValue($data, "fonts");
        $html .= $this->getFontsFragment($fonts);

        if (filter_input(INPUT_GET, 'release') === "true") {
            $appType = "release";
        }         
        else if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            $appType = "dev";
        } else {
            $appType = "release";
        }

        $html .= $this->getCSSFragment($this->getValue($data[$appType], "css"));
        $html .= $this->getScriptFragment($this->getValue($data[$appType], "javascript"));
        return $html;
    }
}
?>
