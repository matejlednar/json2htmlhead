<?

class FooterGenerator {

    private $url = "data/references.json";
    private $col1 = array();
    private $col2 = array();
    private $col3 = array();
    private $col4 = array();
    private $jsonData = "";
    private $containerClasses = "";

    public function generate($css = "container") {
        $this -> containerClasses = $css;
        $data = $this->getJson();
        // atlantis has problem with json_last_error() function
        //  if ($this->isValidJSON()) {
        $this->createOutput($data);
        //  }
    }

    /**
     * JSON validation checker
     */
    public function isValidJSON() {
        return (json_last_error() === JSON_ERROR_NONE);
    }

    /**
     * Loading JSON, if JSON exist, use it
     * 
     * @return Array
     */
    public function getJson() {
        if ($this->jsonData == "") {
            $content = file_get_contents($this->url);
            return json_decode($content, true);
        } else {
            return $content = $this->jsonData;
        }
    }

    /**
     * Storing JSON
     * 
     * @return Array
     */
    public function setJsonData($data) {
        $this->jsonData = $data;
    }

    private function createLIElements($data, $col) {

        $css = "";
        $fragment = "";

        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];
            $css = $item[2] == true ? "heading" : "";
            $fragment .= "<li role=\"presentation\" class=\"$css\">";
            $fragment .= "<a tabindex=\"0\" role=\"menuitem\" href=\"$item[1]\" title=\"$item[0]\"> $item[0]</a>";
            $fragment .= "</li>";
        }
        // sets column width
        switch ($col) {
            case 1 : {
                    $css = 3;
                    break;
                }
            case 2 : {
                    $css = 3;
                    break;
                }
            case 3 : {
                    $css = 4;
                    break;
                }
            case 4 : {
                    $css = 2;
                    break;
                }
        }

        $fragment = "<div class=\"col-sm-$css\"><ul>" . $fragment;
        return $fragment . "</ul></div>";
    }

    private function createHeader() {
        $fragment = "";
        $fragment .= $this->createLIElements($this->col1, 1);
        $fragment .= $this->createLIElements($this->col2, 2);
        $fragment .= $this->createLIElements($this->col3, 3);
        $fragment .= $this->createLIElements($this->col4, 4);
        return $fragment;
    }

    private function createOutput($jsonData) {
        $css = $this->containerClasses;
        echo "<div class=\"$css footer content\">";
        echo "<div class=\"row\">";
        foreach ($jsonData as $index => $object) {
            $items = $jsonData[$index];

            foreach ($items as $property => $data) {
                $name = $data["name"]; // full name
                $url = $data["url"];
                $heading = $data["heading"];
                $col = $data["col"];

                if ($col == 1) {
                    $this->col1[] = array(
                        $name,
                        $url,
                        $heading);
                }
                if ($col == 2) {
                    $this->col2[] = array(
                        $name,
                        $url,
                        $heading);
                }
                if ($col == 3) {
                    $this->col3[] = array(
                        $name,
                        $url,
                        $heading);
                }
                if ($col == 4) {
                    $this->col4[] = array(
                        $name,
                        $url,
                        $heading);
                }
            }
            echo $this->createHeader();
        }

        echo "</div>";
        echo "</div>";
    }

}

?>