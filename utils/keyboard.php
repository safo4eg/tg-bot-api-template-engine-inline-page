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
        return ['section_body' => $matches['section_body'], 'section' => $matches[0]];;
    }

    protected static function getButtonsRows($section_body)
    {
        preg_match_all('#<div>(.+?)</div>#su', $section_body, $matches, PREG_PATTERN_ORDER);
        return $matches[0];
    }

    protected static function createKeyboardStructure($keyboard_type, $buttons_rows_array, array $fields = null)
    {

        $keyboard_structure = [
            $keyboard_type => []
        ];

        $text_regexp = '/<button\s*>(?<text>.+?)<\s*\/\s*button\s*>/su';
        $field_regexp = '/<button\s*(?<attribute>(?<field>.+?)\s*=\s*["\'](?<value>.*?)["\']).*<\s*\/\s*button\s*>/su';
        $button_regexp = '/(?<button><\s*button.+?<\s*\/\s*button\s*>)/su';

        foreach ($buttons_rows_array as $buttons_row) {
            $row = [];
            while (preg_match($button_regexp, $buttons_row, $outer_matches)) {
               $col = [];
               $button = $outer_matches['button'];
               while (preg_match($field_regexp, $button, $inner_matches)) {
                   $attribute_regexp = quotemeta("#{$inner_matches['attribute']}#su");
                   $col[$inner_matches['field']] = $inner_matches['value'];
                   $button = preg_replace($attribute_regexp, '', $button, 1);
               }
               preg_match($text_regexp, $button, $inner_matches);
               $buttons_row = preg_replace($button_regexp, '', $buttons_row, 1);
               $col['text'] = $inner_matches['text'];
               $row[] = $col;
            }
            $keyboard_structure[$keyboard_type][] = $row;
        }

        if(!is_null($fields)) {
            foreach ($fields as $field => $value) {
                $keyboard_structure[$field] = $value;
            }
        }
        return $keyboard_structure;
    }
}