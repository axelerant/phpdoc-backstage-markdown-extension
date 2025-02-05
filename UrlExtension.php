<?php

namespace axelerant\PhpDocMarkdown;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class UrlExtension extends AbstractExtension
{

    /**
     * {@inheritdoc}
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('markdown_route', array($this, 'markdownRoute')),
            new TwigFilter('markdown_link', array($this, 'markdownLink')),
        ];
    }


    public function markdownLink($object, $curr_template) {
        if (is_array($object)) {
            $result = [];
            foreach ($object as $obj) {
                $result[] = $this->fixRoute($obj, $curr_template);
            }
            return $result;
        }

        return $this->fixRoute($object, $curr_template);
    }


    public function markdownRoute($object, $curr_template) {
        if (is_array($object)) {
            $result = [];
            foreach ($object as $obj) {
                $result[] = $this->prepareRoute($obj, $curr_template);
            }
            return $result;
        }

        return $this->prepareRoute($object, $curr_template);

    }

    public function prepareRoute($object, $curr_template) {
        $parse_data = $this->parseRoute($object);
        // If just an abbr
        if (is_string($parse_data)) {
            return $parse_data;
        }

        if ($parse_data['abbr']) {
            return "[{$parse_data['title']}](# \"{$parse_data['href']}\")";
        }

        $url = $this->fixRoute($parse_data['href'], $curr_template);
        return "[{$parse_data['title']}]({$url})";
    }

    public function parseRoute($input) {
        // Pattern to match <a> tag containing an <abbr> tag
        $aTagWithAbbrPattern = '/<a\s+href="([^"]+)">.*?<abbr\s+title="([^"]+)">(.*?)<\/abbr>.*?<\/a>/i';
        // Pattern to match <a> tag without <abbr>
        $aTagPattern = '/<a\s+href="([^"]+)">(.*?)<\/a>/i';
        // Pattern to match <abbr> tag
        $abbrPattern = '/<abbr\s+title="([^"]+)">(.*?)<\/abbr>/i';

        if (preg_match($aTagWithAbbrPattern, $input, $matches)) {
            return [
                'href' => $matches[1],
                'title' => $matches[3],
                'abbr' => false,
            ];
        }

        if (preg_match($aTagPattern, $input, $matches)) {
            return [
                'href' => $matches[1],
                'title' => $matches[2],
                'abbr' => false,
            ];
        }

        if (preg_match($abbrPattern, $input, $matches)) {
            return [
                'href' => $matches[1],
                'title' => $matches[2],
                'abbr' => true,
            ];
        }

        return $input; // If not an <a> or <abbr> tag, return the original string
    }

    public function fixRoute($url, $curr_template) {
        $url = str_replace(['.html', '#function_', '#method_', '#property_'], ['.md', '#', '#', '#'], $url);

        // Make anchor part lowercase
        if (strpos($url, '#') !== false) {
            [$base, $anchor] = explode('#', $url, 2);
            $url = $base . '#' . strtolower($anchor);
        }

        // Apply conditional prefix
        if ($curr_template === 'index') {
            $url = './' . $url;
        } else {
            $url = '../' . $url;
        }
        return $url;
    }
}
