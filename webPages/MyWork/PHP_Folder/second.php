<?php
class std{
    public $name;
    public $age;

    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }

    public function displayinfo(){
        return "This is a {$this->name} and age is {$this->age}";
    }
    
    public function __call($name, $arguments): void {
        if($name == "setDetails"){
            if(count($arguments) == 1){
                $this->name = $arguments[0];
            }
            elseif(count($arguments) == 2){
                $this->name = $arguments[0];
                $this->age = $arguments[1];
            }
        }
        
    }
}

$data = new std("Urval",19);
echo $data->displayinfo();
echo "<br>";

$data ->setDetails("Dev");
echo $data->displayinfo();
echo "<br>";