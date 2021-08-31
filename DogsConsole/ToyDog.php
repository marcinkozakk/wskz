<?php

abstract class ToyDog implements Dogs
{
    public function hunt()
    {
        return "- It's just a toy, it can't hunt";
    }
}