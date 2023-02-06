<?php
namespace Abeliani\SlugHelper\Tests;

use Abeliani\SlugHelper\SlugHelper;
use Codeception\Test\Unit;

class SlugHelperTest extends Unit
{
    public function testSomeFeature(): void
    {
        $helper = new SlugHelper;

        $this->assertEquals('test-a-very-good-text', $helper('  `Test, a very good text !'));
    }

    public function testRemoveArticles(): void
    {
        $helper = new SlugHelper(['a', 'an']);

        $this->assertEquals('', $helper('A aN'));
        $this->assertEquals('apple-it-is-fruit', $helper->process('An apple  it is fruit! '));
        $this->assertEquals('book-with-apple', $helper->process('A book with an apple'));
    }
}
