<?php

namespace Walnut\Lib\FileAccessor;

final class PhpFileAccessor implements FileAccessor {
	private const WRITE_ERROR = "Unable to write to file %s";
	private const READ_ERROR = "Unable to read from file %s";
	private const REMOVE_ERROR = "Unable to remove file %s";

	/**
	 * @param string $file
	 * @param string $content
	 * @throws FileAccessorException
	 */
	public function writeToFile(string $file, string $content): void {
		$result = @file_put_contents($file, $content);
		if ($result === false) {
			throw new FileAccessorException(sprintf(self::WRITE_ERROR, $file));
		}
	}

	/**
	 * @param string $file
	 * @return string
	 * @throws FileAccessorException
	 */
	public function readFromFile(string $file): string {
		$result = @file_get_contents($file);
		if ($result === false) {
			throw new FileAccessorException(sprintf(self::READ_ERROR, $file));
		}
		return $result;
	}

	/**
	 * @param string $file
	 * @throws FileAccessorException
	 */
	public function removeFile(string $file): void {
		$result = (@file_exists($file)) && (@unlink($file));
		if ($result === false) {
			throw new FileAccessorException(sprintf(self::REMOVE_ERROR, $file));
		}
	}

	/**
	 * @param string $file
	 * @return bool
	 * @throws FileAccessorException
	 */
	public function fileExists(string $file): bool {
		return @file_exists($file);
	}

}
