# Kumu Backend Exam 
##### Prepared By: Melchizedek Ang

The API is written in the Laravel Lumen PHP Framework.
See laravel.com/docs for the Laravel documentation.

## Requirements

- [Docker](https://docs.docker.com/engine/install/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## API Project Setup 

#### 1. Navigate to api folder. Copy .env.example to .env file

```bash 
cp .env.example .env
```

#### 2. Start the Docker environment.

```bash
docker-compose build
docker-compose up -d 
```

#### 3. To initiate the project. Run the following commands:

```bash  
docker-compose exec api infrastructure/dev/scripts/initiate-project.sh 
```
##### The api runs in: http://localhost:8080
 
#### Running all tests:
```bash
docker-compose exec api vendor/phpunit/phpunit/phpunit
``` 

#### Entering to docker container:
```bash
docker-compose exec api bash
``` 

# BONUS EXAM ANSWER
```
exam


<?php
	
	function calculate($x, $y) {
	  $distance =0;
	  $binX = decbin($x);
	  $binY = decbin($y);
	  $splittedX =str_split($binX);
	  $splittedY =str_split($binY);
	  $countX = count($splittedX);
	  $countY = count(str_split(decbin($y)));
	  if($countY > $countX) {
      $binX = str_repeat(0, ($countY- $countX)).$binX;
      $countX = count(str_split($binX));
	    $splittedX =str_split($binX);
	  } else if ($countY < $countX){
	    $binY = str_repeat(0, ($countX- $countY)).$binY;
	    $splittedY =str_split($binY);
	  }
	  for ($i = 0; $i <$countX; $i++) {
	    if($splittedX[$i] != $splittedY[$i]) $distance++;
	  }
	  return $distance;
	}
  echo calculate(1,4);
?>
``` 