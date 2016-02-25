<?php

/**
 * Ensure basic Netscape bookmarks are properly parsed
 *
 * @see https://msdn.microsoft.com/en-us/library/aa753582%28v=vs.85%29.aspx
 * @see http://www.w3schools.com/tags/tag_dl.asp
 */
class ParseNetscapeBookmarksTest extends PHPUnit_Framework_TestCase
{
    /**
     * Parse a basic Netscape file
     */
    public function test_parse_basic()
    {
        $bkm = parse_netscape_bookmarks(
            file_get_contents('tests/input/netscape_basic.htm')
        );
        $this->assertEquals(2, sizeof($bkm));

        $this->assertEquals('Secret stuff', $bkm[0]['title']);
        $this->assertEquals(0, $bkm[0]['pub']);
        $this->assertEquals('private secret', $bkm[0]['tags']);
        $this->assertEquals('971175336', $bkm[0]['time']);
        $this->assertEquals(
            'Super-secret stuff you\'re not supposed to know about',
            $bkm[0]['note']
        );

        $this->assertEquals('Public stuff', $bkm[1]['title']);
        $this->assertEquals(1, $bkm[1]['pub']);
        $this->assertEquals('public hello world', $bkm[1]['tags']);
        $this->assertEquals('1456433748', $bkm[1]['time']);
        $this->assertEquals('', $bkm[1]['note']);
    }

    /**
     * Parse log dates
     */
    public function test_parse_log_dates()
    {
        $this->assertEquals(
            '971211336',
            parse_bookmark_date('10/Oct/2000:13:55:36 -0700')
        );
        $this->assertEquals(
            '971186136',
            parse_bookmark_date('10/Oct/2000:13:55:36 +0000')
        );
        $this->assertEquals(
            '971175336',
            parse_bookmark_date('10/Oct/2000:13:55:36 +0300')
        );
    }

    /**
     * Parse Unix timestamps
     */
    public function test_parse_unix_dates()
    {
        $this->assertEquals(
            '1456433748',
            parse_bookmark_date('1456433748')
        );
        $this->assertEquals(
            '971175336',
            parse_bookmark_date('971175336')
        );
        $this->assertEquals(
            '-371211336',
            parse_bookmark_date('-371211336')
        );
    }
}
