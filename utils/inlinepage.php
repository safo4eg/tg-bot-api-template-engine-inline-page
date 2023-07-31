<?php

namespace Utils;

class InlinePage extends Keyboard
{
    private static function getInlinePageText($html_string, $section_body) {
        return str_replace($section_body, '', $html_string);
    }
    public static function getFields($file_name, $keyboard_type) {
        $fields = [];
        $html_string = self::getHtmlSting($file_name);
        $section_body = self::getSectionBody($html_string);
        $buttons_rows = self::getButtonsRows($section_body);
        $fields['reply_markup'] = self::createKeyboardStructure($keyboard_type, $buttons_rows);
        $fields['text'] = self::getInlinePageText($html_string, $section_body);
        return $fields;
    }
}