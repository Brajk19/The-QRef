<?php
    declare(strict_types = 1);

    //dodaje atribute elementu ovisno o tome sto je primljeno
    function addContents(string $s, array $params): string{
        foreach($params as $attribute => $value){
            if($attribute === "contents"){
                continue;
            }

            $s .= " $attribute=\"$value\"";
        }
        $s .= ">";

        if(array_key_exists("contents", $params)){
            if(is_array($params["contents"])){           //ako je array, rijec je o elementu kojem se dodaje drugi elementi
                foreach($params["contents"] as $r){      //npr. red kojem se dodaju ćelije
                    $s .= " $r";
                }
            }
            else{                                        //ako nije array, string je i onda je rijec o elementu kojem se dodaje sadrzaj
                $s .= $params["contents"];
            }
        }

        return $s;
    }


    function create_doctype():void {
        echo create_element("!doctype html", false, []);
    }

    function begin_html(): void{
        echo create_element("html", false, []);
    }
    function end_html(): void{
        echo "</html>";
    }

    function begin_head(): void{
        echo create_element("head", false, []);
    }
    function end_head(): void{
        echo "</head>";
    }

    function begin_body(array $params): void{
        echo create_element("body", false, $params);
    }
    function end_body(): void{
        echo "</body>";
    }

    function create_table(array $params): void{
        echo create_element("table", false, $params);
    }
    function end_table(){
        echo "</table>";
    }

    function create_table_row(array $params): string{
        return create_element("tr", true, $params);
    }
    function create_table_cell(array $params): string{
        return create_element("td", true, $params);
    }

    function create_element(string $name, bool $closed = true, array $params): string{
        $s = "<$name";
        $s = addContents($s, $params);

        if($closed){
            $s .= "</$name>";
        }

        return $s;
    }

    function begin_style(): void{
        echo create_element("style", false, []);
    }
    function end_style(): void{
        echo "</style>";
    }

    //stavaranje klase proizvoljnog imena
    function addCustomClass(string $name, array $params): void{
        echo ".$name {";
        foreach($params as $attribute => $value){
            echo "$attribute: $value;";
        }
        echo "}";
    }

    //klasa za postojeće tagove
    //kreiranjem će svaki put kad je korišten taj tag poprimiti obilježja navedena u klasi
    function addTagClass(string $attribute, array $params): void{
        echo "$attribute {";
        foreach($params as $att => $value){
            echo "$att: $value;";
        }
        echo "}";
    }

    //za dodavanje tagova unutar taga
    //prima obavezno NEZATVOREN tag
    function add_to_element(string &$element, string $content): void{
        $element .= $content;
    }

    //dodavanje zatvarajućeg taga
    function close_element(&$s): void{
        $tag = "";
        for($i = 1; $s[$i] !== ">" && $s[$i] !== " "; $i++){
            $tag .= $s[$i];
        }

        $s .= "</$tag>";
    }

    /*
     * NADOGRADNJE ZA DRUGU ZADAĆU
     */

    function start_form(string $action = "", string $method = "get", array $contents = []): void{
        echo create_element("form", false, array_merge(["action" => $action, "method" => $method], $contents));
    }
    function end_form(): void{
        echo "</form>";
    }

    function create_input(array $params): string{
        return create_element("input", true, $params);
    }

    function create_select(array $params): string{
        return create_element("select", true, $params);
    }
    function create_options(array $params): array{ // mora primit dvodimenzionalni niz [["value"=>"volvo", "contents"=>"marka volvo],[],[],[]]
        $arrOfOptions = [];
        foreach ($params as $option){
            $arrOfOptions[] = create_element("option", true, $option);
        }

        return $arrOfOptions;               //vraca niz u kojem je svaki element html kod za pojedini option
    }
    function create_button(array $params): string{
        return create_element("button", true, $params);
    }

    function startSession(): void{
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start([]);
        }
    }

    function endSession(): void{
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start([]);
        }
        session_unset();
        session_destroy();
    }
?>
