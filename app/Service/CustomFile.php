<?php

namespace Service;

use Upload\Storage\FileSystem;
// use Upload\File;

class CustomFile extends FileSystem
{

  public function getDirectory()
  {
    return $this->directory;
  }
}
