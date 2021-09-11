<?php

namespace Walnut\Lib\FileAccessor;

interface FileAccessor {
	/**
	 * @param string $file
	 * @param string $content
	 * @throws FileAccessorException
	 */
	public function writeToFile(string $file, string $content): void;

	/**
	 * @param string $file
	 * @return string
	 * @throws FileAccessorException
	 */
	public function readFromFile(string $file): string;

	/**
	 * @param string $file
	 * @throws FileAccessorException
	 */
	public function removeFile(string $file): void;

	/**
	 * @param string $file
	 * @return bool
	 * @throws FileAccessorException
	 */
	public function fileExists(string $file): bool;

}
