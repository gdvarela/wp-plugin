<?php

class ButtonReplacerTest extends WP_UnitTestCase
{
    public function testReplace() {
        $txt = $this->_getPost('    https://www.courseticket.com/en/e/6606');
        $expected = $this->_getLink('https://www.courseticket.com/en/e/6606');

        $this->assertEquals($expected, ButtonReplacer::replace($txt));
    }

    public function testReplace_shouldAcceptLinkWithoutWww() {
        $txt = $this->_getPost('https://courseticket.com/en/e/6606');
        $expected = $this->_getLink('https://www.courseticket.com/en/e/6606');

        $this->assertEquals($expected, ButtonReplacer::replace($txt));
    }

    public function testReplace_shouldNotReplaceInLink() {
        $txt = $this->_getPost('<a href="https://courseticket.com/en/e/6606');

        $this->assertEquals($txt, ButtonReplacer::replace($txt));
    }

    private function _getPost($link)
    {
        return "Post text!\n" . $link . "\n&nbsp;";
    }

    private function _getLink($url)
    {
        return "Post text!\n" . '<a class="courseticket-button" href="'
        . $url . '">Book now</a>' . "\n&nbsp;";
    }

    public function testReplace_shouldChangeSpan()
    {
        $input = '<span class="courseticket-button" title="Book now" data-options="showOrganizer;smallLayout" data-href="https://www.courseticket.com/de/e/316">n</span>';
        $output = '<a class="courseticket-button" href="https://www.courseticket.com/de/e/316" data-options="showOrganizer;smallLayout">Book now</a>';

        $this->assertEquals($output, ButtonReplacer::replace($input));
    }

    public function testReplace_shouldChangePlainLink()
    {
        $input = 'https://www.courseticket.com/de/e/316';
        $output = '<a class="courseticket-button" href="https://www.courseticket.com/de/e/316">Book now</a>';

        $this->assertEquals($output, ButtonReplacer::replace($input));
    }
}

