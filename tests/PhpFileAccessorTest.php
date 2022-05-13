<?php

use PHPUnit\Framework\TestCase;
use Walnut\Lib\FileAccessor\FileAccessorException;
use Walnut\Lib\FileAccessor\PhpFileAccessor;

final class PhpFileAccessorTest extends TestCase {
	private const FILE_NAME = __DIR__ . '/temp-file.txt';
	private const FILE_CONTENT = 'This is a test';

	public function testIntegrationOnly(): void {
		$fileAccessor = new PhpFileAccessor;

		$this->assertFalse($fileAccessor->fileExists(self::FILE_NAME));
		$fileAccessor->writeToFile(self::FILE_NAME, self::FILE_CONTENT);
		$this->assertTrue($fileAccessor->fileExists(self::FILE_NAME));
		$this->assertEquals(self::FILE_CONTENT, $fileAccessor->readFromFile(self::FILE_NAME));
		$fileAccessor->appendToFile(self::FILE_NAME, self::FILE_CONTENT);
		$this->assertEquals(self::FILE_CONTENT . self::FILE_CONTENT, $fileAccessor->readFromFile(self::FILE_NAME));
		$fileAccessor->removeFile(self::FILE_NAME);
		$this->assertFalse($fileAccessor->fileExists(self::FILE_NAME));
	}

	public function testIntegrationErrorRead(): void {
		$this->expectException(FileAccessorException::class);
		$fileAccessor = new PhpFileAccessor;
		$fileAccessor->readFromFile(self::FILE_NAME);
	}

	public function testIntegrationErrorWrite(): void {
		$this->expectException(FileAccessorException::class);
		$fileAccessor = new PhpFileAccessor;

		$fp = fopen(self::FILE_NAME, 'wb');
		flock($fp, LOCK_EX);
		try {
			$fileAccessor->writeToFile(self::FILE_NAME, self::FILE_CONTENT);
		} catch (Throwable $ex) {
			flock($fp, LOCK_UN);
			fclose($fp);
			throw $ex;
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		@unlink(self::FILE_NAME);
	}

	public function testIntegrationErrorAppend(): void {
		$this->expectException(FileAccessorException::class);
		$fileAccessor = new PhpFileAccessor;

		$fp = fopen(self::FILE_NAME, 'wb');
		flock($fp, LOCK_EX);
		try {
			$fileAccessor->appendToFile(self::FILE_NAME, self::FILE_CONTENT);
		} catch (Throwable $ex) {
			flock($fp, LOCK_UN);
			fclose($fp);
			throw $ex;
		}
		flock($fp, LOCK_UN);
		fclose($fp);
		@unlink(self::FILE_NAME);
	}

	public function testIntegrationErrorRemove(): void {
		$this->expectException(FileAccessorException::class);
		$fileAccessor = new PhpFileAccessor;

		$fileAccessor->removeFile(self::FILE_NAME);
		$fileAccessor->removeFile(self::FILE_NAME);
	}

}