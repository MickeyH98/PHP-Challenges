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

//create player and dealer hands
$dealer = [];
$player = [];
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

$playerMoney = 1000;

//while deck has cards
while(sizeof($deck) > 0 && $playerMoney > 0){
  echo "</br></br>-Turn Start-";
  echo "</br>Player Money: " . $playerMoney;
  $player = array_merge([], deckDealer(2));
  $dealer = array_merge([], deckDealer(2));

  $playerHandValuesSum = array_sum($player);
  $dealerHandValuesSum = array_sum($dealer);
  echo "</br>Player Sum: " . $playerHandValuesSum;
  echo "</br>Dealer Sum: " . $dealerHandValuesSum;

  if($playerMoney > 0){

    //if playerhand > 21, dealer Wins
    if($playerHandValuesSum > 21){
      echo "</br>Player over 21, Dealer Wins!";
      $playerMoney = $playerMoney - 100;

    //if dealerhand > 21, player wins
    }else if($dealerHandValuesSum > 21){
      echo "</br>Dealer over 21, Player Wins!";
      $playerMoney = $playerMoney + 200;

    //if playerhand <= dealerhand, player Draw
    }else if($playerHandValuesSum <= $dealerHandValuesSum){
      //player draw a card
      $player = array_merge($player, deckDealer(1));
      echo "</br>Player drew a card";
      foreach($player as $card){
        $playerHandValues = array_values($player);
      }
      echo "</br>Player Hand Values: ";
      $playerHandValuesSum = array_sum($playerHandValues);
      echo $playerHandValuesSum;

    //if playerhand > dealerhand, dealer draw
    }else if($playerHandValuesSum > $dealerHandValuesSum){
      //dealer draw a card
      $dealer = array_merge($dealer, deckDealer(1));
      echo "</br>Dealer drew a card";
      foreach($dealer as $card){
        $dealerHandValues = array_values($dealer);
      }
      echo "</br>Dealer Hand Values: ";
      $dealerHandValuesSum = array_sum($dealerHandValues);
      echo $dealerHandValuesSum;
    }
  }
}

echo "</br></br>";
echo "Deck size: ";
echo sizeof($deck);

?>

<!-- INSANE CHALLENGE:
Create a game of Blackjack.
Rules:
1. At any given time, there will only be two players. The dealer and player one.
2. 4 cards will be dealt out each round, 2 to the dealer and 2 to the player.
3. If the amount in the player’s hand is less than or equal to the amount in the dealer’s hand, you must draw a card.
4. If the player draws a card and the amount they have goes over 21, the dealer has won that round.
5. If the player ever reaches an amount greater than the dealer’s, they should stay then it will be the dealer’s turn.
6. The dealer must draw until he reaches an amount greater than the player’s or until he loses.
7. Subtract $100 from the player’s bank every time they lose
8. Add $200 to the player’s bank every time they win
9. Player starts with $1000 in the bank account
10. Aces can either be an 11 or 1
The game will continue as long as there are enough cards in the deck OR the player runs out of money.
Output:
1. How many games were played?
2. Who won the game?
3. Which round did the player’s bank reach half way?
4. How many times did the player get blackjack? -->
