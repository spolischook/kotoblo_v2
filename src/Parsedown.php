<?php

namespace App;

use Parsedown as BaseParsedown;

class Parsedown extends BaseParsedown
{
    protected function blockFencedCode($line)
    {
        $block = parent::blockFencedCode($line);

        if ($block) {
            if (@isset($block['element']['text']['attributes']['class'])) {
                $class = $block['element']['text']['attributes']['class'];
                $class = str_replace('language-', '', $class);
                $block['element']['text']['attributes']['class'] = $class;

                //test
                $el = $block['element']['text'];
                $block['element']['text'] = $el;
            }
        }

        return $block;
    }
}
