############################################   SW Code Test  ###########################################################


I've implemented one extra Scenario in which no body worked alone in a whole day and it includes 3 people

  
      Wolverine: /---------/
      Gamora:              /---------/
      BW:       /--------------------/
      
Given Wolverine, Gamora and Black Widow working at FunHouse on Friday
When Wolverine worked for first half
And  Gamora worked for first half
And  BW working full day
Then No one recieves a Single manning reward.







Steps to test the application : 

1) Create mysql databse with following connection constants :
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=sw_test
    DB_USERNAME=root
    DB_PASSWORD=123

2) Run Migration "php artisan migrate"
3) Run Seeders 
        php artisan db:seed --class=RotaSeeder
        php artisan db:seed --class=StaffSeeder
        php artisan db:seed --class=ShiftSeeder
        php artisan db:seed --class=ShiftBreakSeeder

4) Run unit tests  "./vendor/bin/phpunit"