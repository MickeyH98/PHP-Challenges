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

$players = [
  "user1" => [],
  "user2" => [],
  "user3" => [],
  "user4" => []
];

$deck = [];

//populate deck with cards
foreach($suits as $suit){
  foreach($faces as $face => $value){
    $deck["$face of $suit"] = $value;
  }
}

//shuffle deck
function deckShuffler($deck) {
  $keys = array_keys($deck);
  shuffle($keys);
  return array_merge(array_flip($keys), $deck);
}

//deal $numOfCards to user
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

$deck = deckShuffler($deck);

$num_cards_in_deck = sizeof($deck);
$num_of_players= sizeof($players);
$num_cards_to_give_each_player = ($num_cards_in_deck / $num_of_players);


//& = by reference, aka direct mutation of $player
foreach($players as &$player){
  //deal cards to all players
  $player = array_merge($player, deckDealer($num_cards_to_give_each_player));
}

$game = [];

function topCardCompare($i){
  global $players;
  global $game;

  //to get card value
  $currentRound = [];
  //to get card name
  $currentRoundCardNames = [];

  //& = by reference, aka direct mutation of $player
  foreach($players as &$player){

    $keys = array_keys($player);
    //get card name
    $topCardName = array_shift($keys);
    //get card value
    $topCardValue = array_shift($player);

    array_push($currentRound, $topCardValue);
    array_push($currentRoundCardNames, $topCardName);
  }

  //get highest value from $currentRound array
  $winNum = max($currentRound);

  //set winner variables
  foreach($currentRound as $index => $value){
    $currentRoundCopy = $currentRound;
    unset($currentRoundCopy[$index]);

    //check for draw
    if(in_array($value, $currentRoundCopy)){
      $winningPlayer = "Draw";
      $winningCardName = $currentRoundCardNames[$index];
      $winningCardValue = $value;
    }elseif($value == $winNum){
      //get name and value of card
      $winningPlayer = "Player " . ($index+1) . " Wins!";
      $winningCardName = $currentRoundCardNames[$index];
      $winningCardValue = $value;
    }
  }

  $winningCard = [
    "Result" => $winningPlayer,
    "Card Name" => $winningCardName,
    "Card Value" => $winningCardValue
  ];
  $roundNum = $i + 1;
  $game["Round " . $roundNum] = $winningCard;
}

for ($i = 0; $i < $num_cards_to_give_each_player; $i++){
  topCardCompare($i);
}

echo "<pre>";
print_r($game);
echo "</pre>";

?>

<!-- HARD:
Bring in your createDeck and dealCards function from the previous challenges.
For the specified number of players below, assign each player an even set of cards.
We will do this by counting out how many players there are,
counting how many cards are in the deck and then dividing them so we know how many cards each player should get.
  */
  $deck =
  $num_players = 4;
  $num_cards_in_deck = //find a function to count the # of elements in an array
  $num_cards_to_give_each_player =
  /*
Use a for loop to add the "dealt hands" to the $players array
Let’s create a simple game. Each player will play a card and whoever has the highest value wins.
If there are 2 cards played that have the same value, everyone loses and that round is a draw.
Store the results of each game and also who won that round as the value.
If the round is a draw, store the value as DRAW.
Use a loop to play each game until all opponents are out of cards.
Print out the array of all the rounds. If there was a draw, the round should say DRAW.
If a player has won, it should display “Player X” where X is the index of the player. -->
