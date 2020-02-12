<?php


class Game
{
       private $title;
       private $date;
       private $url;
        
       private $players;

    function Game($ti,$da,$ur)
    {
        $this->title = $ti;
        $this->date = $da;
        $this->url = $ur;



    }
    function setParticipant($plays)
    {
            $this->players = $plays;

    }
    function getXpGainOf($player)
    {
        return $this->players[$player];
    }
}


?>
