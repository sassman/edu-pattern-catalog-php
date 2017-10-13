<?php

namespace PatternCatalog\Structural\Decorator;

// TODO fix that inclusion
require_once __DIR__ . DIRECTORY_SEPARATOR . 'InterceptedTestCase.php';

/**
 * @group integration
 */
class GzipOutputStreamTest extends InterceptedTestCase
{
    /**
     * @var string
     */
    private $filePathUncompressed = '/tmp/' . __CLASS__;
    /**
     * @var string
     */
    private $filePath;

    public function test_println_willCreateValidGzipFile()
    {
        $this->out->println('Foo Bar Bak');
        $this->assertThatGzipContentEquals("Foo Bar Bak\n");
    }

    public function test_println_withArguments()
    {
        $this->out->println('Foo Bar %s', 'Bak');
        $this->assertThatGzipContentEquals("Foo Bar Bak\n");
    }

    public function test_printf_withArguments()
    {
        $this->out->printf('Foo Bar %s', 'Bak');
        $this->assertThatGzipContentEquals('Foo Bar Bak');
    }

    protected function setUp()
    {
        parent::setUp();
        $this->filePath = $this->filePathUncompressed . '.gz';
        $this->out = new GzipOutputStream(new FileOutputStream($this->filePath));
    }

    protected function tearDown()
    {
        $this->cleanUpFiles();
        parent::tearDown();
    }

    private function assertThatGzipContentEquals($string)
    {
        exec("gzip -df '{$this->filePath}'");
        $content = file_get_contents($this->filePathUncompressed);
        $this->assertThat($content, $this->equalTo($string));
    }

    private function cleanUpFiles()
    {
        $this->cleanUpFile($this->filePathUncompressed);
        $this->cleanUpFile($this->filePath);
    }

    private function cleanUpFile($file)
    {
        if (is_file($file)) {
            unlink($file);
        }
    }
}