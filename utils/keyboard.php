<?php
namespace Utils;
class Keyboard {
    protected static function getHtmlSting($file_name)
    {
        return file_get_contents($_SERVER['DOCUMENT_ROOT'].ROOT_DIR."/html/$file_name.html");
    }

    protected static function getSectionBody($html_string)
    {
        preg_match('#<section>(?<section_body>.+?)</section>#su', $html_string, $matches);
        return $matches['section_body'];
    }

    protected static function getButtonsRows($section_body)
    {
        preg_match_all('#<div>(.+?)</div>#su', $section_body, $matches, PREG_PATTERN_ORDER);
        return $matches[0];
    }

    protected static function createKeyboardStructure($keyboard_type, $buttons_rows_array)
    {
        $keyboard_structure = [
            $keyboard_type => []
        ];

        $regexp = '#<button\s*callback-data\s*=\s*["\'](?<callback_data>[^"\']*)["\']\s*>(?<text>.+?)</button>#su';

        foreach($buttons_rows_array as $buttons_row) {
            $row = [];
            while(preg_match($regexp, $buttons_row, $matches)) {
                $col = [];
                $col['text'] = trim($matches['text']);
                $col['callback_data'] = trim($matches['callback_data']);
                $row[] = $col;
                $buttons_row = preg_replace($regexp, '', $buttons_row, 1);
            }
            $keyboard_structure[$keyboard_type][] = $row;
        }
        return $keyboard_structure;
    }
}