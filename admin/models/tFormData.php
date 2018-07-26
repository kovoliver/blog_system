<?php namespace Traits;

trait FormData {
    public function FormDataAssoc(&$array) {
        $associativeArray = array();
        foreach($array as $arr) {
            if($arr["name"] != ":content" && $arr["name"] != ":og.image")
                $associativeArray[$arr["name"]] = htmlspecialchars($arr["value"]);
            else if($arr["name"] == ":content") {
                $arr["value"] = preg_replace("/(<)[\s]{0,}(script)[\s]{0,}(>)/", "&lt;script&gt;", $arr["value"]);
                $associativeArray[$arr["name"]] = $arr["value"];
            } else if($arr["name"] == "token") {
                $associativeArray[$arr["name"]] = $arr["value"];
            }
        }
        return $associativeArray;
    }
}