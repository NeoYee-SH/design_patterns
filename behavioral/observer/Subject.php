<?php

namespace behavioral\observer;


abstract class Subject
{
    /**
     * @var array
     */
    private $observers = [];
    public $user;

    public function attach(Observer $observer):void {
        $this->observers[] = $observer;
    }

    public function detach(Observer $observer):void {
        $key = array_search($observer, $this->observers);
        if ($observer === $this->observers[$key]) {
            unset($this->observers[$key]);
        }
    }

    public function notify():void {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}