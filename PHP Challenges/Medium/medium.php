<?php

$suits = array (
"Clubs",
"Diamonds",
"Hearts",
"Spades"
);

$faces = array (
  "Ace" => 1,
  "2" => 2,
  "3" => 3,
  "4" => 4,
  "5" => 5,
  "6" => 6,
  "7" => 7,
  "8" => 8,
  "9" => 9,
  "10" => 10,
  "Jack" => 11,
  "Queen" => 12,
  "King" => 13
);

$user1 = [];
$deck = [];

function deckShuffler($deck) {
  $keys = array_keys($deck);
  shuffle($keys);
  return array_merge(array_flip($keys), $deck);
}

function deckDealer($numOfCards) {
  global $deck;
  $cardsToDeal = [];

  for ($i = 0; $i < $numOfCards; $i++) {
    $cardKeys = array_keys($deck);
    $topCardName = $cardKeys[0];
    $topCardValue = array_shift($deck);
    $cardsToDeal[$topCardName] = $topCardValue;
  }

  return $cardsToDeal;
}


//populate deck with cards
foreach($suits as $suit){
  foreach($faces as $face => $value){
    $deck["$face of $suit"] = $value;
  }
}

$deck = deckShuffler($deck);

echo "</br>Size of Deck: </br>";
echo sizeof($deck);

$user1 = array_merge($user1, deckDealer(2));
echo "</br></br>User1 Hand:";
echo "<pre>";
print_r($user1);
echo "</pre>";

echo "</br></br>Size of Deck after dealing: </br>";
echo sizeof($deck);

?>



<!--
MEDIUM:
Let’s bring in the deck code from the past example (your normal challenge).
Create a function that will create a deck of cards, randomize it and then return the deck.
We will now create a function to deal these cards to each user.
Modify this function so that it returns the number of cards specified for the user.
 Also, it must modify the deck so that those cards are no longer available to be distributed.
 -->
