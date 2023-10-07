<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class FilesEqualTest extends TestCase
{
    public function testFilesEqual(): void
    {
        $outputFileName = 'files/output/output.json';
        $masterFileName = 'files/master/output.json';

        $this->assertFileEquals($masterFileName, $outputFileName);
    }
}
