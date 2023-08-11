<?php

namespace Utils;

class InlinePage extends Keyboard
{
    private static function getInlinePageText($html_string, $section) {
        return str_replace($section, '', $html_string);
    }
    public static function getFields($html_string, $keyboard_type, array $fields = null) {
        $html_string = self::getHtmlSting($html_string);
        $section_info = self::getSectionBody($html_string);
        $buttons_rows = self::getButtonsRows($section_info['section_body']);

        return [
            'reply_markup' => self::createKeyboardStructure($keyboard_type, $buttons_rows, $fields),
            'text' => trim(self::getInlinePageText($html_string, $section_info['section']))
        ];
    }
}