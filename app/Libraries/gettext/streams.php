<?php

/*
   Copyright (c) 2003, 2005, 2006, 2009 Danilo Segan <danilo@kvota.net>.

   This file is part of PHP-gettext.

   PHP-gettext is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.

   PHP-gettext is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with PHP-gettext; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/


  // Simple class to wrap file streams, string streams, etc.
  // seek is essential, and it should be byte stream
class StreamReader
{
  // should return a string [FIXME: perhaps return array of bytes?]
    public function read($bytes)
    {
        return false;
    }

  // should return new position
    public function seekto($position)
    {
        return false;
    }

  // returns current position
    public function currentpos()
    {
        return false;
    }

  // returns length of entire stream (limit for seekto()s)
    public function length()
    {
        return false;
    }
}

class StringReader
{
    private $pos;
    private $str;

    public function __construct($str = '')
    {
        $this->str = $str;
        $this->pos = 0;
    }

    public function read($bytes)
    {
        $data = substr($this->str, $this->pos, $bytes);
        $this->pos += $bytes;
        if (strlen($this->str) < $this->pos) {
            $this->pos = strlen($this->str);
        }

        return $data;
    }

    public function seekto($pos)
    {
        $this->pos = $pos;
        if (strlen($this->str) < $this->pos) {
            $this->pos = strlen($this->str);
        }
        return $this->pos;
    }

    public function currentpos()
    {

        return $this->pos;
    }

    public function length()
    {

        return strlen($this->str);
    }
}


class FileReader
{
    public $pos;
    private $fd;
    private $length;

    public function __construct($filename)
    {
        if (file_exists($filename)) {
            $this->length = filesize($filename);
            $this->pos = 0;
            $this->fd = fopen($filename, 'rb');
            if (!$this->fd) {
                    $this->error = 3;
                    // Cannot read file, probably permissions
                      return false;
            }
        } else {
            $this->error = 2;
        // File doesn't exist
                return false;
        }
    }

    public function read($bytes)
    {
        if ($bytes) {
            fseek($this->fd, $this->pos);
  // PHP 5.1.1 does not read more than 8192 bytes in one fread()
          // the discussions at PHP Bugs suggest it's the intended behaviour
            $data = '';
            while ($bytes > 0) {
                    $chunk  = fread($this->fd, $bytes);
                    $data  .= $chunk;
                    $bytes -= strlen($chunk);
            }
            $this->pos = ftell($this->fd);
            return $data;
        } else {
            return '';
        }
    }

    public function seekto($pos)
    {
        fseek($this->fd, $pos);
        $this->pos = ftell($this->fd);
        return $this->pos;
    }

    public function currentpos()
    {
        return $this->pos;
    }

    public function length()
    {
        return $this->length;
    }

    public function close()
    {
        fclose($this->fd);
    }
}

// Preloads entire file in memory first, then creates a StringReader
// over it (it assumes knowledge of StringReader internals)
class CachedFileReader extends StringReader
{
    public function __construct($filename)
    {
        if (file_exists($filename)) {
            $length = filesize($filename);
            $fd = fopen($filename, 'rb');
            if (!$fd) {
                    $this->error = 3;
                    // Cannot read file, probably permissions
                      return false;
            }
            $this->str = fread($fd, $length);
            fclose($fd);
        } else {
            $this->error = 2;
        // File doesn't exist
                return false;
        }
    }
}
