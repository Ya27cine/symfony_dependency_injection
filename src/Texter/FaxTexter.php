<?php

namespace App\Texter;

class FaxTexter implements TexterInterface
{
    public function send(Text $text)
    {
        dump("ENVOI D'UN FAX :", $text);
    }
}
