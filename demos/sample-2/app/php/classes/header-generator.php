<?

class HeaderGenerator {

    private $url = "";

    /**
     * main function
     */
    public function start($uri = "app/data/app.json") {
        $this-> url = $uri;
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
     * @param type $fonts - json data
     * @return string
     */
    private function getFontsFragment($data) {

        $fragment = "";

        if ($data == "") {
            return $fragment;
        }

        foreach ($data as $key => $url) {
            $fragment .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $url . "\">";
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
            $fragment .= "<link rel=\"stylesheet\" href=\"" . $url . "\">";
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
            $fragment .= "<script src=\"" . $url . "\"></script>";
        }
        return $fragment;
    }

    /**
     * Checks element existence in array and returns value
     * 
     * @param type $data - array
     * @param type $key - element
     * @return string
     */
    private function getValue($data, $key) {
        if (array_key_exists($key, $data)) {
            return $data[$key];
        } else {
            return "";
        }
    }

    /**
     * Parsing data and creating <head> content from JSON
     * 
     * @param type $data
     */
    private function parseData($data) {

        $appType = "";

        $html = "<title>" . $this->getValue($data, "title") . "</title>";
        $html .= "<meta charset=\"" . $this->getValue($data, "charset") . "\">";
        $html .= "<meta name=\"viewport\" content=\"" . $this->getValue($data, "viewport") . "\">";
        $html .= "<meta name=\"author\" content=\"" . $this->getValue($data, "author") . "\">";
        $html .= "<meta name=\"description\" content=\"" . $this->getValue($data, "description") . "\">";
        $html .= "<meta name=\"keywords\" content=\"" . $this->getValue($data, "keywords") . "\">";
        $html .= "<meta name=\"robots\" content=\"" . $this->getValue($data, "robots") . "\">";
        $html .= "<meta name=\"googlebot\" content=\"" . $this->getValue($data, "googlebot") . "\">";
        $html .= "<link rel=\"icon\" href=\"" . $this->getValue($data, "icon") . "\"> ";

        $fonts = $this->getValue($data, "fonts");
        $html .= $this->getFontsFragment($fonts);

        // detecting app version
        if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
            $appType = "dev";
        } else {
            $appType = "release";
        }

        $html .= $this->getCSSFragment($this->getValue($data[$appType],"css"));
        $html .= $this->getScriptFragment($this->getValue($data[$appType],"javascript"));
        return $html;
    }
}
?>