<link href='./styles.css' rel='stylesheet'>

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

echo "<body>";

echo "<h1>Blackjack</h1>";

$deck = deckShuffler($deck);

$playerMoney = 1000;

//deal first 4 cards
$player = array_merge([], deckDealer(2));
$dealer = array_merge([], deckDealer(2));

$counter = 0;
$playerBlackjacks = 0;
$dealerBlackjacks = 0;
$bankHalfway = null;

//while deck has cards
while(sizeof($deck) > 4 && $playerMoney > 0){

  if($playerMoney == 500 && isset($counter) == false){
    $bankHalfway = $counter;
  }

  $counter++;
  echo "<div class='turnDiv'>";
  echo "</br><h2>-Turn " . $counter . "-</h2>";
  echo "</br>Deck size: ";
  echo sizeof($deck);
  echo "</br>Player Money: $" . $playerMoney;
  $playerSum = array_sum($player);
  $dealerSum = array_sum($dealer);
  echo "</br>Player has " . $playerSum;
  echo "</br>Dealer has " . $dealerSum;
  echo "</br>";

  //if player <= 21
  if($playerSum < 21 && $dealerSum < 21){
    //player draw a card
    $player = array_merge($player, deckDealer(1));
    echo "</br>Player drew a card";
    foreach($player as $card){
      $playerHandValues = array_values($player);
    }
    echo "</br>Player's new hand: ";
    $playerSum = array_sum($playerHandValues);
    echo $playerSum;
  }


  //if dealer <= 17
  if($dealerSum <= 17 && $playerSum < 21){
    //dealer draw a card
    $dealer = array_merge($dealer, deckDealer(1));
    echo "</br>Dealer drew a card";
    foreach($dealer as $card){
      $dealerHandValues = array_values($dealer);
    }
    echo "</br>Dealer's new hand: ";
    $dealerSum = array_sum($dealerHandValues);
    echo $dealerSum;
  }


  //if dealer == player or dealer > 21 and player > 21
  if($dealerSum == $playerSum || $dealerSum > 21 && $playerSum > 21){
    //no one wins
    echo "</br>Nobody wins!";
    //reset hands
    echo "</br>Reset Hands";
    $player = array_merge([], deckDealer(2));
    $dealer = array_merge([], deckDealer(2));
  }
  //else if dealer == 21 and player == 21
  else if($dealerSum == 21 && $playerSum == 21){
    //draw
    echo "</br>Draw!";
    //reset hands
    echo "</br>Reset Hands";
    $player = array_merge([], deckDealer(2));
    $dealer = array_merge([], deckDealer(2));
  }


  //if player > dealer
  if($playerSum > $dealerSum){
    //if player > 21
    if($playerSum > 21){
      //dealer wins
      echo "</br>Player Bust, Dealer Wins!";
      $playerMoney = $playerMoney - 100;
      //reset hands
      echo "</br>Reset Hands";
      $player = array_merge([], deckDealer(2));
      $dealer = array_merge([], deckDealer(2));
    }
    //else if player == 21
    else {
      if($playerSum == 21){
        //Blackjack
        echo "</br>Player's Blackjack!";
        $playerBlackjacks = $playerBlackjacks + 1;
        $playerMoney = $playerMoney + 200;
        //reset hands
        echo "</br>Reset Hands";
        $player = array_merge([], deckDealer(2));
        $dealer = array_merge([], deckDealer(2));
      }
    }
  }


  //if dealer > player
  if($dealerSum > $playerSum){
    //if dealer > 21
    if($dealerSum > 21 && $playerSum < 21){
      //player wins
      echo "</br>Dealer Bust, Player Wins!";
      $playerMoney = $playerMoney + 200;
      //reset hands
      echo "</br>Reset Hands";
      $player = array_merge([], deckDealer(2));
      $dealer = array_merge([], deckDealer(2));
    }
    //else if dealer == 21
    else {
	    if($dealerSum == 21){
      	//Blackjack
        echo "</br>Dealer's Blackjack!";
        $dealerBlackjacks = $dealerBlackjacks + 1;
        $playerMoney = $playerMoney - 100;
        //reset hands
        echo "</br>Reset Hands";
        $player = array_merge([], deckDealer(2));
        $dealer = array_merge([], deckDealer(2));
  	  }else if($dealerSum > 21){
        //dealer bust, player win
        echo "</br>Dealer Bust, Player Wins!";
        $playerMoney = $playerMoney + 200;
        //reset hands
        echo "</br>Reset Hands";
        $player = array_merge([], deckDealer(2));
        $dealer = array_merge([], deckDealer(2));
      }
	  }
  }else if($playerSum > $dealerSum && $dealerSum >= 17 && $playerSum <= 21){
    //player wins
    echo "</br>Player Wins!";
    $playerMoney = $playerMoney + 200;
    //reset hands
    echo "</br>Reset Hands";
    $player = array_merge([], deckDealer(2));
    $dealer = array_merge([], deckDealer(2));
  }
  echo "</div>";
}

$winner;
if($playerMoney > 1000){
  $winner = "Player";
}else if($playerMoney < 1000){
  $winner = "Dealer";
}else{
  $winner = "No one";
}


echo "<div class='resultsDiv'>";
echo "<h2 class='resultsHeader'>Results</h2>";
echo "</br>";
echo "<p>Games Played: " . $counter . "</p>";
echo "<p>Winner: " . $winner . "</p>";
echo "<p>Player Money: $" . $playerMoney . "</p>";
if(isset($bankHalfway)){
  echo "<p>Player reached $500 at: " . $bankHalfway . "</p>";
}else{
  echo "<p>Player never reached $500 </p>";
}
echo "<p>Player Blackjacks: " . $playerBlackjacks . "</p>";
echo "<p>Dealer Blackjacks: " . $dealerBlackjacks . "</p>";
echo "</div>";
echo "</body>";

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
