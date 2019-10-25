<?php

namespace behavioral\observer;


interface Observer
{
    public function update(Subject $subject);
}