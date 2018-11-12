<?php

namespace App;

use Parsedown as BaseParsedown;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class Parsedown extends BaseParsedown
{
    protected $fileDir;
    protected $basePath;
    protected $baseUrl;

    public function textFile($file, $basePath, $baseUrl)
    {
        if (!$content = file_get_contents($file)) {
            throw new FileNotFoundException(
                sprintf('File "%s" not found', $file)
            );
        }

        $content = file_get_contents($file);
        $this->fileDir = dirname($file);
        $this->basePath = $basePath;
        $this->baseUrl = $baseUrl;

        return $this->text($content);
    }

    protected function element(array $Element)
    {
        $Element = $this->normalizeLink($Element);
        $Element = $this->replaceMathFormula($Element);

        return parent::element($Element);
    }

    protected function replaceMathFormula(array $Element)
    {
        if ($Element['name'] !== 'img') {
            return $Element;
        }

        if (!isset($Element['attributes']['src'])) {
            return $Element;
        }

        $src = $Element['attributes']['src'];

        chdir($this->fileDir);
        $file = realpath($src);
        $path_parts = pathinfo($file);
        $texFile = $path_parts['dirname'].'/'.$path_parts['filename'].'.tex';

        if (!file_exists($texFile)) {
            return $Element;
        }

        $Element = [
            'name' => 'span',
            'handler' => 'mathJaxHandler',
            'text' => file_get_contents($texFile),
        ];

        return $Element;
    }

    protected function mathJaxHandler($text)
    {
        $tex = $text;
        $texArr = explode('begin{document}', $tex);
        $tex = array_pop($texArr);
        $texArr = explode('\end{document}', $tex);
        $tex = array_shift($texArr);
        $tex = trim($tex);

        if(strstr($tex, "\n")) {
            return sprintf('$$%s$$', $tex);
        }

        return sprintf('$%s$', $tex);
    }

    protected function normalizeLink(array $Element)
    {
        if (!isset($Element['attributes']['href'])) {
            return $Element;
        }

        $href = $Element['attributes']['href'];

        if (!preg_match('/^.*\.md$/', $href)) {
            return $Element;
        }

        chdir($this->fileDir);

        $file = realpath($href);
        $uri = substr($file, strlen($this->basePath)-1);
        $uri = substr($uri, null, -3);
        $Element['attributes']['href'] = $this->baseUrl.$uri;


        chdir(__DIR__);

        return $Element;
    }

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
