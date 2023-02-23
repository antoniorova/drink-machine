# Coffee Machine Project Kata

Project based on http://simcap.github.io/coffeemachine/index.html

Developed using DDD, Hexagonal Architecture and TDD. Passing the highest level of static analysis of psalm and phpstan. Also passing the Mutation Testing.

Build it in 3 iterations:

### First iteration: Making Drinks

The task is to implement the logic (starting from a simple class) that translates orders from customers of the coffee machine to the drink maker. The code will use the drink maker protocol to send commands to the drink maker.

The coffee machine can serves 3 type of drinks: tea, coffee, chocolate.

### Second iteration: Going into business

The coffee machine is not free anymore! One tea is 0,4 euro, a coffee is 0,6 euro, a chocolate is 0,5 euro.

The drink maker will now only make a drink if enough money is given for it

### Third iteration: Extra hot

The machine has been upgraded and the drink maker is now able to make orange juice and to deliver extra hot drinks. The code is updated to send the correct messages to the drink maker so that users can have orange juices or extra hot drinks

The implementation must be flexible enough to welcome those changes with not too much hassle.