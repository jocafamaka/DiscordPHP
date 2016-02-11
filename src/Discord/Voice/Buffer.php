<?php

/*
 * This file is apart of the DiscordPHP project.
 *
 * Copyright (c) 2016 David Cole <david@team-reflex.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the LICENSE.md file.
 */

namespace Discord\Voice;

use ArrayAccess;
use TrafficCophp\ByteBuffer\Buffer as BaseBuffer;

/**
 * A Byte Buffer similar to Buffer in NodeJS.
 */
class Buffer extends BaseBuffer implements ArrayAccess
{
    /**
     * Writes a 32-bit unsigned integer with big endian.
     *
     * @param int $value  The value that will be written.
     * @param int $offset The offset that the value will be written.
     *
     * @return void
     */
    public function writeUInt32BE($value, $offset)
    {
        $this->insert('I', $value, $offset, 3);
    }

    /**
     * Writes a 64-bit unsigned integer with little endian.
     *
     * @param int $value  The value that will be written.
     * @param int $offset The offset that the value will be written.
     *
     * @return void
     */
    public function writeUInt64LE($value, $offset)
    {
        $this->insert('P', $value, $offset, 8);
    }

    /**
     * Writes a signed integer.
     *
     * @param int $value  The value that will be written.
     * @param int $offset The offset that the value will be written.
     *
     * @return void
     */
    public function writeInt($value, $offset)
    {
        $this->insert('N', $value, $offset, 4);
    }

    /**
     * Writes an unsigned big endian short.
     *
     * @param short $value  The value that will be written.
     * @param int   $offset The offset that the value will be written.
     *
     * @return void
     */
    public function writeShort($value, $offset)
    {
        $this->insert('n', $value, $offset, 2);
    }

    /**
     * Reads a unsigned integer with little endian.
     *
     * @param int $offset The offset that will be read.
     *
     * @return int The value that is at the specified offset.
     */
    public function readUIntLE($offset)
    {
        return $this->extract('I', $offset, 3);
    }

    /**
     * Writes a char.
     *
     * @param char $value  The value that will be written.
     * @param int  $offset The offset that the value will be written.
     *
     * @return void
     */
    public function writeChar($value, $offset)
    {
        $this->insert('c', $value, $offset, $this->lengthMap->getLengthFor('c'));
    }

    /**
     * Writes raw binary to the buffer.
     *
     * @param binary $value  The value that will be written.
     * @param int    $offset The offset that the value will be written at.
     *
     * @return void
     */
    public function writeRaw($value, $offset)
    {
        $this->buffer[$offset] = $value;
    }

    /**
     * Writes a binary string to the buffer.
     *
     * @param string $value  The value that will be written.
     * @param int    $offset The offset that the value will be written at.
     *
     * @return void
     */
    public function writeRawString($value, $offset)
    {
        for ($i = 0; $i < strlen($value); ++$i) {
            $this->buffer[$offset++] = $value[$i];
        }
    }

    /**
     * Gets an attribute via key. Used for ArrayAccess.
     *
     * @param mixed $key The attribute key.
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->buffer[$key];
    }

    /**
     * Checks if an attribute exists via key. Used for ArrayAccess.
     *
     * @param mixed $key The attribute key.
     *
     * @return bool Whether the offset exists.
     */
    public function offsetExists($key)
    {
        return isset($this->buffer[$key]);
    }

    /**
     * Sets an attribute via key. Used for ArrayAccess.
     *
     * @param mixed $key   The attribute key.
     * @param mixed $value The attribute value.
     *
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->buffer[$key] = $value;
    }

    /**
     * Unsets an attribute via key. Used for ArrayAccess.
     *
     * @param string $key The attribute key.
     *
     * @return void
     */
    public function offsetUnset($key)
    {
        if (isset($this->buffer[$key])) {
            unset($this->buffer[$key]);
        }
    }
}
